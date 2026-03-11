<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $wallets = Wallet::where("user_id", Auth::user()->id)->get();

        return response()->json([
            "wallets" => $wallets,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Wallet $wallet)
    {
        $validate = $request->validate([
            "name" => "required|string",
            "balance" => "required|numeric|min:0",
            "currency" => "required|string|max:3",
        ]);

        $validate["user_id"] = Auth::user()->id;
        $wallet->create($validate);

        return response()->json([
            "success" => true,
            "data" => $wallet,
            "message" => "Created a wallet successfully",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        return response()->json([
            "wallet" => $wallet,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function deposit(Request $request, Wallet $wallet)
    {
        $balance = $wallet->balance;
        $validate["balance"] = $balance + $request->balance;

        $wallet->update($validate);

        return response()->json(["balance" => $wallet->balance]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function withdraw(Request $request, Wallet $wallet)
    {
        $balance = $wallet->balance;
        $validate["balance"] = $balance - $request->balance;

        $wallet->update($validate);

        return response()->json(["balance" => $wallet->balance]);
    }
}