<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\Registration;

Route::prefix('public/registration')
        ->group(function (){
            Route::post('',[Registration::class,'register']);
        });
