<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OrderUser;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

use App\Models\Transaction;
use App\Models\Courier;
use App\Models\VanStoreProduct;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartHistory;
use Illuminate\Http\Request;
use Session, Hashids, DataTables;
use App\Models\Email;
use App\Models\TaxRate;
use App\Models\Quotation;
use function foo\func;
use Carbon\Carbon;
use Log;

class VanStoreController extends Controller
{

    public $resource = 'admin/van-store';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {   
        $adminId = Auth::guard('admin')->id();
        if ($request->ajax()) {

            $products = VanStoreProduct::has('product')->with('product')->where('admin_id', $adminId);

            return Datatables::of($products)
                ->addColumn('action', function ($order) {
                    $action = '<a href="van-store/'.Hashids::encode($order->id).'" class="text-danger btn-delete" data-toggle="tooltip" title="Delete Product"><i class="fa fa-lg fa-trash"></i></a>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view($this->resource . '/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $customers = OrderUser::pluck('owner_name', 'id')->prepend('Select Customer', '');
        $products = Product::has('quantity')->pluck('name', 'code')->prepend('Select Product', '');
        
        return view($this->resource . '/create', get_defined_vars());
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
        $adminId = Auth::guard('admin')->id();
        $productQuantity = $request->product_quantity;
        foreach($request->product_id as $key => $productId) {
            $product = Product::with('tax_rate')->find($productId);
            if ($product) {
                $qty = isset($productQuantity[$key]) ? $productQuantity[$key] : 1;
                $productExist = VanStoreProduct::where([
                    'admin_id' => $adminId,
                    'product_id' => $productId,
                ])->first();
                
                
                if ($productExist) {
                    $productExist->update(['quantity' => ($productExist->quantity + $qty)]);
                } else {
                    VanStoreProduct::create([
                        'admin_id' => $adminId,
                        'product_id' => $productId,
                        'quantity' => $qty,
                    ]);
                }
                // remove product quantity from main store
                updateProductStockByData($productId, 1, $qty, 2, 6, 0, $adminId, 'Product move to store van');
                // Add product quantity to van store
                updateVanStoreProductStockByData($productId, $qty, 1, 1, 0, $adminId, 'Add Product');
            }
        }
        
        return response()->json([
            'success'  => true,
            'message'  => 'Products successfully created'
        ], $this->successStatus);
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

        $order = Transaction::with(['cart', 'purchasedItems.product.product_images'])->find($id);

        $vatCharges = TaxRate::select('rate')->where('id',1)->first();
        $vatCharges = (int)$vatCharges->rate;


        return view($this->resource . '/invoice', compact('order','vatCharges'));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getQuotation($id)
    {
        $id = decodeId($id);
        $quotation = Quotation::where('transaction_id', $id)->first();
        if (!$quotation) {
            $order = Transaction::with(['cart'])->find($id);
            
            $order->cart->user_details = unserialize($order->cart->user_details);
            $order->cart->cart_details = unserialize($order->cart->cart_details);
            
            $quotationData['transaction_id'] = $id;
            $quotationData['transaction_details'] = $order->toJson();
            Quotation::create($quotationData);
        }
        
        
        $quotation = Quotation::where('transaction_id', $id)->first();
        $order = json_decode($quotation->transaction_details);

        return view($this->resource . '/quotation-invoice', compact('order'));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateQuotation(Request $request)
    {
        $id = $request->order_id;
        $quotation = Quotation::where('transaction_id', $id)->first();
        
        if ($quotation) {
            $transactionDetails = json_decode($quotation->transaction_details);
            //$transactionDetails->cost = $request->subtotal;
            //$transactionDetails->discount = $request->discount;
            //$transactionDetails->tax = $request->tax;
            $transactionDetails->amount = $request->amount;
            //dd();
            foreach($request->products as $productKey => $product) {
                //dd($product);
                if (@$transactionDetails->cart->cart_details && count($transactionDetails->cart->cart_details)>0) {
                    foreach ($transactionDetails->cart->cart_details as $cartKey => $cart) {
                        if ($cart->id == $productKey) {
                            $productDetail = $transactionDetails->cart->cart_details[$cartKey];
                            $productDetail->name = $product['name'];
                            $productDetail->price = $product['price'];
                            $productDetail->quantity = $product['quantity'];
                            $productDetail->total = $product['total'];
                            break;
                        }
                    }
                }
            }
            $quotation->update(['transaction_details' => json_encode($transactionDetails)]);
            
            Session::flash('success', 'Quotation successfully updated!');  
        } else {
            Session::flash('error', 'Quotation not update!');  
        }
        
        return redirect('admin/admin-orders/quotation/' . Hashids::encode($id));
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
        $adminId = Auth::guard('admin')->id();
        $id = decodeId($id);
        $product = VanStoreProduct::find($id);
        if ($product) {
            // add product quantity to back
            updateProductStockByData($product->product_id, 1, $product->quantity, 1, 6, 0, $adminId, 'Product move back to products');
            // Add product quantity to van store
            updateVanStoreProductStockByData($product->product_id, $product->quantity, 2, 6, 0, $adminId, 'Delete Product');
        }

        $response['message'] = 'Product deleted!';
            $status = $this->successStatus;
        return response()->json(['result'=>$response], $status);
        
    }
    
    /**
     * Get Product Row
     */
    public function getProductRow($barcode = '')
    {
        $selectedProduct = false;
        if ($barcode != '') {
            $selectedProduct = true;
            $product = Product::has('quantity')->where('code', $barcode)->first();
            if ($product) {
                return response()->json([
                    'success'  => true,
                    'html'  => view($this->resource . '.selected-product-row', get_defined_vars())->render()
                ], $this->successStatus);
            }
        }

        if (!$selectedProduct) {
            $products = Product::has('quantity')->pluck('name', 'id')->prepend('Select Product', '');
        
        
            return response()->json([
                'success'  => true,
                'html'  => view($this->resource . '.product-row', get_defined_vars())->render()
            ], $this->successStatus);
        } else {
            return response()->json([
                'success'  => false,
            ], $this->successStatus);
        }
    }
    
    /**
     * Get Product Details
     * @param integer $id
     */
    public function getProductDetails($id)
    {
        $product = Product::with('quantity', 'tax_rate')->find($id);
        if ($product) {
            return response()->json([
                'success'  => true,
                'product'  => $product
            ], $this->successStatus);
        }
        
        return response()->json([
            'success'  => false,
        ], $this->successStatus);
    }
    
    /**
     * change status
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
    
    public function orderQuotationPrint($id)
    {
        $id = decodeId($id);
        $quotation = Quotation::where('transaction_id', $id)->first();
        $order = json_decode($quotation->transaction_details);

        return view($this->resource . '/invoice-quotation-print', compact('order'));
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

    public function updateInvoice()
    {
        $productsName = request()->product_name;
        $productId = \request()->product_id;
        $price = \request()->price;

        $data = array_map(function($pric,$prductname,$productid){
            return [
                'id' => $productid,
                'name' => $prductname,
                'price' => $pric,
            ];

        },$price,$productsName,$productId);
        Transaction::where('id',\request()->order_id)->update(['updated_columns' => json_encode($data)]);
        return back()->with('success','Successfully updated');
    }


}
