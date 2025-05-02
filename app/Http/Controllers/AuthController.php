<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Rules\EmailOrPhone;


class AuthController extends Controller 
{


    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "username" => 'required|max:255|unique:users,username|string',
                "name"     => 'required|max:255|string',
                'identifier' => [
                    'required',
                    new EmailOrPhone
                ],
                "password" => 'required|confirmed|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $data = $validator->validated();
            $isEmail = filter_var($data['identifier'], FILTER_VALIDATE_EMAIL);

            $exists = DB::table('users')
              
                ->where($isEmail ? 'email' : 'phone', $data['identifier'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'errors' => [
                        'identifier' => ['The ' . ($isEmail ? 'email' : 'phone') . ' has already been taken.']
                    ]
                ], 422);
            }

            $user = User::create([
                'username' => $data['username'],
                'name'     => $data['name'],
                'email'    => $isEmail ? $data['identifier'] : null,
                'phone'    => !$isEmail ? $data['identifier'] : null,
                'password' => Hash::make($data['password']),
            ]);

            return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage(),
            ], 500);
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
