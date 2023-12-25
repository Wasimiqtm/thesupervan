<?php

namespace App\Http\Controllers\Auth;

use App\Models\Email;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Newsletter_subscriber;
use Hashids, Session;
use Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

//    usertype registeration
    public function userTypeRegister() {

        $userType = request()->segment(1);
        if($userType == 'wholesaler' || $userType == 'dropshipper') {
            return view('auth.user_type_register', compact('userType'));
        }
        abort(404);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if(isset($data['type'])) {
            return Validator::make($data, [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users','unique:newsletter_subscribers'],
                'password' => ['required', 'string', 'min:8'],
                'address' => ['required', 'string'],
                'CaptchaCode'=> 'valid_captcha'

            ]);
        } else {
            return Validator::make($data, [

                'email' => ['required', 'string', 'email', 'max:255', 'unique:users','unique:newsletter_subscribers'],
                'password' => ['required', 'string', 'min:8'],
                  'address' => ['required', 'string'],
                'CaptchaCode'=> 'valid_captcha'

            ]);
        }
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if($request->filled('type')){
            Session::flash('success', 'Your account created successfully');
            $email = settingValue('email');

            $data = [
                'email_from'    => 'info@aqsinternational.com',
                'email_to'      => $email,
                'email_subject' => $request->type.' Register Info',
                'user_name'     => 'User',
                'final_content' => '<p>Dear Admin</p>
                                    <p>A new '.$request->type.' has been registered</p>',
            ];
//            Email::sendEmail($data);
            return redirect('/');
        }

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // newsletter subscription
        $input['email'] = $data['email'];
        $newsletter = Newsletter_subscriber::create($input);
        //$this->sendSubscriptionEmail($data['email']);

        $userData = [
            // 'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address']
        ];

        if(isset($data['type'])) {
            $userData = array_merge($userData, ['type' => $data['type'],   'is_active' => 'yes','address' => $data['address']]);
        }

        // create user
        return User::create($userData);

    }

    public function sendSubscriptionEmail($email){

        $user = Newsletter_subscriber::whereEmail($email)->first();
        $data = [
            'email_from' => 'info@aqsinternational.com',
            'email_to' => $user->email,
            'email_subject' => 'Newsletter Subscription',
            'user_name' => 'User',
            'url' => url('unsubscribe-newsletter?id='.Hashids::encode($user->id)),
            'final_content' => '<p>Dear {name}</p>
                                <p>Here is your unsubscription Link {url}</p>',
        ];
        
        try{
            Email::sendEmail($data);
        }
        catch(Exception $e)
        {
            Log::error('Order Email error: ' . $e->getMessage());
        }
    }
}
