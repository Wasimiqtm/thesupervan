<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\ShoppingCart;
use Cart;
use Auth;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        $data = ShoppingCart::where(['user_id' => Auth::id(), 'payment_status' => 'pending'])->first();
        $cart = Cart::getContent()->values()->toArray();

        if($data){
            $cartData = unserialize($data->cart_details);
            $cart = array_merge($cartData, $cart);
            $this->updateCartInDB($cart);
        }

        if($cart){
            Cart::session(Auth::id())->add($cart);
            $this->updateCartInDB($cart);
        }
        Session::flash('success', 'You are logged in successfully');
    }

    public function updateCartInDB($cart){
        $input['user_id']       = Auth::id();
        $input['cart_details']  = serialize(Cart::getContent()->values()->toArray());
        $result                 = ShoppingCart::updateOrCreate(['user_id' => Auth::id(), 'payment_status' => 'pending'],
            ['user_id' => Auth::id(), 'cart_details' => serialize($cart)]);
    }

    public function login(\Illuminate\Http\Request $request) {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active
            if ($user->is_active == 'yes' && $this->attemptLogin($request)) {
                // Send the normal successful login response
                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                $this->incrementLoginAttempts($request);

                Session::flash('error', 'Please contact your administrator to activate your account.');
                return redirect()->back();
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
