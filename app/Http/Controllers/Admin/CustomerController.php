<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Hashids, DataTables;
use App\Models\User;
use Session;
use App\Models\UserWallet;
use App\Models\User2Pay;

class CustomerController extends Controller
{


    public function __construct()
   {
        //$this->middleware('permission:view customers', ['only' => ['index']]);
        //$this->middleware('permission:add customers', ['only' => ['create','store']]);
        //$this->middleware('permission:edit customers', ['only' => ['edit','update']]);
        //$this->middleware('permission:delete customers', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $customers = User::where('type','retailer');

            return Datatables::of($customers)
                ->addColumn('profile_image', function ($customer) {
                    return '<img width="30" src="'.checkImage('customers/thumbs/'. $customer->profile_image).'" />';
                })
                ->addColumn('action', function ($order) {
                    return '<a href="orders?user_id='. Hashids::encode($order->id).'" target="_blank" class="btn btn-xs btn-warning">Orders</a>';
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['profile_image','action'])
                ->make(true);

        }
        return view('admin.customers.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $reques)
    {
        if (!$reques->filled('type')) {
            return redirect()->back();
        }
        return view('admin.customers.create');
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
        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ]);

        $requestData = $request->all();
        $requestData['password'] = bcrypt($requestData['password']);

        $user = User::create($requestData);
        
        if ($request->type=='wholesaler') {
            Session::flash('success', 'Wholesaler added!');
            return redirect('admin/wholesalers');
        }
        Session::flash('success', 'Shopkeeper added!');
        return redirect('admin/shopkeepers');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
          
        $id = decodeId($id);
        
        $user = User::find($id);
        request()->request->add(['type' => $user->type]);            
        return view('admin.customers.edit', compact('user'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $id = decodeId($id);

        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|max:255',
        ]);

        $requestData = $request->all();

        $user = User::findOrFail($id);
        $user->update($requestData);

        if ($request->type=='wholesaler') {
            Session::flash('success', 'Wholesaler updated!');
            return redirect('admin/wholesalers');
        }
        Session::flash('success', 'Shopkeeper updated!');
        return redirect('admin/shopkeepers');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $id = decodeId($id);

        $user = User::find($id);

        if($user){
            $user->delete();
            $response['message'] = ucfirst($user->type) . ' deleted!';
            $status = $this->successStatus;
        }else{
            $response['message'] = ucfirst($user->type) . ' not exist against this id!';
            $status = $this->errorStatus;
        }

        return response()->json(['result'=>$response], $status);

    }
    
    public function retailerOrders(Request $request)
    {
        if($request->ajax()){
            $customers = User::where('type','retailer');

            if(!$request->filled('order')) {
                $customers->orderBy('updated_at', 'desc');
            }

            return Datatables::of($customers)
                ->addColumn('name', function ($customer) {
                    $name = $customer->first_name . ' ' . $customer->last_name;
                    $color ='black';
                    if($customer->is_latest){
                        $color='red';
                    }
                    return "<a style='color:$color'>$name</a>";
                })   ->addColumn('email', function ($customer) {
                    $name = $customer->email;
                    $color ='black';
                    if($customer->is_latest){
                        $color='red';
                    }
                    return "<a style='color:$color'>$name</a>";
                })
                ->addColumn('profile_image', function ($customer) {
                    return '<img width="30" src="'.checkImage('customers/thumbs/'. $customer->profile_image).'" />';
                })
                ->addColumn('action', function ($order) {
                    return '<a href="orders?user_id='. Hashids::encode($order->id).'" target="_blank" class="btn btn-xs btn-warning">Orders</a> | <a href="' . url('admin/update-status/retailer/'.Hashids::encode($order->id)). '"  class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>';
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['profile_image','action','name','email'])
                ->make(true);

        }
        return view('admin.customers.retailer_orders');
    }
    
    public function walletStatment($userId) {
        $userId = decodeId($userId);
        $user = User::findOrFail($userId);

        $balance = 0;

        $wallets = UserWallet::where('user_id', $userId);
        $walletBalance = UserWallet::where('user_id', $userId);
        
        if (request()->filled('start_date')) {
            $walletBalance->where('date', '<', request()->start_date);
            $balance = number_format($walletBalance->sum('credit') - $walletBalance->sum('debit'), 2, '.', '');
            
            $wallets->where('date', '>=', request()->start_date);
        }
        if (request()->filled('end_date')) {
            $wallets->where('date', '<=', request()->end_date);
        }

        $startDate = request()->start_date;
        $endDate = request()->end_date;

        $wallets = $wallets->orderBy('date', 'asc')->get();

        return view('admin.customers.wallet-statment', compact('startDate', 'endDate', 'user', 'wallets', 'balance', 'user'));
    }

    public function deleteWalletStatment ($id) {
        $wallet = UserWallet::find($id);
        if($wallet) {
            Transaction::where('id', $wallet->order_id)->delete();
            Quotation::where('transaction_id', $wallet->order_id)->delete();
            $wallet->delete();

            Session::flash('success', 'Wallet successfully deleted!');
        }

        return redirect()->back();
    }
    public function addWalletAmount(Request $request)
    {
        $data = [
            'date' => date('Y-m-d', strtotime(str_replace('/', '-', $request->date))),
            'note' => @$request->note,
            'user_id' => $request->id
        ];
        if (@$request->payment_type == '2pay') {
            $data['debit'] = abs($request->amount);
            $data['type'] = '2pay';
        } else  {
            $data['credit'] = abs($request->amount);
            $data['type'] = 'wallet';
        }
        //dd($data);
        UserWallet::create($data);

        return ['status' => true, 'message' => 'Successfully Inserted'];
    }
    
    public function add2PayAmount(Request $request)
    {
        User2Pay::create([
            'credit' => $request->amount,
            'date' => date('Y-m-d', strtotime($request->date)),
            'note' => @$request->note,
            'user_id' => $request->id
        ]);

        return ['status' => true, 'message' => 'Successfully Inserted'];
    }
}
