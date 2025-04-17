<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request){

        $credentials = $request->validate([

            'email'=>'required|email',
            'password'=> 'required|string|min:8|confirmed',
            'name'=>'required|string|',
            'username'=>'required|string|unique:users'



        ]);

        if(User::create($credentials)){

            return redirect('create');

        }

        else{

            return back()->withErrors(
                [
                    'not correct information'
                ]

                );
        
        }

    }
}
