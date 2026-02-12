<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RepuestoController;

Route::view('/{any?}', 'app')->where('any', '.*');
