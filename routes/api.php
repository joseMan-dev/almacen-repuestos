<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RepuestoController;

Route::apiResource('repuestos', RepuestoController::class);
Route::post('/repuestos/retirar', [RepuestoController::class, 'retirar']);