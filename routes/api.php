<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;

Route::apiResource('users', UserController::class);
Route::apiResource('wallets', WalletController::class);
Route::put('wallets/transfer', [WalletController::class, 'update']);