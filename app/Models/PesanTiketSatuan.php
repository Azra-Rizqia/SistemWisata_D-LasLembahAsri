<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanTiketSatuan extends Model
{
    use HasFactory;

    protected $table = 'pesan_tiket_satuan';

    protected $fillable = [
        'jumlah_tiket',
        'harga_pesanan',
        'status_pesanan',
        'qr_tiket',
        'id_wahana',
        'id_user',
    ];

    /**
     * Pesanan milik satu wahana
     */
    public function wahana()
    {
        return $this->belongsTo(Wahana::class, 'id_wahana');
    }

    /**
     * Pesanan milik satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
