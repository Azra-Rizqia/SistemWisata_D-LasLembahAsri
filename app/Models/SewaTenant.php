<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SewaTenant extends Model
{
    protected $table = 'sewa_tenant';
    protected $primaryKey = 'id_sewa_tenant';

    protected $fillable = [
        'tanggal_mulai_sewa',
        'tanggal_selesai_sewa',
        'status_pembayaran_tenant',
        'metode_pembayaran',
        'harga_sewa_tenant',
        'id_tenant',
        'id_user',
    ];

    // relasi ke tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'id_tenant');
    }

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // kondisi
    protected static function booted()
    {
        static::saved(function ($sewa) {
            $tenant = $sewa->tenant;

            if (!$tenant) return;

            // Jika pembayaran aktif & masih dalam masa sewa
            if (
                $sewa->status_pembayaran_tenant === 'Dibayar' &&
                $sewa->tanggal_selesai_sewa >= now()->toDateString()
            ) {
                $tenant->update(['status_tenant' => 'Ditempati']);
                return;
            }

            // Jika masih menunggu pembayaran
            if (
                $sewa->status_pembayaran_tenant === 'Menunggu' &&
                $sewa->tanggal_mulai_sewa >= now()->toDateString()
            ) {
                $tenant->update(['status_tenant' => 'Belum Dibayar']);
                return;
            }

            // Jika masa sewa habis atau dibatalkan
            if (
                $sewa->status_pembayaran_tenant === 'Dibatalkan' ||
                $sewa->tanggal_selesai_sewa < now()->toDateString()
            ) {
                $tenant->update(['status_tenant' => 'Tidak Digunakan']);
                return;
            }
        });
    }
}
