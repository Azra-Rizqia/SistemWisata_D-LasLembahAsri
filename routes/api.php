<?php

use App\Http\Controllers\FasilitasAPI;
use App\Http\Controllers\TenantAPI;

Route::get('/fasilitas', [FasilitasAPI::class, 'index']);
Route::post('/fasilitas', [FasilitasAPI::class, 'store']);
Route::get('/fasilitas/{id}', [FasilitasAPI::class, 'show']);
Route::put('/fasilitas/{id}', [FasilitasAPI::class, 'update']);
Route::delete('/fasilitas/{id}', [FasilitasAPI::class, 'destroy']);

// Vincent
Route::get('/tenant', [TenantAPI::class, 'index']);
Route::post('/tenant', [TenantAPI::class, 'store']);
Route::get('/tenant/{id}', [TenantAPI::class, 'show']);
Route::put('/tenant/{id}', [TenantAPI::class, 'update']);
Route::delete('/tenant/{id}', [FasilitasAPI::class, 'destroy']);