<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\ProgramCategories;


Route::middleware('auth:sanctum')->prefix('programs/categories')->group(function () {
    Route::get('',  [ProgramCategories::class,'index']);
    Route::post('', [ProgramCategories::class,'store']);
});
