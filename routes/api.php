<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')
    ->name('api.customers.')
    ->group(function () {
        Route::post('/', [CustomerController::class, 'store'])->name('store');
    });

Route::prefix('products')
    ->name('api.products.')
    ->group(function () {
        Route::post('/', [ProductController::class, 'store'])->name('store');
    });
