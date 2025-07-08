<?php

use App\Http\Controllers\Api\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')
    ->name('api.customers.')
    ->group(function () {
        Route::post('/', [CustomerController::class, 'store'])->name('store');
    });
