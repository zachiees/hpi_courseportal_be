<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webhooks\Payments;

Route::post('webhooks/payments', [Payments::class,'handle']);
