<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\UserWallet;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use App\User;
use Illuminate\Http\Request;
use Session,Hashids,DataTables,DB;

class ShopkeeperController extends Controller
{

   public function __construct()
   {
        $this->middleware('permission:view shopkeepers', ['only' => ['index']]);
        $this->middleware('permission:add shopkeepers', ['only' => ['create','store']]);
        $this->middleware('permission:edit shopkeepers', ['only' => ['edit','update']]);
        $this->middleware('permission:delete shopkeepers', ['only' => ['destroy']]);
    }

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        if($request->ajax()){
           
            $users = User::whereIn('type',['shopkeeper','wholesaler']);
            
             if(request()->search['value']){
                $users->where('name', 'LIKE', '%'.request()->search['value'].'%')->orWhere('customer_id','LIKE', '%'.request()->search['value'].'%')->orWhere('company_name','LIKE', '%'.request()->search['value'].'%');
            }

            if($request->filled('order')) {
                $orderBy = $request->order;
                if ($orderBy[0]['column'] == 1) {
                    $users->orderBy('first_name', $orderBy[0]['dir']);
                }
            } else {
                $users->orderBy('updated_at','desc');
            }
           
            return DataTables::of($users->get())
                ->addColumn('is_active', function ($user) {
                 $satatus = '<a class="btn btn-xs btn-danger">Inactive</a>';
                 if($user->is_active=="yes")
                    $satatus = '<a class="btn btn-xs btn-success">Active</a>';

                    return $satatus;
                })
                ->addColumn('wallet_amount', function ($user) {
                    return number_format(getWholsellerDataWallet($user->id),'2','.','');
                })
                // ->addColumn('2pay_amount', function ($user) {
                //     return number_format(get2PayAmount($user->id),'2','.','');
                // })
                ->addColumn('action', function ($user) {
                $action = '';
                if(Auth::user()->can('edit shopkeepers'))
                    $action .= '<a href="customers/'. Hashids::encode($user->id).'/edit" class="text-primary" data-toggle="tooltip" title="Edit Shopkeeper"><i class="fa fa-lg fa-edit"></i></a>';
                if(Auth::user()->can('delete shopkeepers'))
                    $action .= '<a href="customers/'.Hashids::encode($user->id).'" class="text-danger btn-delete" data-toggle="tooltip" title="Delete Shopkeeper"><i class="fa fa-lg fa-trash"></i></a>';

                   $action .= '<a href="javascript:void(0)" class="text-primary walletAdd"  data-id="'.$user->id.'" data-toggle="tooltip" title="Add Wallet/To Pay Amount"><i class="fa fa-google-wallet"></i></a>';
                   //$action .= '<a href="javascript:void(0)" class="text-success 2payAdd"  data-id="'.$user->id.'" data-toggle="tooltip" title="Add To Pay Quotation/Invoice Amount"><i class="fa fa-google-wallet"></i></a>';
                   $action .= '<a href="customers/'. Hashids::encode($user->id).'/wallet-statment" class="text-success" data-toggle="tooltip" title="Wallet Statement"><i class="fa fa-google-wallet"></i></a>';

                return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active','action'])
                ->make(true);

        }

        return view('admin.shopkeepers.index');
    }
    
    public function orders(Request $request)
    {
        if(\request()->ajax()) {
            $users = User::where('type', 'shopkeeper');
            
            if($request->filled('order')) {
                $orderBy = $request->order;
                if ($orderBy[0]['column'] == 1) {
                    $users->orderBy('name', $orderBy[0]['dir']);
                }
                if ($orderBy[0]['column'] == 2) {
                    $users->orderBy('email', $orderBy[0]['dir']);
                }
            } else {
                $users->orderBy('is_latest','desc');
            }

            return Datatables::of($users)
                ->addColumn('name', function ($customer) {
                    $name = $customer->name;
                    $color ='black';
                    if($customer->is_latest){
                        $color='red';
                    }
                    return "<a style='color:$color'>$name</a>";
                })
                ->addColumn('email', function ($customer) {
                    $name = $customer->email;
                    $color ='black';
                    if($customer->is_latest){
                        $color='red';
                    }
                    return "<a style='color:$color'>$name</a>";
                })
                ->addColumn('profile_image', function ($customer) {
                    return '<img width="30" src="' . checkImage('customers/thumbs/' . $customer->profile_image) . '" />';
                })
                ->addColumn('action', function ($order) {
                    $action = '';
                    if(Auth::user()->can('view orders'))
                        $action .= '<a href="orders?type=shopkeeper_order&user_id=' . Hashids::encode($order->id) . '" target="_blank" class="btn btn-xs btn-warning">Orders</a> | ';
                    
                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['profile_image', 'action','name','email'])
                ->make(true);
        }
        return view('admin.shopkeepers.orders');
    }
}
