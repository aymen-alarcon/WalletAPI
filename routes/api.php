<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::post("/Login", [AuthController::class, "Login"]);
Route::post("/Register", [AuthController::class, "Register"]);
Route::middleware("auth:sanctum")->group(function(){
    Route::post("/Logout", [AuthController::class, "logout"]);
    Route::get("/User/{user}", [UserController::class, "index"]);
    Route::get("/wallets", [WalletController::class, "index"]);
    Route::get("/wallets/{wallet}", [WalletController::class, "show"]);
    Route::post("/wallets/create", [WalletController::class, "store"]);
    Route::patch("/wallets/{wallet}/deposit", [WalletController::class, "deposit"]);
    Route::patch("/wallets/{wallet}/withdraw", [WalletController::class, "withdraw"]);
    Route::post("/wallets/{wallet}/transfer", [TransactionController::class, "transfer"]);
    Route::post("/wallets/{wallet}/transactions", [WalletController::class, "store"]);
});