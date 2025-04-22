<?php

use App\Http\Controllers\DonasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransaksiController;
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
        Route::get('jamaah', 'index');
        Route::post('jamaah', 'store');
        Route::put('jamaah/update/{id}', 'update');
        Route::get('jamaah/delete/{id}',  'destroy');
    });
    Route::controller(KategoriController::class)->group(function () {
        Route::get('kategori', 'index');
        Route::post('kategori', 'store');
        Route::put('kategori/update/{id}', 'update');
        Route::get('kategori/delete/{id}',  'destroy');
    });
    Route::controller(TransaksiController::class)->group(function () {
        Route::get('keuangan', 'index');
        Route::post('keuangan', 'store');
        Route::put('keuangan/update/{id}', 'update');
        Route::get('keuangan/delete/{id}',  'destroy');
    });
    Route::controller(DonasiController::class)->group(function () {
        Route::get('donasi', 'index');
        Route::post('donasi', 'store');
        Route::put('donasi/update/{id}', 'update');
        Route::get('donasi/delete/{id}',  'destroy');
        Route::get('donasi/cetak/{id}', 'cetak');
        Route::get('donasi/export', 'cetak');
        Route::post('donasi/saldo', 'addSaldo');
    });
});
