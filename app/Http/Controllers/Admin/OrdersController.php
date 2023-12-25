<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaction;
use App\Models\Courier;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Session, Hashids, DataTables;
use App\Models\Email;
use App\Models\TaxRate;
use App\Models\ShoppingCartHistory;
use App\Models\OrderUser;
use function foo\func;
use Log;

class OrdersController extends Controller
{

    public $resource = 'admin/orders';

    public function __construct()
    {
        //$this->middleware('permission:view orders', ['only' => ['index']]);
        $this->middleware('permission:change order status', ['only' => ['changStatus']]);
        $this->middleware('permission:view order invoice', ['only' => ['show']]);
        $this->middleware('permission:change order invoice courier', ['only' => ['updateProductCourier']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
       
        if ($request->ajax()) {

            $id = $request->input('user_id');
            $type = ($request->filled('type')) ? $request->type : 'customer_order';
            
            $orders = Transaction::with(['cart.user', 'purchasedItems.product.product_images'])->where('type', $type)->dateFilter();
            if ($request->filled('payment_method')) {
                $orders->where('payment_method', $request->payment_method);
            }
            
            if ($id) {
                $user_id = decodeId($id);
                $orders =$orders->whereUserId($user_id)->orderBy('id', 'desc');
            } else {
                $orders =$orders->orderBy('id', 'desc');
            }

            return Datatables::of($orders)
                ->addColumn('orders_details', function ($order) {
                    return '<span class="details-control"></span>';
                })
                ->addColumn('orderId', function ($order) {
                    return "<u><a href = 'javascript:void(0)' onclick='load_model(" . '"' . $order->paypal_id . '"' . ")'>" . $order->paypal_id . "</a></u>";
                })
                ->addColumn('email', function ($email) {
                    $color = '';

                    if($email['is_latest']){
                        $color='red';
                    }else{
                        $color ='black';
                    }
                    $email = $email->cart->user->email??'';
                    return "<a style='color: $color'>$email</a>";
                })
                ->addColumn('amount', function ($order) {
                    $color ='';
                    if($order['is_latest']){
                        $color='red';
                    }else{
                        $color ='black';
                    }
                    $amount = $order->amount > 0 ? $order->amount : 0;
                    return "<a style='color: $color'>".'£'.".$amount</a>";
                })
                ->addColumn('barcode_image', function ($order) {
                    $user =  User::where('id',$order->user_id)->first();

                    if($user and $order->label_image and $user->type !='wholesaler'){
                        return '<a href="'.url($order->label_image).'" download><img src="'.url($order->label_image).'" alt="'.$order->label_image.'" width="100" height="200"></a>';
                    }else{
                        return '';
                    }
                })
                ->addColumn('status', function ($order) {

                        $options = '<option value="">Select Status</option>';


                         $cartid=$order->cart['id'];
                         $transaction_id = $order->id;
                        foreach (['pending','dispatched','delivered'] as $value){
                             $selected ='';
                             if($value ==='pending'){
                                  $selected = ($order->cart and $order->cart->delivery_status == "pending") ? "selected" : "";

                             }

                             if ($value ==='dispatched'){
                                 $selected = ($order->cart and $order->cart->delivery_status == "dispatched") ? "selected" : "";

                             }

                             if($value ==='delivered'){
                                   $selected = ($order->cart and $order->cart->delivery_status == "delivered") ? "selected" : "";
                             }

                            $options.=' <option   '.$selected.' value='.$value.'>'.$value.'</option>';
                        }

                      return '<select name="status" class="status_update" data-id='.$cartid.' data-transaction-id='.$transaction_id.'>
                               ' . $options . '
                            </select>';

                })
                ->addColumn('courier_service', function ($order) {
                        $couriers = Courier::all();
                        $options = '<option value="">Select Courier</option>';

                       $user =  User::where('id',$order->user_id)->first();

                        foreach ($couriers as $value){
                            $selected='';
                            $disabled='';
                            if(!empty($value->type) and $value->type === $order->courier_type){
                                $selected="selected";
                            }
                            if(empty($value->type)){
                                $disabled='disabled';
                            }
                            $options.=' <option  '.$disabled.' '.$selected.' value='.$value->id.'>'.$value->name.'</option>';
                        }

                        if($user and $user->type !='wholesaler') {
                            $hashid = ($order->cart !=null)?$order->cart["hashid"]:"";
                            return '<select name="status" class="courier_send" data-id="' . $hashid . '" data-cart-id="' . Hashids::encode($order->id) . '">
                               ' . $options . '
                            </select>';
                        }else{
                            return '';
                        }

                })
                ->addColumn('action', function ($order) {
                    $label='';
                    if($order->label_image){
                        $label = url($order->label_image);
                    }
                    $action = '';

                    $action .='<a href="orders/' . Hashids::encode($order->id) . '" class="text-success btn-order" data-toggle="tooltip" title="View Invoice"><i class="fa fa-eye fa-lg"></i></a>';
                    $action .='<a href="' .url('admin/update-status-order/'.Hashids::encode($order->id) ). '" class="text-success btn-order" data-toggle="tooltip" title="Update Status"><i class="fa fa-edit"></i></a>';
                     $action .='<a href="' .url('admin/update-delivery-status/'.Hashids::encode($order->cart_id) ). '" class="text-success btn-order" data-toggle="tooltip" title="Update Delivery Status"><i class="fa fa-edit"></i></a>';

                    if(!empty($label)){
                        $action .='|<a href="javascript:void(0)" image-url="'.$label.'" class="text-success bt-download" data-toggle="tooltip" title="Download"><i class="fa fa-print fa-lg"></i></a>';
                    }
                    return $action;
                })
                ->rawColumns(['discounted_price','amount', 'orders_details', 'orderId', 'email', 'status', 'action','barcode_image','courier_service'])
                ->make(true);
        }

        return view($this->resource . '/index');
    }

    /**
     * change status
     *
     *
     */
    public function changStatus(Request $request)
    {
        $id = decodeId($request->id);

        ShoppingCart::where('id', $id)->update(['delivery_status' => $request->status]);
        return 'true';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view($this->resource . '/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $id = decodeId($id);

        $couriers = Courier::pluck('name', 'id')->prepend('Select Courier', '');
        $order = Transaction::with(['cart', 'purchasedItems.product.product_images'])->find($id);

        $vatCharges = TaxRate::select('rate')->where('id',1)->first();
        $vatCharges = (int)$vatCharges->rate;


        return view($this->resource . '/invoice', compact('order', 'couriers','vatCharges'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
    }

    /**
     * change status
     *
     *
     */
    public function updateProductCourier(Request $request)
    {
        $cart = ShoppingCart::where('id', $request->cart_id)->first();
        if ($cart) {
            $cart_details = [];
            $products = unserialize($cart->cart_details);
            foreach ($products as $product) {
                if ($product['id'] == $request->product_id) {
                    unset($product['courier']);
                    if ($request->courier_id > 0)
                        $product['courier'] = Courier::find($request->courier_id)->toArray();

                    $cart_details[] = $product;
                } else {
                    $cart_details[] = $product;
                }
            }
            $cart->cart_details = serialize($cart_details);
            $cart->save();
        }

        return 'true';
    }

    public function changeCourier()
    {
        $courier = Courier::where('id',request()->status)->first();

        $cartid = decodeId(\request()->cart_id);
        switch ($courier->type){
            case 'hermes';
                return $this->hermesCourierSystem($cartid,$courier->type);
                break;
            default:
                return 'false';
        }
    }

    public function hermesCourierSystem($cartid,$type)
    {

        $order = Transaction::with(['cart', 'purchasedItems.product.product_images'])->find($cartid);
        $cart = @$order->cart;
        $user = unserialize(@$cart->user_details);

        $dataRecive = (new \App\Http\Controllers\HomeController())->createParcel($user);

        Transaction::where('id', $cartid)->update([
            'barcode' => $dataRecive['barcode'],
            'label_image' => $dataRecive['image'],
            'courier_type' => $type
        ]);
        return 'true';
    }

    public function orderPrint($id)
    {
        $id = decodeId($id);


        $couriers = Courier::pluck('name', 'id')->prepend('Select Courier', '');
        $order = Transaction::with(['cart', 'purchasedItems.product.product_images'])->find($id);

         $vatCharges=TaxRate::select('rate')->where('id',1)->first();
        $vatCharges=(int)$vatCharges->rate;
        return view($this->resource . '/invoice-print', compact('order', 'couriers','vatCharges'));
    }

    public function updateOrderStatus($id) {

         $cart = ShoppingCart::where('id', $id)->first();
         $cart->delivery_status = request()->status;
         $cart->save();
         $status = request()->status;
         $userData = User::whereId($cart->user_id)->first();
         $url =   url('/get-invoice-detail',Hashids::encode(request()->transaction_id));
         $user = 'khaleelrehman110@gmail.com';
         $data = [
            'email_from'    => 'baadrayltd@gmail.com',
            'email_to'      => $userData->email,
            'email_subject' => 'Order Delivery',
            'user_name'     => 'User',
            'final_content' => "<p><b>Dear User</b></p>
                                    <p>Your Order has been $status</p><br><a href='$url'>Click Here For Invoice</>",
        ];

         $data1 = [
            'email_from'    => 'baadrayltd@gmail.com',
            'email_to'      => 'aqsintetrnationalstore@gmail.com',
            'email_subject' => 'Order Delivery',
            'user_name'     => 'User',
            'final_content' => "<p><b>Dear Admin</b></p>
                                    <p>An Order is been $status</p>",
        ];
         
        try{
            Email::sendEmail($data);
        }
        catch(Exception $e)
        {
            Log::error('Order Email error: ' . $e->getMessage());
        } 
         
        try{
            Email::sendEmail($data1);
        }
        catch(Exception $e)
        {
            Log::error('Order Email error: ' . $e->getMessage());
        }
        
        return 'true';
    }

    public function updateInvoice(Request $request)
    {
        $productsName = $request->product_name;
        $productId = $request->product_id;
        $price = $request->price;
        $orderId = (int) $request->order_id;
        
        $data = array_map(function($pric,$prductname,$productid){
            return [
                'id' => $productid,
                'name' => $prductname,
                'price' => $pric,
            ];

        }, $price, $productsName, $productId);
        
        $transaction = Transaction::where('id', $orderId)
                ->update(['updated_columns' => json_encode($data)]);
        
        if ($transaction) {
            $transaction = Transaction::with('purchasedItems')->find($orderId);
            if ($transaction->type == 'wholesaler_order') {
                $quotationData = $transaction->toArray();
                
                $quotationData['cost'] = numberFormatToFloat($transaction->cost);
                $quotationData['cost_of_goods'] = numberFormatToFloat($transaction->cost_of_goods);
                $quotationData['discount'] = numberFormatToFloat($transaction->discount);
                $quotationData['tax'] = numberFormatToFloat($transaction->tax);
                $quotationData['amount'] = numberFormatToFloat($transaction->amount);
                
                $quotationData['user_id'] = 0;
                $user = User::find($transaction->user_id);
                if ($user) {
                    $orderUser = OrderUser::where('contact_no', $user->phone)->first();
                    if ($orderUser) {
                        $quotationData['user_id'] = $orderUser->id;
                    }
                }
                
                $quotationData['parent_id'] = $orderId;
                $quotationData['type'] = 'admin_order';
                unset($quotationData['created_at'], $quotationData['updated_at']);
                
                $quotation = Transaction::where(['parent_id' => $orderId, 'type' => 'admin_order'])->first();
                if ($quotation) {
                    $quotation->update($quotationData);
                } else {
                    $quotation = Transaction::create($quotationData);
                }
                
                ShoppingCartHistory::where('transaction_id', $quotation->id)->delete();
                if ($transaction->purchasedItems->count() > 0) {
                    foreach($transaction->purchasedItems as $shoppingCartHistory) {
                        $shoppingCartHistory = $shoppingCartHistory->toArray();
                        $shoppingCartHistory['transaction_id'] = $quotation->id;
                        unset($shoppingCartHistory['created_at'], $shoppingCartHistory['updated_at']);
                        ShoppingCartHistory::create($shoppingCartHistory);
                    }
                }
                
            }
        }
        
        return back()->with('success','Successfully updated');
    }


}
