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

        return response()->json([
            "status" => "success",
            "data" => $user,
            "message" => "User Have Been created successfully",
        ], 201);
    }
}
