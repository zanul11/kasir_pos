<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KartuStokController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenjualanController;
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

    Route::prefix('barang_keluar')->group(function () {
        Route::get('/tambahbarang/{id}', [BarangKeluarController::class, 'tambah_barang']);
    });
    Route::resource('barang_keluar', BarangKeluarController::class);

    Route::get('data_penjualan/export', [PenjualanController::class, 'export'])
        ->name('data_penjualan.export');
    Route::get('data_penjualan/data', [PenjualanController::class, 'data'])
        ->name('data_penjualan.data');
    Route::resource('data_penjualan', PenjualanController::class);

    //LAPORAN KARTU STOK
    Route::get('kartu_stok/export', [KartuStokController::class, 'export'])
        ->name('kartu_stok.export');
    Route::resource('kartu_stok', KartuStokController::class);

    //LAPORAN KEUANGAN
    Route::get('keuangan/export', [KeuanganController::class, 'export'])
        ->name('keuangan.export');
    Route::resource('keuangan', KeuanganController::class);

    Route::resource('informasi', HomeController::class);
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
