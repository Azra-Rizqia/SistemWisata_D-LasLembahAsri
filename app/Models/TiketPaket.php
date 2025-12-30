<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketPaket extends Model
{
    protected $table = 'tiket_paket';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_tiket_paket',
        'deskripsi_tiket',
        'pengelola_wahana',
        'harga_tiket_weekday',
        'harga_tiket_weekend',
        'status_tiket',
        'qr_tiket',
        'id_wahana',
    ];

    public function wahana()
    {
        return $this->belongsTo(Wahana::class, 'id_wahana');
    }

    public function pesanTiketPaket()
    {
        return $this->hasMany(PesanTiketPaket::class, 'id_tiket_paket');
    }
}
