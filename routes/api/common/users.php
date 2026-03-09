<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\common\User;

Route::prefix('users')->middleware(['auth:sanctum'])->group(function () {
    Route::get('',      [User::class,'index']);
    Route::post('',     [User::class,'store']);
    Route::get('{uuid}',[User::class,'find']);
    Route::patch('{uuid}',[User::class,'update']);
    Route::delete('{uuid}',[User::class,'destroy']);
});
