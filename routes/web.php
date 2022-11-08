<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\SpamController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->name('home')->middleware('auth');

Route::redirect('/', '/login');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::get('/flogout', [LoginController::class, 'logout']);
Route::get('/logout', function () {
    return redirect()->route('login');
});
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/password', [UpdatePasswordController::class, 'index']);
Route::post('/password', [UpdatePasswordController::class, 'update']);

Route::get('/spam', [SpamController::class, 'index']);

Route::middleware('admin')->group(function () {
    Route::get('/pengiriman/pickup', [PengirimanController::class, 'indexPickup']);
    Route::post('/pengiriman/pickup/{pengiriman}', [PengirimanController::class, 'pickup']);
    Route::post('/pengiriman/create/barang', [PengirimanController::class, 'pilihBarang'])->name('barang');
    Route::post('/pengiriman/create/proses', [PengirimanController::class, 'prosesPengiriman']);
    Route::get('/pengiriman/create/collect', function () {
        return redirect()->to('/pengiriman');
    });

    Route::resource('/pengiriman', PengirimanController::class);

    Route::get('/barang/riwayat', [BarangController::class, 'riwayat']);
    Route::post('/barang/{barang}', [BarangController::class, 'ubahStok']);
    Route::resource('/barang', BarangController::class);

    Route::resource('/toko', TokoController::class);

    Route::get('/driver/checkSlug', [DriverController::class, 'checkSlug']);
    Route::resource('/driver', DriverController::class);
});
Route::middleware('laporan')->group(function () {
    // Route::middleware(['admin', 'manajer'])->group(function () {
    Route::get('/laporan/pengiriman', [LaporanController::class, 'laporanPengiriman']);
    Route::get('/laporan/pengiriman/cetak', [LaporanController::class, 'laporanPengirimanCetak']);
    Route::get('/laporan/pengiriman/cari', function () {
        return redirect()->to('/laporan/pengiriman');
    });
    Route::get('/laporan/pengiriman/{pengiriman}', [LaporanController::class, 'detailPengiriman'])->name('laporan.pengiriman.detail');
    Route::post('/laporan/pengiriman/cari', [LaporanController::class, 'laporanPengirimanSearch']);
    Route::get('/laporan/pengiriman/cetak', [LaporanController::class, 'laporanPengirimanCetak']);
    Route::post('/laporan/pengiriman/cari/cetak', [LaporanController::class, 'laporanPengirimanSearchCetak']);

    Route::get('/laporan/driver', [LaporanController::class, 'laporanDriver']);
    Route::post('/laporan/driver', [LaporanController::class, 'laporanDriverSearch']);
    Route::post('/laporan/driver/cetak', [LaporanController::class, 'laporanDriverSearchCetak']);
});

Route::middleware('toko')->group(function () {
    Route::get('/store', [StoreController::class, 'index']);
    Route::get('/laporan/store', [StoreController::class, 'laporan']);
    Route::post('/laporan/store/cari', [StoreController::class, 'laporanSearch']);
    Route::get('/laporan/store/cari', function () {
        return redirect()->to('/laporan/store');
    });
    Route::get('/laporan/store/{pengiriman}', [LaporanController::class, 'detailPengiriman']);
    Route::post('/store/{pengiriman}', [StoreController::class, 'konfirmasi']);
});
