<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\Courses;


Route::prefix('courses')
    ->middleware('auth:sanctum')
    ->group(function(){
        Route::post("", [Courses::class, 'store']);
        Route::get("", [Courses::class, 'index']);
        Route::get("list", [Courses::class, 'list']);
        Route::get("{uuid}", [Courses::class, 'find']);
        Route::patch("{uuid}", [Courses::class, 'update']);
        Route::delete("{uuid}", [Courses::class, 'destroy']);
        Route::post("{uuid}/upload_cover", [Courses::class, 'upload_cover']);
        Route::post("{uuid}/upload_thumbnail", [Courses::class, 'upload_thumbnail']);
    });
