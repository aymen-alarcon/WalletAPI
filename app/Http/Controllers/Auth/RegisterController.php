<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
        ]);

        $validate["password"] = hash::make($validate["password"]);

        $user = User::create($validate);
        $token = $user->createToken("UserToken")->plainTextToken;

        return response()->json([
            "success" => false,
            "data" => $user,
            "message" => "User Have Been created successfully",
            "token" => $token,
        ], 201);
    }

    // public function login(Request $request){
    //      $validate = $request->validate([
    //         "email"=> "required|string",
    //         "password"=> "required|min:6|string",
    //     ]);


    //     if(!Auth::attempt(["email"=> $validate['email'], 'password'=> $validate['password']])){
    //         return response()->json([
    //             'sucess'=>false,
    //             'message'=> "Identifiants incorrects"
    //         ]);
    //     }
    //     $user = Auth::user();
    //     $token = $user->createToken('auth_Token')->plainTextToken;

    //     return response()->json([
    //         'success'=> true,
    //         'message'=> "Connexion réussie",
    //         'data'=> $user,
    //         'token'=> $token
    //     ]);
    // }

}