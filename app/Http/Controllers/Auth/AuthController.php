<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        if (Auth::attempt($validate)) {
            $user = User::where("email", $request->email)->firstOrFail();
            $token = $user->createToken("UserToken")->plainTextToken;
                    
            return response()->json([
                "success" => true,
                "data" => $validate,
                "message" => "You have logged in successfully",
                "token" => $token
            ]);
        }
    }

    public function logout(){

        $user= Auth::user();

        if(!$user){
            return response()->json([
                'success'=> false,
                'message'=> 'Utilisateur non connecte',
            ], 401);
        }

        $user->currentAccessToken()->delete();

        return response()->json([
            'success'=>true,
            'message'=> 'Logged Out Successfully' 
        ]);
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
        ]);

        $validate["password"] = Hash::make($validate["password"]);

        $user = User::create($validate);
        $token = $user->createToken("UserToken")->plainTextToken;

        return response()->json([
            "success" => false,
            "data" => $user,
            "message" => "User Have Been created successfully",
            "token" => $token,
        ], 201);
    }
}
