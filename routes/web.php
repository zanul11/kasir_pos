<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'showLoginForm']);
Auth::routes([
    "register" => false,
    "confirm" => false,
    "reset" => false
]);

Route::middleware('auth:web')->group(function () {
    Route::get('pengguna/data', [PenggunaController::class, 'data'])
        ->name('pengguna.data');
    Route::resource('pengguna', PenggunaController::class);

    Route::get('barang/data', [BarangController::class, 'data'])
        ->name('barang.data');
    Route::resource('barang', BarangController::class);


    Route::get('pelanggan/data', [PelangganController::class, 'data'])
        ->name('pelanggan.data');
    Route::resource('pelanggan', PelangganController::class);

    Route::get('satuan/data', [SatuanController::class, 'data'])
        ->name('satuan.data');
    Route::resource('satuan', SatuanController::class);

    Route::get('supplier/data', [SupplierController::class, 'data'])
        ->name('supplier.data');
    Route::resource('supplier', SupplierController::class);

    //BARANG MASUK
    Route::get('barang_masuk/data', [BarangMasukController::class, 'data'])
        ->name('barang_masuk.data');
    Route::prefix('barang_masuk')->group(function () {
        Route::get('/tambahbarang/{id}', [BarangmasukController::class, 'tambah_barang']);
    });

    Route::get('barang_masuk/export', [BarangMasukController::class, 'export'])
        ->name('barang_masuk.export');
    Route::resource('barang_masuk', BarangMasukController::class);


    Route::resource('data_penjualan', SatuanController::class);
    Route::resource('kasir', SatuanController::class);


    Route::resource('informasi', HomeController::class);
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
