<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_fasilitas',
        'deskripsi_singkat',
        'tentang_fasilitas',
        'harga_fasilitas',
        'status_fasilitas',
        'fasilitas_tersedia',
        'fasilitas_tambahan',
        'url_gambar_fasilitas',
    ];

    protected $casts = [
        'fasilitas_tersedia' => 'array',
        'fasilitas_tambahan' => 'array',
    ];
}
