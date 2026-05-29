<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarroController;

Route::apiResource('carros', CarroController::class);