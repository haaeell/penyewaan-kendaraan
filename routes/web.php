<?php

use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\SettingInformasiController;
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

Route::get('/', [LandingPageController::class, 'index']);
Route::get('/daftarKendaraan', [LandingPageController::class, 'daftarKendaraan'])->name('daftarKendaraan');
Route::get('/detailKendaraan/{id}', [LandingPageController::class, 'detailKendaraan'])->name('detailKendaraan');
Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('wisatawan.profile.index');
    Route::post('/sewa/{id}/perpanjang', [SewaController::class, 'perpanjang'])->name('sewa.perpanjang');

    Route::get('/editPassword', [ProfileController::class, 'editPassword'])->name('editPassword');
    Route::post('/password/wisatawan/update', [ProfileController::class, 'updatePassword'])->name('wisatawan.password.update');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/pesan/{kendaraan_id}', [SewaController::class, 'create'])->name('sewa.create');
    Route::post('/pesan', [SewaController::class, 'store'])->name('sewa.store');
    Route::get('/sewa/riwayat', [SewaController::class, 'riwayat'])->name('sewa.riwayat');
    Route::get('/admin/pemesanan', [SewaController::class, 'index'])->name('sewa.index');
    Route::post('/sewa/upload-bukti/{sewa}', [SewaController::class, 'uploadBuktiPembayaran'])->name('sewa.uploadBukti');
    Route::get('/check-promo/{kode}', [PromoController::class, 'checkPromo']);
    Route::patch('sewa/{id}/update-status', [SewaController::class, 'updateStatus'])->name('sewa.updateStatus');

});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('wisatawan', WisatawanController::class);
    Route::resource('kendaraan', KendaraanController::class);
    Route::resource('jenis_pembayaran', JenisPembayaranController::class);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPDF'])->name('laporan.cetakPDF');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('informasi', [SettingInformasiController::class, 'index'])->name('index');
        Route::get('informasi/edit', [SettingInformasiController::class, 'edit'])->name('edit');
        Route::put('informasi/update', [SettingInformasiController::class, 'update'])->name('update');
    });
    Route::prefix('admin')->middleware('auth')->group(function () {
        Route::resource('promos', PromoController::class);
    });
    Route::resource('karyawan', KaryawanController::class);
    Route::post('sewa/assign-karyawan/{id}', [SewaController::class, 'assignKaryawan'])->name('sewa.assignKaryawan');
});
