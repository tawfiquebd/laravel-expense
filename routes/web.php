<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

require __DIR__.'/auth.php';


Route::get('/', [DashboardController::class, 'index']);
