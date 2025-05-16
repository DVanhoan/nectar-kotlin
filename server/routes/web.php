<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\ShipmentEventController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\FavoriteController;



Route::get('/login', [AuthController::class, 'loginView'])->name('login.view');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'registerView'])->name('register.view');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Users
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


        // Categories
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Brands
        Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

        // Products
        Route::middleware('role:seller')->group(function () {
            Route::prefix('products')->group(function () {
                Route::get('/', [ProductController::class, 'index'])->name('products.index');
                Route::get('create', [ProductController::class, 'create'])->name('products.create');
                Route::post('/', [ProductController::class, 'store'])->name('products.store');
                Route::get('{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
                Route::put('{product}', [ProductController::class, 'update'])->name('products.update');
                Route::delete('{product}', [ProductController::class, 'destroy'])->name('products.destroy');
            });
        });


        // Orders admin
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

        // Order seller



        // Payment Methods
        Route::get('payment-methods', [PaymentMethodController::class, 'index'])->name('payment-methods.index');
        Route::get('payment-methods/create', [PaymentMethodController::class, 'create'])->name('payment-methods.create');
        Route::post('payment-methods', [PaymentMethodController::class, 'store'])->name('payment-methods.store');
        Route::get('payment-methods/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('payment-methods.edit');
        Route::put('payment-methods/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('payment-methods.update');
        Route::delete('payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('payment-methods.destroy');

        // Payments
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');


        Route::get('carts', [CartController::class, 'index'])->name('carts.index');
        Route::delete('cart/{cart}', [CartController::class, 'destroy'])->name('carts.delete');


        // Shipments
        Route::get('shipments', [ShipmentController::class, 'index'])->name('shipments.index');
        Route::get('shipments/{shipment}', [ShipmentController::class, 'show'])->name('shipments.show');
        Route::put('shipments/{shipment}', [ShipmentController::class, 'update'])->name('shipments.update');

        // Shipment Events
        Route::post('shipments/{shipment}/events', [ShipmentEventController::class, 'store'])->name('shipments.events.store');
        Route::put('shipments/events/{event}', [ShipmentEventController::class, 'update'])->name('shipments.events.update');
        Route::delete('shipments/events/{event}', [ShipmentEventController::class, 'destroy'])->name('shipments.events.destroy');

        // Reviews
        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        // Favorites
        Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    });
