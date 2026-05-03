<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // protected $table = 'users';
    // protected $primaryKey = null;
    // public $incrementing = false;

    protected $fillable = [
        'nama_user',
        'email_user',
        'password_user',
        'no_hp_user',
        'alamat_user'
    ];

    protected $hidden = [
        'password_user',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password_user;
    }

    public function reservasiPenginapan()
    {
        return $this->hasMany(reservasi_penginapan::class, 'user_id');
    }
}
