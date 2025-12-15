<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanTiketPaket extends Model
{
    protected $table = 'pesan_tiket_paket';

    protected $fillable = [
        'deskripsi_tiket',
        'harga_pesanan',
        'jumlah_tiket',
        'status',
        'tanggal_pembelian',
        'qr_tiket',
        'id_user',
        'id_tiket_paket',
        'total_pembayaran',
        'metode_pembayaran'
    ];

    /* ================= RELATION ================= */

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function tiketPaket()
    {
        return $this->belongsTo(TiketPaket::class, 'id_tiket_paket', 'id');
    }
}
