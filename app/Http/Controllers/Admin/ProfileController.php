<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Models\Transaction;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session, Alert, DB, Image, File;
use App\User;
use App\Admin;
use  Hashids, DataTables;


class ProfileController extends Controller

{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()

    {
        $profile = Auth::user();
        return view('admin.profile.index', compact('profile'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {

        $id = Auth::id();
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $requestData = $request->all();

        $user = Admin::findOrFail($id);
        $user->update($requestData);

        Session::flash('success', 'Profile updated!');
        return redirect('admin/profile');
    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function changePasswordView()
    {

        $data = Admin::find(Auth::id());
        return view('admin.profile.change-password', compact('data'));
    }


    /**
     * Change password.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function changePassword(Request $request)

    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        $requestData = $request->all();
        $validator->after(function($validator) use ($request) {
            $user = Auth::user();

            //checking the old password first
            $check  = Auth::attempt([
                'email' => $user->email,
                'password' => $request->current_password
            ]);

            if(!$check) {
                $validator->errors()->add('current_password','Your current password is incorrect, please try again.');
            }
        });


        if ($validator->fails())
            return redirect('admin/change-password')->withErrors($validator);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        Session::flash('success', 'Password updated!');
        return redirect('admin/change-password');

    }
    public function getInvoiceList(Request $request)
    {
        $users = User::whereIn('type',['dropshipper','wholesaler']);
        if ($request->ajax()) {

            if(!empty($request->user_id)){
                $users->where('id',$request->user_id);
            }




            return Datatables::of($users->get())
                ->addColumn('orders_details', function ($order) {
                    return '<span class="details-control"></span>';
                })
                ->addColumn('sum_amount', function ($order) use($request) {
                    $transactions=  Transaction::where('user_id',$order->id);
                    if(!empty($request->start_date) and !empty($request->end_date)){

                        $startDate = $request->start_date;
                        $endDate = $request->end_date;

                        return '£'. round($transactions->whereDate('created_at','>=',$startDate)->whereDate('created_at','<=',$endDate)->sum('amount'),2);

                    }

                    return '£'. round($transactions->sum('amount'),2);
                })
                ->addColumn('wallet_amount',function($order){
                    $data = UserWallet::whereUserId($order->id)->get();

                    return  '£'. round(($data->sum('credit') - $data->sum('debit')),2);

                })
                ->make(true);
        }
        $data = $users->get();

        return view('admin.profile.user_invoice',compact('data'));


    }

}

