<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\PaymentRequests;

Route::prefix('payment_requests')
    ->name('payment_requests.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('', [PaymentRequests::class, 'store']);
    });
