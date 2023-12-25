<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Email;
use App\Models\OrderUser;
use Log;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
//        $users = OrderUser::get();
//        //dd($users->toArray());
//        foreach($users as $oUser) {
//            $email = $oUser->email = str_replace(' ', '.', strtolower($oUser->owner_name)).'@thesupervan.co.uk';
//            $contactNo = str_replace('+', '', $oUser->contact_no);
//            $contactNo = str_replace(' ', '', $contactNo);
//            $oUser->phone = $contactNo;
//            $oUser->password = Hash::make($email);
//            $oUser->type = 'wholesaler';
//                    
//            $userData = $oUser->toArray();        
//            
//            User::updateOrCreate(
//                ['email' => $email],
//                $userData
//            );
//        }
        
        return view('admin.dashboard');
    }
    
    public function sendEmailView()
    {
        $users = User::orderBy('first_name', 'asc')->get()->pluck('full_name_with_email', 'id');
        return view('admin.send-email', compact('users'));
    }
    public function sendEmail(Request $request)
    {
        if($request->filled('user_ids')) {
            foreach($request->user_ids as $userId) {
                
                $user = User::find($userId);
                if ($user) {
                    
                    $data = [
                        'email_from'    => 'aqsintetrnationalstore@gmail.com',
                        'email_to'      => $user->email,
                        'email_subject' => @$request->subject,
                        'user_name'     => $user->full_name,
                        'final_content' => @$request->body,
                    ];
                    try{
                        Email::sendEmail($data);
                    }
                    catch(Exception $e)
                    {
                        Log::error('Admin Email error: ' . $e->getMessage());
                    }
                }
                
            }
        }
        
        Session::flash('success', 'Email successfully sent!');
        return redirect('admin/send-email');
    }
    
    public function profitCalculator(Request $request)
    {
        return view('admin.profit-calculator');
    }
}
