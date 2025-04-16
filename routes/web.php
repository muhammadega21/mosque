<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('login')->middleware('guest');
    Route::get('/login', 'index')->middleware('guest');
    Route::post('/login', 'login');
    Route::get('/signup', 'register')->middleware('guest');
    Route::post('/register', 'registerStore')->name('registerStore');
    Route::get('/logout', 'logout')->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::controller(UserController::class)->group(function () {
        Route::get('jamaah', 'index')->name('jamaah');
        Route::post('jamaah', 'store');
        Route::put('jamaah/update/{id}', 'update');
        Route::get('jamaah/delete/{id}',  'destroy');
    });
});
