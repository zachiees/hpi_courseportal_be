<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\Programs;

Route::prefix('programs')
        ->middleware('auth:sanctum')
        ->group(function () {
            Route::get('',        [Programs::class, 'index']);
            Route::post('',       [Programs::class, 'store']);
            Route::get('categories',          [Programs::class, 'index_categories']);
            Route::post('categories',         [Programs::class, 'store_categories']);
            Route::patch('categories/{uuid}', [Programs::class, 'update_categories']);
            Route::delete('categories/{uuid}', [Programs::class, 'destroy_categories']);
            Route::get('{uuid}',         [Programs::class, 'find']);
            Route::patch('{uuid}',       [Programs::class, 'update']);
            Route::post('{uuid}/courses',[Programs::class, 'add_course']);
        });
