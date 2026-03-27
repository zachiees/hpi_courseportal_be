<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\Programs;

Route::prefix('programs')
        ->middleware('auth:sanctum')
        ->group(function () {
            Route::get('', [Programs::class, 'index']);
            Route::post('', [Programs::class, 'store']);
        });
