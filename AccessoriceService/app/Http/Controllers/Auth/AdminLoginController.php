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

class AdminLoginController extends Controller
{
    public function __construct() {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function getLogin() {
        return view('auth.admin_login');
    }


    public function login(Request $request) {
        $validation = Validator::make($request->post(), [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation);
        }

        $user = User::where('user_name', '=' ,$request->input('username'))
            ->where('del_flg', '=', User::DEL_FLG)
            ->where('status','=', '0')
            ->orWhere('status','=','1')
            ->first();
        if (isset($user)) {
            // Attempt to log the user in
            if (auth()->guard('admin')->attempt(['user_name' => $request->username, 'password' => $request->password])) {
                return redirect()->intended(url('admins/dashboard'));
            }
            return back()->withErrors([
                'username' => ' ',
                'password' => trans('messages.lbl_MEGS_login_error'),
            ]);
        }
        return back()->withErrors([
            'username' => ' ',
            'password' => trans('messages.lbl_MEGS_inactive'),
        ]);
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/admins/login');
    }
}