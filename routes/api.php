<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TiketPaketControllerAPI; // Import yang baru

Route::get('/TiketPaket', [TiketPaketControllerAPI::class, 'index']);
Route::post('/TiketPaket', [TiketPaketControllerAPI::class, 'store']);
Route::put('/TiketPaket/{id}', [TiketPaketControllerAPI::class, 'update']);
Route::delete('/TiketPaket/{id}', [TiketPaketControllerAPI::class, 'destroy']);