<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') {
        return redirect('/admin/dashboard');
    } elseif ($role === 'owner') {
        return redirect('/owner/dashboard');
    } else {
        return redirect('/pengguna/dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== ADMIN =====
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'admin']);
    Route::get('/admin/pelanggan', [DashboardController::class, 'pelanggan'])->name('admin.pelanggan');

    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);

    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::post('/transaksi/proses/{id}', [TransaksiController::class, 'proses']);
});

// ===== PENGGUNA =====
Route::middleware(['auth', 'role:pengguna'])->group(function () {

    Route::get('/pengguna/dashboard', [DashboardController::class, 'pengguna']);

    Route::get('/produk-user', [PesananController::class, 'index']);
    Route::get('/pengguna/produk/{id}', [PesananController::class, 'show'])->name('produk.detail');
    Route::post('/pesan', [PesananController::class, 'store']);
    Route::get('/riwayat', [PesananController::class, 'riwayat']);
});

// ===== OWNER =====
Route::middleware(['auth', 'role:owner'])->group(function () {

    Route::get('/owner/dashboard', [DashboardController::class, 'owner']);

    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/stok', [LaporanController::class, 'stok'])->name('laporan.stok');
});

require __DIR__.'/auth.php';
