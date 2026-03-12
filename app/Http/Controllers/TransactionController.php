<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function withdraw(Request $request, Wallet $wallet, Transaction $transaction)
    {
        if ($request->amount < $wallet->balance) {
            $transactionValidate["wallet_id"] = $wallet->id;
            $transactionValidate["type"] = "deposit";
            $transactionValidate["amount"] = $request->amount;
            $transactionValidate["description"] = "Dépôt initial";
            $transactionValidate["balance_after"] = $wallet->balance - $request->amount;
            $transactionItem = $transaction->create($transactionValidate);
            
            $walletValidate["balance"] = $wallet->balance - $request->amount;
            $wallet->update($walletValidate);

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
        }else{
            return response()->json([
                "success"=> false,
                "message"=> "Solde insuffisant. Solde actuel : 100.00 MAD."
                ]);
        }
    }

    public function deposit(Request $request, Wallet $wallet, Transaction $transaction)
    {
        if ($request->amount >= 0) {
            $transactionValidate["wallet_id"] = $wallet->id;
            $transactionValidate["type"] = "deposit";
            $transactionValidate["amount"] = $request->amount;
            $transactionValidate["description"] = "Dépôt initial";
            $transactionValidate["balance_after"] = $wallet->balance + $request->amount;
            $transactionItem = $transaction->create($transactionValidate);
            
            $walletValidate["balance"] = $wallet->balance + $request->amount;
            $wallet->update($walletValidate);

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
        }else{
            return response()->json([
                "success"=> false,
                "message"=> "Erreur de validation.",
                "errors"=> "Le montant doit être supérieur à 0."
                ]);
        }
    }
}