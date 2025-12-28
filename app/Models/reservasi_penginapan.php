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
        'tanggal_masuk',           // Sebelumnya tgl_checkin
        'tanggal_keluar',          // Sebelumnya tgl_checkout
        'catatan_user_reservasi',
        'tanggal_pemesanan',
        'status_reservasi',
        'metode_pembayaran',
        'base_harga',              // Tambahan dari schema
        'pajak',                   // Tambahan dari schema
        'total_pembayaran'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Penginapan
    public function penginapan()
    {
        // Sesuaikan 'id_penginapan' dengan foreign key di tabel kamu
        return $this->belongsTo(admin_konten_penginapan::class, 'id');
    }
}