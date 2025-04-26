<?php

use App\Http\Controllers\DonasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformasiMasjidController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanKeuanganController;
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
    Route::controller(LaporanKeuanganController::class)->group(function () {
        Route::get('laporan_keuangan', 'index');
        Route::post('laporan_keuangan', 'store');
        Route::get('laporan_keuangan/{id}', 'cetak')->name('LaporanKeuangan.cetak');
        Route::get('laporan_keuangan/delete/{id}',  'destroy');
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
    Route::controller(KegiatanController::class)->group(function () {
        Route::get('kegiatan_masjid', 'index');
        Route::post('kegiatan_masjid', 'store');
        Route::put('kegiatan_masjid/update/{id}', 'update');
        Route::get('kegiatan_masjid/delete/{id}',  'destroy');
    });
    Route::controller(InformasiMasjidController::class)->group(function () {
        Route::get('informasi_masjid', 'index');
        Route::post('informasi_masjid', 'store');
        Route::put('informasi_masjid/update/{id}', 'update');
        Route::get('informasi_masjid/delete/{id}',  'destroy');
    });
});
