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

        Route::group(['prefix' => '/category'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category.index');
            Route::post('/', [CategoryController::class, 'store'])->name('category.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit']);
            Route::post('/update/{id}', [CategoryController::class, 'update']);
        });


    });

    // Admin panel
    Route::group(['middleware' => 'checkRole:Admin'], function () {

        Route::get('/admin', [AdminController::class, "dashboard"])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, "users"])->name('admin.users');
        Route::post('/admin/user/{id}/status', [AdminController::class, "userStatus"])->name('user.status');
    });

});

