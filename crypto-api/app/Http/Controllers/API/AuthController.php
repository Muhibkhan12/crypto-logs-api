<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=> 'string|max:50|required',
            'email' => 'email|unique|required',
            'password' => 'required|min:6',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Validation Error ',
                'error' => $validator->errors(),
            ],400);
        };
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status' => true,
            'message' => 'validation Successfull',
            'user' => $user,
            'token' => $token,
            'type' => 'bearer',
        ]);

    }
    public function login(Request $request){
        $credentials = $request->only('email','password');
        if(!$token = Auth::attempt($credentials)){
            return response()->json([
                'status' => false,
                'message'=> 'Invalid email or password',
            ],401);
        }
        return response()->json([
            'status' => true,
            'message' => 'Authentication Successfull',
            'token' => $token,
            'type' => 'bearer',
            'user' => auth()->User,
        ]);
    }

    public function logout(){
        Auth::logout();

        return response()->json([
            'status'=> true,
            'message'=> 'Logout Successfully',
        ]);
    }
    
    public function refresh(){
        return response()->json([
            'status'=> true,
            'token' => Auth::refresh(),
            'type'=> 'bearer',
        ]);
    }
}
