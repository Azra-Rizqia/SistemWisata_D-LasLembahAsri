<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanTiketPaket extends Model
{
    protected $table = 'pesan_tiket_paket';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_pesan_tiket',
        'id_tiket_paket',
        'id_user',
        'deskripsi_tiket',
        'harga_pesanan',
        'jumlah_tiket',
        'tanggal_pembelian',
        'status',
        'qr_tiket',
        'snap_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function tiketPaket()
    {
        return $this->belongsTo(TiketPaket::class, 'id_tiket_paket');
    }
}
