<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\Courses;


Route::prefix('courses')
    ->middleware('auth:sanctum')
    ->group(function(){
        Route::post("", [Courses::class, 'store']);


    });
