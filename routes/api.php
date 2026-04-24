<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TiketPaketControllerAPI;
use App\Http\Controllers\Api\PesanTiketPaketControllerAPI;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\PaymentController;

Route::apiResource('TiketPaket', TiketPaketControllerAPI::class);
Route::apiResource('pesan-tiket-paket', PesanTiketPaketControllerAPI::class);
Route::post('/midtrans-callback', [MidtransCallbackController::class, 'callback']);
Route::post('/payment-callback', [PaymentController::class, 'handleCallback']);