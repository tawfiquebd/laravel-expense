<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // Expense Controller
    Route::get('/expense', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expense', [ExpenseController::class, 'add'])->name('expense.add');
    Route::get('/expense/{id}', [ExpenseController::class, 'update'])->name('expense.update');
});

