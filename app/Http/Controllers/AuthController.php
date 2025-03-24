<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function Register(Request $request){

       $validator =  Validator::make($request->all(),[
            "username" => 'unique:users|required|max:255|string|required',
            "name" => 'required|max:255|string|required',
            'identifier' => 'required|unique:users,email|unique:users,phone',
            "password" => 'required|confirmed',



        ]);
        // Determine if the identifier is an email or phone number
        $data = [
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ];

        if (filter_var($request->identifier, FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $request->identifier;
        } else {
            $data['phone'] = $request->identifier;
        }

        if ($validator->fails()) {

            return $validator->errors();
        } else {



            $user = new User($data);

            $user->save();


            $token = $user->createToken($request->name);



            return [
                'user' => $user->name,
                'token' => $token->plainTextToken


            ];
        }



    }
}
