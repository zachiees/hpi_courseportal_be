<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\Programs;

Route::prefix('client/programs')
    ->middleware(['auth:sanctum'])
    ->group(function(){
    Route::get('',[Programs::class,'index']);
});
