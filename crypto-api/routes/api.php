<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TradeExecutionController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',[AuthController::class, 'login']);
    Route::post('logout',[AuthController::class,'logout']);
    Route::post('addtrade',[TradeExecutionController::class,'addTrade']);
});