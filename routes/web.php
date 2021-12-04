<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('backend.dashboard');
});
//
//Route::get('/loginTest', function () {
//    return view('backend.customAuth.login');
//});
//
//Route::get('/registerTest', function () {
//    return view('backend.customAuth.register');
//});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['customAuth'])->name('dashboard');

require __DIR__.'/auth.php';
