<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wahana extends Model
{
    use HasFactory;

    protected $table = 'wahana';

    protected $fillable = [
        'nama_wahana',
        'deskripsi_wahana',
        'tentang_wahana',
        'pengelola_wahana',
        'status_wahana',
        'harga_tiket_wahana',
        'jumlah',
        'url_gambar_wahana',
    ];

    /**
     * 1 wahana punya banyak pesanan tiket
     */
    public function pesananTiket()
    {
        return $this->hasMany(PesanTiketSatuan::class, 'id_wahana');
    }
}
