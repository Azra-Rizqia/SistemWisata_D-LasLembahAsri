<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservasiFasilitasController;
use App\Http\Controllers\SewaTenantController;
use App\Http\Controllers\WahanaController;
use App\Http\Controllers\PesanTiketSatuanController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('reservasi_fasilitas', ReservasiFasilitasController::class);
Route::get('/reservasi_fasilitas', [ReservasiFasilitasController::class, 'index'])->name('reservasi_fasilitas.index');

Route::resource('sewa_kios', SewaTenantController::class);
Route::get('/sewa_kios', [SewaTenantController::class, 'index'])->name('sewa_kios.index');

Route::resource('wahana', WahanaController::class);
Route::get('/wahana', [WahanaController::class, 'index'])->name('wahana.index');

Route::resource('pesan-tiket', PesanTiketSatuanController::class);
Route::get('/pesan-tiket', [PesanTiketSatuanController::class, 'index'])->name('pesan-tiket.index');
