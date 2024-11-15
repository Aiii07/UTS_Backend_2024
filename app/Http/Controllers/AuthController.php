<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'email|required|',
            'password' => 'required|min:6'
        ]);

        
        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        
        $password = Hash::make($request->password);

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password
        ]);

        $data = [
            "message" => "User is created successfully",
            "user" => $user
        ];

        return response()->json($data, 201);
    }

    public function login(Request $request){
        $input = $request->only('email', 'password');

        
        if(Auth::attempt($input)) {
            $token = Auth::user()->createToken('auth_token');

            $data = [
                'message' => 'Login successful',
                'token' => $token->plainTextToken
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Email or password is incorrect'
            ];

            return response()->json($data, 401);
        }
    }
}