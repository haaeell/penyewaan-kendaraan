<?php

use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\WisatawanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[LandingPageController::class, 'index']);
Route::get('/daftarKendaraan',[LandingPageController::class, 'daftarKendaraan'])->name('daftarKendaraan');
Route::get('/detailKendaraan/{id}',[LandingPageController::class, 'detailKendaraan'])->name('detailKendaraan');
Route::get('/pesan/{kendaraan_id}', [SewaController::class, 'create'])->name('sewa.create');
Route::post('/pesan', [SewaController::class, 'store'])->name('sewa.store');
Route::get('/sewa/riwayat', [SewaController::class, 'riwayat'])->name('sewa.riwayat');
Route::get('/admin/pemesanan', [SewaController::class, 'index'])->name('sewa.index');
Route::post('/sewa/upload-bukti/{sewa}', [SewaController::class, 'uploadBuktiPembayaran'])->name('sewa.uploadBukti');
Route::patch('sewa/{id}/update-status', [SewaController::class, 'updateStatus'])->name('sewa.updateStatus');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPDF'])->name('laporan.cetakPDF');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::resource('wisatawan', WisatawanController::class);
    Route::resource('kendaraan', KendaraanController::class);
    Route::resource('jenis_pembayaran', JenisPembayaranController::class);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

