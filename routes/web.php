<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\PdfController;
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

Route::any('/', [LoginController::class, 'login'])->name('login');
Route::any('/proses_login', [LoginController::class, 'prosesLogin'])->name('prosesLogin');
Route::any('/logout', [LoginController::class, 'logout'])->name('logout');
Route::any('/print_aset', [PdfController::class, 'pdfAset'])->name('pdfAset');
Route::any('/print_kondisi_aset', [PdfController::class, 'pdfKondisi'])->name('pdfKondisi');
Route::any('/print_penyusutan', [PdfController::class, 'pdfPenyusutan'])->name('pdfPenyusutan');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::any('/home', [AdminController::class, 'index'])->name('admin.index');
        Route::any('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::any('/update_profile', [AdminController::class, 'updateProfile'])->name('admin.updateProfile');
        Route::any('/aset', [AdminController::class, 'aset'])->name('admin.aset');
        Route::any('/add_aset', [AdminController::class, 'addAset'])->name('admin.addAset');
        Route::any('/update_aset', [AdminController::class, 'updateAset'])->name('admin.updateAset');
        Route::any('/update_status', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');
        Route::any('/delete_aset/{id}', [AdminController::class, 'deleteAset'])->name('admin.deleteAset');
        Route::any('/penyusutan', [AdminController::class, 'penyusutan'])->name('admin.penyusutan');
        Route::any('/data_penyusutan', [AdminController::class, 'searchPenyusutan'])->name('admin.searchPenyusutan');
        Route::any('/pemeliharaan', [AdminController::class, 'pemeliharaan'])->name('admin.pemeliharaan');
        Route::any('/add_pemeliharaan', [AdminController::class, 'addPemeliharaan'])->name('admin.addPemeliharaan');
        Route::any('/delete_pemeliharaan/{id}', [AdminController::class, 'deletePemeliharaan'])->name('admin.deletePemeliharaan');
        Route::any('/update_pemeliharaan', [AdminController::class, 'updatePemeliharaan'])->name('admin.updatePemeliharaan');
        Route::any('/selesai_pemeliharaan/{id}', [AdminController::class, 'selesaiPemeliharaan'])->name('admin.selesaiPemeliharaan');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('pimpinan')->middleware(['pimpinan'])->group(function () {
        Route::any('/home', [PimpinanController::class, 'index'])->name('pimpinan.index');
        Route::any('/profile', [PimpinanController::class, 'profile'])->name('pimpinan.profile');
        Route::any('/update_profile', [PimpinanController::class, 'updateProfile'])->name('pimpinan.updateProfile');
        Route::any('/aset', [PimpinanController::class, 'aset'])->name('pimpinan.aset');
        Route::any('/penyusutan', [PimpinanController::class, 'penyusutan'])->name('pimpinan.penyusutan');
        Route::any('/pemeliharaan', [PimpinanController::class, 'pemeliharaan'])->name('pimpinan.pemeliharaan');
        Route::any('/data_penyusutan', [PimpinanController::class, 'searchPenyusutan'])->name('pimpinan.searchPenyusutan');
    });
});
