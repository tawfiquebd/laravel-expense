<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // Expense Controller
    Route::get('/expense', [ExpenseController::class, 'index'])->name('expense.index');
    Route::post('/expense', [ExpenseController::class, 'add'])->name('expense.add');
    Route::get('/expense/{id}', [ExpenseController::class, 'update'])->name('expense.update');
    Route::post('/expense/{id}/delete', [ExpenseController::class, 'delete'])->name('expense.delete');

    // Report Controller
    Route::get('/report/daily', [ReportController::class, 'reportDaily'])->name('report.daily');
    Route::get('/report/{date}', [ReportController::class, 'printDailyReport'])->name('report.print');
});

