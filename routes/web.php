<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

require __DIR__ . '/auth.php';

Route::group(['middleware' => 'auth'], function () {

    Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);

    // Users panel
    Route::group(['middleware' => 'checkRole:Basic User'], function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

        // Profile Controller
        Route::get('/settings/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/settings/profile/update', [ProfileController::class, 'updateInfo'])->name('profile.update');
        Route::post('/settings/profile/password/update', [ProfileController::class, 'updatePassword'])->name('profile.password');

        // Category
        Route::group(['prefix' => '/category'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category.index');
            Route::post('/', [CategoryController::class, 'store'])->name('category.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit']);
            Route::post('/update/{id}', [CategoryController::class, 'update']);
            Route::post('/delete/{id}', [CategoryController::class, 'destroy']);
        });

        // Expense
        Route::group(['prefix' => '/expense'], function () {
            Route::get('/', [ExpenseController::class, 'books'])->name('books.index');
            Route::get('/index/{category?}', [ExpenseController::class, 'index']);
            Route::post('/deposit-withdraw', [ExpenseController::class, 'deposit']);
            Route::get('/edit/{id?}/{category?}', [ExpenseController::class, 'edit']);
            Route::post('/deposit-withdraw/update/{id}', [ExpenseController::class, 'update']);
            Route::post('/delete/{id?}/{category?}', [ExpenseController::class, 'destroy']);
        });


        // Report Controller
        Route::get('/report/daily', [ReportController::class, 'reportDaily'])->name('report.daily');
        Route::get('/report/daily/print?date={date?}&category={category?}', [ReportController::class, 'printDailyReport']);
        Route::get('/report/weekly', [ReportController::class, 'reportWeekly'])->name('report.weekly');
        Route::get('/report/monthly', [ReportController::class, 'reportMonthly'])->name('report.monthly');

        // Daily Report By Category Wise
        Route::get('/report/daily-wise/{category?}', [ReportController::class, 'reportDailyCategoryWise']);

        // PDF Controller
        Route::get('/daily-report-download/{date}/{category}', [ReportController::class, 'dailyReportDownloadPdf'])->name('daily-report-download.pdf');

    });

    // Admin panel
    Route::group(['middleware' => 'checkRole:Admin'], function () {
        Route::get('/admin', [AdminController::class, "dashboard"])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, "users"])->name('admin.users');
        Route::post('/admin/user/{id}/status', [AdminController::class, "userStatus"])->name('user.status');
    });

});

