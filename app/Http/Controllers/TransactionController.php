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
            $transactionValidate["receiver_wallet_id"] = NULL;
            $transactionValidate["type"] = "deposit";
            $transactionValidate["amount"] = $request->amount;
            $transactionValidate["description"] = $request->description;
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
            $transactionValidate["receiver_wallet_id"] = NULL;
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

    public function transfer(Request $request, Wallet $wallet, Transaction $transaction)
    {
        if ($request->amount >= 0) {
            $transactionValidate["wallet_id"] = $wallet->id;
            $transactionValidate["receiver_wallet_id"] = $request->receiver_wallet_id;
            $transactionValidate["type"] = "transfer";
            $transactionValidate["amount"] = $request->amount;
            $transactionValidate["description"] = $request->description;
            $transactionValidate["balance_after"] = $wallet->balance + $request->amount;
            $transactionItem = $transaction->create($transactionValidate);
            
            $walletValidate["balance"] = $wallet->balance - $request->amount;
            $wallet->update($walletValidate);
            $receiverWallet = $wallet->where("id", $request->receiver_wallet_id)->first();
            $receiverWalletValidation["balance"] = $receiverWallet->balance + $request->amount;
            $receiverWallet->update($receiverWalletValidation);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Transfert effectué avec succès.",
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