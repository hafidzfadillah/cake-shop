<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopCartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

// Test route to verify API is working
Route::get('/test', function() {
    return response()->json(['message' => 'API is working']);
});

// Product Category Routes
Route::prefix('categories')->group(function () {
    Route::get('/', [ProductCategoryController::class, 'index']);
    Route::post('/', [ProductCategoryController::class, 'store']);
    Route::get('/{id}', [ProductCategoryController::class, 'show']);
    Route::put('/{id}', [ProductCategoryController::class, 'update']);
    Route::delete('/{id}', [ProductCategoryController::class, 'destroy']);
});

// Product Routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

// Shopping Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [ShopCartController::class, 'index']);
    Route::post('/', [ShopCartController::class, 'store']);
    Route::get('/{id}', [ShopCartController::class, 'show']);
    Route::put('/{id}', [ShopCartController::class, 'update']);
    Route::delete('/{id}', [ShopCartController::class, 'destroy']);
    Route::get('/customer/{custId}', [ShopCartController::class, 'getCustomerCart']);
});

// Transaction Routes
Route::prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/', [TransactionController::class, 'store']);
    Route::get('/{id}', [TransactionController::class, 'show']);
    Route::patch('/{id}/status', [TransactionController::class, 'updateStatus']);
});
