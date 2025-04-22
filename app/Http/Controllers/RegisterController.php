<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function register(Request $request){

        $credentials = $request->validate([

            'email'=>'required|email',
            'password'=> 'required|string|min:8|confirmed',
            'name'=>'required|string|',
            'username'=>'required|string|unique:users'




        ]);

        $user = User::create($credentials);
        $user->role = 1;

       $user = $user->save();
       event(new Registered($user));

        if($user){

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
