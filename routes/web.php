<?php

use App\Http\Controllers\ReservasiFasilitasAPI;
use App\Http\Controllers\FasilitasAPI;
use App\Models\ReservasiFasilitas;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservasiFasilitasController;
use App\Http\Controllers\SewaTenantController;
use App\Http\Controllers\WahanaController;
use App\Http\Controllers\PesanTiketSatuanController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KontenPenginapanController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/kelola_konten/penginapan', [KontenPenginapanController::class, 'index'])->name('konten.penginapan.index');
Route::get('/kelola_konten/penginapan/tambah', [KontenPenginapanController::class, 'create'])->name('konten.penginapan.create');
Route::post('/kelola_konten/penginapan/tambah', [KontenPenginapanController::class, 'store'])->name('konten.penginapan.store');

Route::resource('reservasi_fasilitas', ReservasiFasilitasController::class);
Route::get('/reservasi_fasilitas', [ReservasiFasilitasController::class, 'index'])->name('reservasi_fasilitas.index');
Route::put('/reservasi_fasilitas/{reservasi_fasilita}/edit', [ReservasiFasilitasController::class, 'edit'])->name('reservasi_fasilitas.edit');

Route::resource('sewa_kios', SewaTenantController::class);
Route::get('/sewa_kios', [SewaTenantController::class, 'index'])->name('sewa_kios.index');

Route::resource('wahana', WahanaController::class);
Route::get('/wahana', [WahanaController::class, 'index'])->name('wahana.index');

Route::resource('pesan-tiket', PesanTiketSatuanController::class);
Route::get('/pesan-tiket', [PesanTiketSatuanController::class, 'index'])->name('pesan-tiket.index');

Route::prefix('api')->group(function () {
    Route::get('/reservasi_fasilitas', [ReservasiFasilitasAPI::class, 'index']);
    Route::post('/reservasi_fasilitas', [ReservasiFasilitasAPI::class, 'store']);
    Route::get('/reservasi_fasilitas/{id}', [ReservasiFasilitasAPI::class, 'show']);
    Route::put('/reservasi_fasilitas/{id}', [ReservasiFasilitasAPI::class, 'update']);
    Route::delete('/reservasi_fasilitas/{id}', [ReservasiFasilitasAPI::class, 'destroy']);
});

