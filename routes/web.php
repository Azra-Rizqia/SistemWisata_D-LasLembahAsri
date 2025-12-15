<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservasiFasilitasController;
use App\Http\Controllers\SewaTenantController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('reservasi_fasilitas', ReservasiFasilitasController::class);
Route::get('/reservasi_fasilitas', [ReservasiFasilitasController::class, 'index'])->name('reservasi_fasilitas.index');

Route::resource('sewa_kios', SewaTenantController::class);
Route::get('/sewa_kios', [SewaTenantController::class, 'index'])->name('sewa_kios.index');
