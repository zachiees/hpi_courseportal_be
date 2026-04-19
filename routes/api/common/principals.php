<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\Principals;

Route::prefix('principals')
        ->middleware('auth:sanctum')
        ->group(function () {
            Route::get('',[Principals::class,'index']);
            Route::post('',[Principals::class,'store']);
        });
