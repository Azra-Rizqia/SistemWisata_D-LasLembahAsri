<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservasi_penginapan extends Model
{
    use HasFactory;

    protected $table = 'reservasi_penginapan';

    protected $fillable = [
        'nomor_reservasi',
        'user_id',
        'id_penginapan',
        'tanggal_masuk',           
        'tanggal_keluar',          
        'catatan_user_reservasi',
        'tanggal_pemesanan',
        'status_reservasi',
        'metode_pembayaran',
        'base_harga',             
        'pajak',                   
        'total_pembayaran'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function penginapan()
    {
        return $this->belongsTo(admin_konten_penginapan::class, 'id_penginapan');
    }
}