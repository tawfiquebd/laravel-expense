<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/expense', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expense', [ExpenseController::class, 'add'])->name('expense.add');
});

