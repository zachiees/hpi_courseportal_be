<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\Programs;

Route::prefix('public/programs')
        ->group(function(){
            Route::post("",[Programs::class,"index"]);
            Route::get("{uuid}",[Programs::class,"find"]);
        });
