<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{

    protected $table = 'tenant';
    protected $primaryKey = 'id_tenant';

    protected $fillable = [
        'lokasi_tenant',
        'status_tenant',
    ];

    public function sewaTenant()
    {
        return $this->hasMany(SewaTenant::class, 'id_tenant');
    }

    public function sewaAktif()
    {
        return $this->sewaTenant()
            ->where('status_pembayaran_tenant', 'Dibayar')
            ->whereDate('tanggal_selesai_sewa', '>=', now())
            ->latest()
            ->first();
    }
}
