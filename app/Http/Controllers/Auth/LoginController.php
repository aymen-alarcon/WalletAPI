<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
            $request->session()
                    ->regenerate();
                    
            return response()->json([
                "status" => "success",
                "data" => $validate,
                "message" => "You have logged in successfully",
            ]);
        }

    }
}
