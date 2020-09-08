<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends HomeController
{
    use ThrottlesLogins;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        parent::__construct();
    }

    // login
    public function show_login() {
        return view('admin.auth.login', parent::$data);
    }
    public function login(LoginRequest $request) {

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return responseJson(false ,trans('admin.too_many_login_attempts' , ['minute' => $this->decayMinutes()]) , [] , 422);
        }

        if(Auth::guard('admin')->attempt($request->validated())) {
            // clear login attempt
            $this->clearLoginAttempts($request);
            $redirect_url = !is_null($request->url_previous) && !empty($request->url_previous) && Str::contains($request->url_previous ,'admin') ? $request->url_previous : route('admin.index');
            return responseJson(true ,trans('admin.login_success'),['redirect_url' => $redirect_url],200);
        }else {
            // increment login attempts
            $this->incrementLoginAttempts($request);
            return responseJson(false ,trans('admin.login_failed') , [] , 422);
        }
    }

    // logout
    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->back();
    }


    // help
    public function username()
    {
        return 'email';
    }

}
