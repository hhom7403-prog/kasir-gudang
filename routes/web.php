<?php

use App\Http\Controllers\GudangController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware('role:admin,kasir')->group(function () {
        Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
        Route::post('/kasir/simpan', [KasirController::class, 'simpan'])->name('kasir.simpan');
        Route::get('/kasir/struk/{id}', [KasirController::class, 'struk'])->name('kasir.struk');
    });

    Route::middleware('role:admin,gudang')->group(function () {
        Route::get('/gudang/stok', [StokController::class, 'index'])->name('stok.index');
        Route::post('/gudang/stok/restock', [StokController::class, 'restock'])->name('stok.restock');
        Route::get('/gudang/stok/menipis', [StokController::class, 'stokMenipis'])->name('stok.menipis');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('gudang', GudangController::class)->except('show');
        Route::resource('produk', ProdukController::class)->except('show');
        Route::resource('kategori', KategoriController::class)->except('show');
        Route::get('/pengguna', [UserController::class, 'index'])->name('users.index');
        Route::patch('/pengguna/{user}', [UserController::class, 'update'])->name('users.update');
    });
});

require __DIR__.'/auth.php';
