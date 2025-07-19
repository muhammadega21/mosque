<?php

use App\Http\Controllers\BuktiDonasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformasiMasjidController;
use App\Http\Controllers\KasMasjidController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', [HomeController::class, 'landingPage'])->name('landingPage');
Route::post('/donasi', [HomeController::class, 'donasi'])->name('donasi');

// Auth
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name("login")->middleware('guest');
    Route::post('/login', 'login');
    Route::get('/signup', 'register')->middleware('guest');
    Route::post('/register', 'registerStore')->name('registerStore');
    Route::get('/logout', 'logout')->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::controller(UserController::class)->group(function () {
        Route::get('pengurus', 'index');
        Route::post('pengurus', 'store');
        Route::put('pengurus/update/{id}', 'update');
        Route::get('pengurus/delete/{id}',  'destroy');
    });
    Route::controller(KategoriController::class)->group(function () {
        Route::get('kategori', 'index');
        Route::post('kategori', 'store');
        Route::put('kategori/update/{id}', 'update');
        Route::get('kategori/delete/{id}',  'destroy');
    });

    Route::controller(LaporanKeuanganController::class)->group(function () {
        Route::get('laporan_keuangan', 'index');
        Route::post('laporan_keuangan', 'store');
        Route::get('laporan_keuangan/{id}', 'cetak')->name('LaporanKeuangan.cetak');
        Route::get('laporan_keuangan/delete/{id}',  'destroy');
    });
    Route::controller(KasMasjidController::class)->group(function () {
        Route::get('kas_masjid', 'index');
        Route::post('kas_masjid', 'store');
        Route::put('kas_masjid/update/{id}', 'update');
        Route::get('kas_masjid/delete/{id}', 'destroy');
        Route::put('kas_masjid/validasi_donasi/{id}', 'validasiDonasi');
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
