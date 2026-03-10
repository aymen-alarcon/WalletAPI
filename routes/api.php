<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogOutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::apiResource("Login", LoginController::class);
Route::apiResource("Logout", LogOutController::class);
Route::apiResource("Register", RegisterController::class);