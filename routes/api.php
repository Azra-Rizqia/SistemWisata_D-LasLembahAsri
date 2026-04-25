<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TiketPaketControllerAPI;
use App\Http\Controllers\Api\PesanTiketPaketControllerAPI;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MidtransCallbackController;

Route::apiResource('TiketPaket', TiketPaketControllerAPI::class);
Route::apiResource('pesan-tiket-paket', PesanTiketPaketControllerAPI::class);
Route::post('/create-payment', [PaymentController::class, 'create']);
Route::post('/midtrans-callback', [MidtransCallbackController::class, 'callback'])
    ->withoutMiddleware(['auth:sanctum']);
Route::get('/test', function () {
    return response()->json(['message' => 'API OK']);
});