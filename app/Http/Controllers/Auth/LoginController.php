<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(Request $request)
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
}
