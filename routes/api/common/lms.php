<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\Lms;


Route::prefix('lms')->group(function () {
    Route::get('courses', [Lms::class, 'courses']);
});
