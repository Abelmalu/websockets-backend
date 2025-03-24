<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function Register(Request $request)
    {

        $validator =  Validator::make($request->all(), [
            "username" => 'required|max:255|unique:users,username|string',
            "name" => 'required|max:255|string|required',
            'identifier' => 'required|unique:users,email|unique:users,phone',
            "password" => 'required|confirmed',



        ]);
        // Determine if the identifier is an email or phone number


        $data = [
            'name' => $request->name,
            'username' => $request->username,
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


    public function login(Request $request)
    {

        Validator::make($request->all(), [

            'identifier' => 'required',
            'password' => 'required'

        ]);



        $identifier = $request->identifier;
        $password = $request->password;

        // Find user by email, phone, or username
        $user = User::where('email', $identifier)
            ->orWhere('phone', $identifier)
            ->orWhere('username', $identifier)
            ->first();



        if (!$user || !Hash::check($request->password, $user->password)) {

            return ['message' => 'The provided credentials are incorrect'];
        }

        $token = $user->createToken($user->name);



        return [
            'user' => $user,
            'token' => $token->plainTextToken


        ];
    }


    public function logout(Request $request)
    {




        $request->user()->tokens()->delete();

        return ['message' => 'You are logged Out'];
    }
}
