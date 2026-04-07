<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\Resources;

Route::prefix('resources')
        ->group(function () {
            Route::get('program_categories', [Resources::class, 'program_categories']);
        });
