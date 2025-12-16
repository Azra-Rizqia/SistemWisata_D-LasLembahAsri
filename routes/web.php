<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\ReservasiFasilitasController;
use App\Http\Controllers\SewaTenantController;
use App\Http\Controllers\KontenPenginapanController;
use App\Http\Controllers\ReservasiPenginapanController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/kelola_konten/penginapan', [KontenPenginapanController::class, 'index'])->name('konten.penginapan.index');
Route::get('/kelola_konten/penginapan/tambah', [KontenPenginapanController::class, 'create'])->name('konten.penginapan.create');
Route::post('/kelola_konten/penginapan/tambah', [KontenPenginapanController::class, 'store'])->name('konten.penginapan.store');
Route::get('/kelola_konten/penginapan/{id}/edit', [KontenPenginapanController::class, 'edit'])->name('konten.penginapan.edit');
Route::put('/kelola_konten/penginapan/edit/{id}', [KontenPenginapanController::class, 'update'])->name('konten.penginapan.update');
Route::get('/kelola_konten/penginapan/{id}', [KontenPenginapanController::class, 'show'])->name('konten.penginapan.show');
Route::delete('/kelola_konten/penginapan/hapus/{id}', [KontenPenginapanController::class, 'destroy'])->name('konten.penginapan.destroy');

// Route::resource('fasilitas', FasilitasController::class);
// Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');

// Route::resource('sewa_kios', SewaTenantController::class);
// Route::get('/sewa_kios', [SewaTenantController::class, 'index'])->name('sewa_kios.index');

Route::get('/kelola_konten/penginapan', [KontenPenginapanController::class, 'index'])->name('konten.penginapan.index');
Route::get('/kelola_konten/penginapan/tambah', [KontenPenginapanController::class, 'create'])->name('konten.penginapan.create');
Route::post('/kelola_konten/penginapan/tambah', [KontenPenginapanController::class, 'store'])->name('konten.penginapan.store');

// Route::resource('reservasi_fasilitas', ReservasiFasilitasController::class);
// Route::get('/reservasi_fasilitas', [ReservasiFasilitasController::class, 'index'])->name('reservasi_fasilitas.index');
// Route::put('/reservasi_fasilitas/{reservasi_fasilita}/edit', [ReservasiFasilitasController::class, 'edit'])->name('reservasi_fasilitas.edit');

// Route::resource('sewa_kios', SewaTenantController::class);
// Route::get('/sewa_kios', [SewaTenantController::class, 'index'])->name('sewa_kios.index');

Route::resource('reservasi_penginapan', ReservasiPenginapanController::class);
Route::get('/reservasi_penginapan/create', [ReservasiPenginapanController::class, 'create'])->name('reservasi_penginapan.create');
Route::post('/reservasi_penginapan/tambah', [ReservasiPenginapanController::class, 'store'])->name('reservasi_penginapan.store');
Route::put('/reservasi_penginapan/{reservasi_penginapan}/edit', [ReservasiPenginapanController::class, 'edit'])->name('reservasi_penginapan.edit');
