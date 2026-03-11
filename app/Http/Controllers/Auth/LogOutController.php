<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogOutController extends Controller
{
    public function store(){

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
}
