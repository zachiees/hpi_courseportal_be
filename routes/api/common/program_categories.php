<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\common\ProgramCategories;


Route::middleware('auth:sanctum')->prefix('program/categories')->group(function () {
    Route::get('',  [ProgramCategories::class,'index']);
    Route::post('', [ProgramCategories::class,'store']);
});
