<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaTenant extends Model
{
    use HasFactory;
    protected $table = 'sewa_tenant';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'no_pembayaran',
        'tanggal_mulai_sewa',
        'tanggal_selesai_sewa',
        'status_pembayaran_tenant',
        'metode_pembayaran',
        'harga_sewa_tenant',
        'id_tenant',
        'id_user',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'id_tenant');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    protected static function booted()
    {
        static::saved(function ($sewa) {
            $tenant = $sewa->tenant;

            if (!$tenant) return;

            if (
                $sewa->status_pembayaran_tenant === 'Dibayar' &&
                $sewa->tanggal_selesai_sewa >= now()->toDateString()
            ) {
                $tenant->update(['status_tenant' => 'Ditempati']);
                return;
            }

            if (
                $sewa->status_pembayaran_tenant === 'Menunggu' &&
                $sewa->tanggal_mulai_sewa >= now()->toDateString()
            ) {
                $tenant->update(['status_tenant' => 'Belum Dibayar']);
                return;
            }

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
