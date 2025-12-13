<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Wahana;

class admin_tiket_paket extends Model
{
    use HasFactory;

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
        'id_wahana'
    ];

    public function wahana()
    {
        return $this->belongsTo(Wahana::class, 'id_wahana');
    }
}
