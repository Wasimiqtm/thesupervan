<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\ShoppingCart;
use App\User;
use Illuminate\Support\Facades\Auth;

use App\Admin;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Session,Hashids,DataTables,DB;

class SaleRepController extends Controller
{

   public function __construct()
   {
        $this->middleware('permission:view sale reps', ['only' => ['index']]);
        $this->middleware('permission:add sale reps', ['only' => ['create','store']]);
        $this->middleware('permission:edit sale reps', ['only' => ['edit','update']]);
        $this->middleware('permission:delete sale reps', ['only' => ['destroy']]);
    }

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        if($request->ajax()){

            $admins = Admin::role(2)->get();

            return DataTables::of($admins) 
                ->addColumn('action', function ($admin) {
                    $action = '';
                    if(Auth::user()->can('edit sale reps'))
                        $action .= '<a href="sale-reps/'. Hashids::encode($admin->id).'/edit" class="text-primary" data-toggle="tooltip" title="Edit Sale Rep"><i class="fa fa-lg fa-edit"></i></a>';
                    if(Auth::user()->can('delete sale reps'))
                        $action .= '<a href="sale-reps/'.Hashids::encode($admin->id).'" class="text-danger btn-delete" data-toggle="tooltip" title="Delete Sale Rep" ><i class="fa fa-lg fa-trash"></i></a>';
                    if(Auth::user()->can('login sale reps'))
                        $action .= '<a href="login-sale-reps/'.Hashids::encode($admin->id).'" class="text-primary" data-toggle="tooltip" title="Login as Sale Rep" ><i class="fa fa-sign-in fa-lg"></i></a>';
                    
                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.sale-reps.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.sale-reps.create');
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
            'name' => 'required|max:255|unique:admins',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6|confirmed'
        ]);

       $requestData = $request->all();
       $requestData['password'] = bcrypt($requestData['password']);

       $admin = Admin::create($requestData);
       $admin->assignRole(2);


        Session::flash('success', 'Sale reps added!');

        return redirect('admin/sale-reps');
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
        $admin = Admin::findOrFail($id);

        return view('admin.sale-reps.edit', compact('admin'));
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
            'name' => 'required|max:255|unique:admins,name,'.$id,
            'email' => 'required|email|max:255|unique:admins,email,'.$id,
        ]);

        $requestData = $request->all();

        $admin = Admin::findOrFail($id);
        $admin->update($requestData);

        Session::flash('success', 'Sale reps updated!');

        return redirect('admin/sale-reps');
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

        $admin = Admin::find($id);

        if($admin){
            $admin->delete();
            $response['message'] = 'Sale reps deleted!';
            $status = $this->successStatus;
        }else{
            $response['message'] = 'Sale reps not exist against this id!';
            $status = $this->errorStatus;
        }

        return response()->json(['result'=>$response], $status);

    }
    
    /**
     * User login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login($id)
    {
        session(['back_to_admin' => Auth::guard('admin')->id()]);
        
        $id = decodeId($id);
        Auth::guard('admin')->loginUsingId($id);
        
        Session::flash('success', 'Successfully login as sale reps!');
        return redirect()->route('admin.home');
    }
}
