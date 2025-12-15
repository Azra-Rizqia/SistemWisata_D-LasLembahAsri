<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\SewaTenantController;
use App\Http\Controllers\KontenPenginapanController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/kelola_konten/penginapan', [KontenPenginapanController::class, 'index'])->name('konten.penginapan.index');
Route::get('/kelola_konten/penginapan/tambah', [KontenPenginapanController::class, 'create'])->name('konten.penginapan.create');
Route::post('/kelola_konten/penginapan/tambah', [KontenPenginapanController::class, 'store'])->name('konten.penginapan.store');

Route::resource('fasilitas', FasilitasController::class);
Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');

Route::resource('sewa_kios', SewaTenantController::class);
// Route::get('/sewa_kios', [SewaTenantController::class, 'index'])->name('sewa_kios.index');
