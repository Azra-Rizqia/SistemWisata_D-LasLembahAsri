<?php

use App\Http\Controllers\WahanaAPI; 

Route::get('/wahana', [WahanaAPI::class, 'index']); 
Route::post('/wahana', [WahanaAPI::class, 'store']); 
Route::get('/wahana/{id}', [WahanaAPI::class, 'show']); 
Route::put('/wahana/{id}', [WahanaAPI::class, 'update']); 
Route::delete('/wahana/{id}', [WahanaAPI::class, 'destroy']);