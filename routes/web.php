<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\admin_pengunjung_controller;
use App\Http\Controllers\Admin\admin_pesan_tiket_paket_controller;
use App\Http\Controllers\Admin\admin_tiket_paket_controller;

Route::prefix('admin')->group(function () {

    Route::get('/pesan-tiket-paket', 
        [admin_pesan_tiket_paket_controller::class, 'index']
    );

    Route::get('/tiket-paket', 
        [admin_tiket_paket_controller::class, 'index']
    );

    Route::get('/pengunjung', 
        [admin_pengunjung_controller::class, 'index']
    );

});

Route::get('/', function () {
    return view('welcome');
});
