<?php

use App\Http\Controllers\Admin\CafeInfoController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\AutentikasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// ===== Halaman pertama: ke halaman masuk, atau ke dashboard jika sudah login =====
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('masuk');
})->name('awal');

// ===== Hanya untuk yang belum login =====
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AutentikasiController::class, 'formMasuk'])->name('masuk');
    Route::post('/masuk', [AutentikasiController::class, 'prosesMasuk'])->name('masuk.proses');
    Route::get('/daftar', [AutentikasiController::class, 'formDaftar'])->name('daftar');
    Route::post('/daftar', [AutentikasiController::class, 'prosesDaftar'])->name('daftar.proses');
});

// ===== Untuk admin dan pelanggan yang sudah login =====
Route::middleware('auth')->group(function () {
    Route::post('/keluar', [AutentikasiController::class, 'keluar'])->name('keluar');
    Route::get('/dashboard', [DashboardController::class, 'tampilkan'])->name('dashboard');
});

// ===== Khusus pelanggan: cari menu, lihat detail, beri review =====
Route::middleware(['auth', 'hanya_pelanggan'])->group(function () {
    Route::get('/menu', [MenuController::class, 'beranda'])->name('beranda');
    Route::get('/menu/{menu}', [MenuController::class, 'detail'])->name('menu.detail');

    Route::post('/menu/{menu}/review', [ReviewController::class, 'simpan'])->name('review.simpan');
    Route::delete('/review/{review}', [ReviewController::class, 'hapus'])->name('review.hapus');
});

// ===== Khusus admin: kelola menu, informasi cafe, moderasi review =====
Route::middleware(['auth', 'hanya_admin'])->prefix('admin')->name('admin.')->group(function () {
    // Kelola menu
    Route::get('/menu', [AdminMenuController::class, 'daftar'])->name('menu.daftar');
    Route::get('/menu/tambah', [AdminMenuController::class, 'tambah'])->name('menu.tambah');
    Route::post('/menu', [AdminMenuController::class, 'simpan'])->name('menu.simpan');
    Route::get('/menu/{menu}/ubah', [AdminMenuController::class, 'ubah'])->name('menu.ubah');
    Route::put('/menu/{menu}', [AdminMenuController::class, 'perbarui'])->name('menu.perbarui');
    Route::delete('/menu/{menu}', [AdminMenuController::class, 'hapus'])->name('menu.hapus');

    // Kelola informasi cafe
    Route::get('/cafe/ubah', [CafeInfoController::class, 'ubah'])->name('cafe.ubah');
    Route::put('/cafe', [CafeInfoController::class, 'perbarui'])->name('cafe.perbarui');

    // Moderasi review: admin hanya melihat dan menyaring, tidak bisa menghapus
    Route::get('/review', [AdminReviewController::class, 'daftar'])->name('review.daftar');
});