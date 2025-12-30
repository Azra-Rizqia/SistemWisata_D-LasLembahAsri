<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanTiketPaket extends Model
{
    protected $table = 'pesan_tiket_paket';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_pesan_tiket',
        'deskripsi_tiket',
        'harga_pesanan',
        'jumlah_tiket',
        'status',
        'tanggal_pembelian',
        'qr_tiket',
        'id_user',
        'id_tiket_paket'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function tiketPaket()
    {
        return $this->belongsTo(TiketPaket::class, 'id_tiket_paket');
    }
}
