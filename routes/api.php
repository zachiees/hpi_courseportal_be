<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//COMMON
require_once "api/common/auth.php";
require_once "api/common/users.php";
require_once "api/common/programs.php";
require_once "api/common/resources.php";
require_once "api/common/courses.php";
require_once "api/common/lms.php";
require_once "api/common/principals.php";
//PUBLIC
require_once "api/public/programs.php";
require_once "api/public/registration.php";
