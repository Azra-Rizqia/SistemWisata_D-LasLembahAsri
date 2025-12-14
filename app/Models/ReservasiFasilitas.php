<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservasiFasilitas extends Model
{
    use HasFactory;

    protected $table = 'reservasi_fasilitas';

    protected $fillable = [
        'kode_reservasi_fasilitas',
        'kategori_reservasi',
        'tanggal_reservasi',
        'total_harga_reservasi',
        'status_reservasi',
        'metode_pembayaran_reservasi',
        'catatan_user_reservasi',
        'id_fasilitas',
        'id_user',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
