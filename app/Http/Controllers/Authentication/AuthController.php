<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class AuthController extends Controller
{

    public function loginPage(){
        if(auth('web')->check()){
            return redirect()->route('user.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request){
        $credentials = $this->credentials($request);

        if (auth('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/user/dashboard');
        }

        // Authentication failed
        return back()->withInput($request->only('username'))->with('error', 'The provided credentials do not match our records.');

        Session::flash('error', 'The provided credentials do not match our records.');
    }

    protected function credentials(Request $request){
        {
            if(filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('username'), 'password'=> $request->get('password')];
            }
            return ['username' => $request->get('username'), 'password'=>$request->get('password')];
        }
    }

    public function logout(){
        auth('web')->logout();
        return redirect()->route('user.login');
    }

}
