<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\TransaksiController;
use App\Models\Gudang;

// 1. Halaman Depan: Promosi & Katalog Laptop (Publik)
Route::get('/', function () {
    // Mengambil semua data laptop dari tabel gudang yang stoknya lebih dari 0
    $laptops = Gudang::where('stok', '>', 0)->latest()->get();
    return view('katalog.index', compact('laptops'));
})->name('katalog.index');

// 2. Route Autentikasi Staff
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. Route Khusus Staff (Auth & Role) - Tetap sama seperti sebelumnya
Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin_gudang,bos'])->group(function () {
        Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');
        Route::post('/gudang', [GudangController::class, 'store'])->name('gudang.store');
        Route::put('/gudang/{id}', [GudangController::class, 'update'])->name('gudang.update');
        Route::delete('/gudang/{id}', [GudangController::class, 'destroy'])->name('gudang.destroy');
    });

    Route::middleware(['role:kasir,bos'])->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    });
});