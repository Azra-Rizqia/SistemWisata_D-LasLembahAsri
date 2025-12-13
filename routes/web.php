<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\SewaTenantController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('fasilitas', FasilitasController::class);
Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');

Route::resource('sewa_kios', SewaTenantController::class);
// Route::get('/sewa_kios', [SewaTenantController::class, 'index'])->name('sewa_kios.index');
