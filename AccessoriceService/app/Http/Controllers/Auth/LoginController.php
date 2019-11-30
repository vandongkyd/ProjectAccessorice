<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

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
    protected $redirectTo = 'admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        if (Auth::check())
            return Redirect::route('dashboard');

        return View::make('auth.login');
    }

    public function login(Request $request)
    {
//        $validation = Validator::make($request->post(), [
//            'username' => 'required',
//            'password' => 'required|min:6'
//        ]);
//        if ($validation->fails()) {
//            return redirect()->back()->withErrors($validation);
//        }
//
//        $user = User::where([
//            'user_name' => $request->input('username'),
//            'status' => 0,
//            'del_flg' => 0
//        ])->first();
//        if (isset($user)) {
//            // Attempt to log the user in
//            if (auth()->guard('web')->attempt(['user_name' => $request->username, 'password' => $request->password])) {
//                return redirect()->intended(url('admin/dashboard'));
//            }
//            return back()->withErrors([
//                'username' => ' ',
//                'password' => 'Your user name and password wrong!!',
//            ]);
//        }
//        return back()->withErrors([
//            'username' => ' ',
//            'password' => 'Account Inactive!!',
//        ]);
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/admin/login');
    }
}
