<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\common\Resources;

Route::middleware(['auth:sanctum'])
        ->prefix('resources')
        ->group(function () {
            Route::get('program_categories', [Resources::class, 'program_categories']);
        });
