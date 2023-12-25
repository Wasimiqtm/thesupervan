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

class WholesalerController extends Controller
{

   public function __construct()
   {
        $this->middleware('permission:view wholesaler', ['only' => ['index']]);
        $this->middleware('permission:add wholesaler', ['only' => ['create','store']]);
        $this->middleware('permission:edit wholesaler', ['only' => ['edit','update']]);
        $this->middleware('permission:delete wholesaler', ['only' => ['destroy']]);
    }

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        if($request->ajax()){

            $users = User::where('type','wholesaler')->orWhere('type','shopkeeper');

            if($request->filled('order')) {
                $orderBy = $request->order;
                if ($orderBy[0]['column'] == 1) {
                    $users->orderBy('first_name', $orderBy[0]['dir']);
                }
            } else {
                $users->orderBy('updated_at','desc');
            }

            return DataTables::of($users)
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
                if(Auth::user()->can('edit wholesaler'))
                    $action .= '<a href="customers/'. Hashids::encode($user->id).'/edit" class="text-primary" data-toggle="tooltip" title="Edit Wholesaler"><i class="fa fa-lg fa-edit"></i></a>';
                if(Auth::user()->can('delete wholesaler'))
                    $action .= '<a href="customers/'.Hashids::encode($user->id).'" class="text-danger btn-delete" data-toggle="tooltip" title="Delete Wholesaler"><i class="fa fa-lg fa-trash"></i></a>';

                   $action .= '<a href="javascript:void(0)" class="text-primary walletAdd"  data-id="'.$user->id.'" data-toggle="tooltip" title="Add Wallet/To Pay Amount"><i class="fa fa-google-wallet"></i></a>';
                   //$action .= '<a href="javascript:void(0)" class="text-success 2payAdd"  data-id="'.$user->id.'" data-toggle="tooltip" title="Add To Pay Amount"><i class="fa fa-google-wallet"></i></a>';
                   $action .= '<a href="customers/'. Hashids::encode($user->id).'/wallet-statment" class="text-success" data-toggle="tooltip" title="Wallet Statement"><i class="fa fa-google-wallet"></i></a>';

                return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['is_active','action'])
                ->make(true);

        }

        return view('admin.wholesaler.index');
    }

    public function wholeSalerOrders(Request $request)
    {
        if(\request()->ajax()) {
            $users = User::where('type', 'wholesaler');
            
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
                        $action .= '<a href="orders?type=wholesaler_order&user_id=' . Hashids::encode($order->id) . '" target="_blank" class="btn btn-xs btn-warning">Orders</a> | ';
                    
                    $action .= '<a href="' . url('admin/update-status/wholesaler/'.Hashids::encode($order->id)). '"  class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>';
                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['profile_image', 'action','name','email'])
                ->make(true);
        }
        return view('admin.wholesaler.whole_saler_orders');
    }
}
