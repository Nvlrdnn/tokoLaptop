<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\TransaksiController;

// 1. Route Autentikasi (Bisa diakses Publik)
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Route yang Membutuhkan Login (Auth Group)
Route::middleware(['auth'])->group(function () {

    // Hak Akses Inventaris Gudang: Hanya 'admin_gudang' dan 'bos'
    Route::middleware(['role:admin_gudang,bos'])->group(function () {
        Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');
        Route::post('/gudang', [GudangController::class, 'store'])->name('gudang.store');
        Route::delete('/gudang/{id}', [GudangController::class, 'destroy'])->name('gudang.destroy');
    });

    // Hak Akses POS Kasir: Hanya 'kasir' dan 'bos'
    Route::middleware(['role:kasir,bos'])->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    });

});