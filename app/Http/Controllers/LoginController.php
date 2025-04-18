<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){

        $credentials = $request->validate([

            'email'=>'required|email',
            'password' =>'required|min:8|string'

        ]);

        if(Auth::attempt($credentials)){

            if(Auth::user()->role == 0){

                $request->session()->regenerate();

                return redirect()->intended('user_home');



            }

            else{
                $request->session()->regenerate();

                return redirect()->intended('admin_home');



            }

           



        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
        





    }
}
