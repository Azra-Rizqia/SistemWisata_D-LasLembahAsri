<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FasilitasController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('fasilitas', FasilitasController::class);
Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
