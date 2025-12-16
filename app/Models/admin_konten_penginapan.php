<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admin_konten_penginapan extends Model
{
    protected $table = 'penginapan';
    protected $primaryKey = 'id_penginapan';
    protected $fillable = [
        'nama_penginapan',
        'deskripsi_penginapan',
        'harga_weekend',
        'harga_weekday',
        'fasilitas_tersedia',
        'status_tersedia',
        'url_gambar_penginapan',
    ];
    
    protected $casts = [
        'fasilitas_tersedia' => 'array',
    ];
}
