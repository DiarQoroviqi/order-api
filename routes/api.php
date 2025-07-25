<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerOrderController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderProductController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')
    ->name('api.customers.')
    ->group(function () {
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('{customer}/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
    });

Route::prefix('products')
    ->name('api.products.')
    ->group(function () {
        Route::post('/', [ProductController::class, 'store'])->name('store');
    });

Route::prefix('orders')
    ->name('api.orders.')
    ->group(function () {
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('{order}', [OrderController::class, 'show'])->name('show');
        Route::patch('{order}/status', OrderStatusController::class)->name('update-status');
    });

Route::prefix('orders/{order}/products')
    ->name('api.orders.products.')
    ->group(function () {
        Route::post('/', [OrderProductController::class, 'store'])->name('store');
    });
