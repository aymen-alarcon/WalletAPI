<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function transfer(Request $request, Wallet $wallet)
    {
        
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function deposit(Request $request, Wallet $wallet, Transaction $transaction)
    {
        $balance = $wallet->balance;
        $walletValidate["balance"] = $balance + $request->balance;
        $wallet->update($walletValidate);

        $transactionValidate["wallet_id"] = $wallet->id;
        $transactionValidate["type"] = "deposit";
        $transactionValidate["amount"] = $request->balance;
        $transactionValidate["description"] = "Dépôt initial";
        $transactionValidate["balance_after"] = $wallet->balance;
        $transactionItem = $transaction->create($transactionValidate);

        return response()->json(
            [
                "success" => true,
                "message" => "Dépôt effectué avec succès.",
                "data" => [
                    "transaction" => $transactionItem,
                    "wallet" => $wallet,
                    ]
                ]
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
