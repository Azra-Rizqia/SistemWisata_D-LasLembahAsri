<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanTiketSatuan extends Model
{
    use HasFactory;

    protected $table = 'tiket_satuan';

    protected $fillable = [
        'nama_pemesan',
        'nama_tiket',
        'tanggal_pembelian',
        'jumlah_tiket',
        'harga_satuan',
        'total_pembayaran',
        'status_pembayaran',
    ];

    /**
     * Hitung total pembayaran otomatis
     */
    protected static function booted()
    {
        static::creating(function ($tiket) {
            $tiket->total_pembayaran = $tiket->jumlah_tiket * $tiket->harga_satuan;
        });

        static::updating(function ($tiket) {
            $tiket->total_pembayaran = $tiket->jumlah_tiket * $tiket->harga_satuan;
        });
    }
}
