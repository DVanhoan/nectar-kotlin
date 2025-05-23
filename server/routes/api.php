<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;


Route::prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('/otp/send', [OtpController::class, 'sendOtp']);
        Route::post('/otp/verify', [OtpController::class, 'verifyOtp']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('refresh', [AuthController::class, 'refresh']);

        Route::middleware('auth:api')->group(function () {
            Route::get('user/me', [AuthController::class, 'me']);
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('user', [AuthController::class, 'editUser']);
        });
    });
});




