<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShipmentController;
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

    Route::middleware('auth:api')->group(function () {
        Route::get('/locations', [LocationController::class, 'index']);
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::get('/brands', [BrandController::class, 'index']);

        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{id}', [ProductController::class, 'show']);
        Route::get('/products/search', [ProductController::class, 'search']);
        Route::get('/products/filter', [ProductController::class, 'filter']);

        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart/add', [CartController::class, 'addToCart']);
        Route::put('/cart/item/{itemId}', [CartController::class, 'updateCartItem']);
        Route::delete('/cart/item/{itemId}', [CartController::class, 'removeItem']);
        Route::delete('/cart/clear', [CartController::class, 'clearCart']);

        Route::get('/favorites', [FavoriteController::class, 'index']);
        Route::post('/favorites', [FavoriteController::class, 'store']);
        Route::delete('/favorites/{productId}', [FavoriteController::class, 'destroy']);

        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{id}', [OrderController::class, 'show']);

        Route::get('/products/{productId}/reviews', [ReviewController::class, 'index']);
        Route::post('/reviews', [ReviewController::class, 'store']);
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

        Route::get('/shipments/{orderId}', [ShipmentController::class, 'show']);

        Route::put('/shipments/{shipmentId}', [ShipmentController::class, 'update']); // (nên giới hạn role)
    });

});




