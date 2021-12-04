<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('backend.dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';