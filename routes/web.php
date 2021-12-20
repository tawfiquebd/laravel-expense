<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function() {

    Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);

    // Users panel
    Route::group(['middleware' => 'checkRole:Basic User'], function() {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

        // Expense Controller
        Route::get('/expense', [ExpenseController::class, 'index'])->name('expense.index');
        Route::post('/expense', [ExpenseController::class, 'add'])->name('expense.add');
        Route::get('/expense/{id}', [ExpenseController::class, 'update'])->name('expense.update');
        Route::post('/expense/{id}/delete', [ExpenseController::class, 'delete'])->name('expense.delete');

        // Report Controller
        Route::get('/report/daily', [ReportController::class, 'reportDaily'])->name('report.daily');
        Route::get('/report/daily/{date}', [ReportController::class, 'printDailyReport'])->name('report.print');
        Route::get('/report/weekly', [ReportController::class, 'reportWeekly'])->name('report.weekly');
        Route::get('/report/monthly', [ReportController::class, 'reportMonthly'])->name('report.monthly');

        // Profile Controller
        Route::get('/settings/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/settings/profile/update', [ProfileController::class, 'updateInfo'])->name('profile.update');
        Route::post('/settings/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password');
    });

    // Admin panel
    Route::group(['middleware' => 'checkRole:Admin'], function() {

        Route::get('/admin', [AdminController::class, "dashboard"])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, "users"])->name('admin.users');
        Route::post('/admin/user/{id}/status', [AdminController::class, "userStatus"])->name('user.status');
    });

});

