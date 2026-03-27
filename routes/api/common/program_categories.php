<?php

use Illuminate\Support\Facades\Route;
use App\Models\ProgramCategory;


Route::middleware('auth:sanctum')->prefix('program/categories')->group(function () {
    Route::get('',[ProgramCategory::class,'index']);
    Route::post('',[ProgramCategory::class,'index']);
});
