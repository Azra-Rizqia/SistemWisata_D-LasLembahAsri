<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin_tiket_paket;
use App\Models\User;

class admin_pesan_tiket_paket extends Model
{
    use HasFactory;

    protected $table = 'pesan_tiket_paket';

    protected $primaryKey = 'id';

    protected $fillable = [
        'deskripsi_tiket',
        'harga_pesanan',
        'jumlah_tiket',
        'status',
        'tanggal_pembelian',
        'qr_tiket',
        'id_user',
        'id_tiket_paket'
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relasi ke tiket paket
     */
    public function tiketPaket()
    {
        return $this->belongsTo(
            admin_tiket_paket::class,
            'id_tiket_paket'
        );
    }
}
