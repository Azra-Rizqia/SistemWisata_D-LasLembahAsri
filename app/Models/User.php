<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

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

    public function pesanTiketPaket()
    {
        return $this->hasMany(PesanTiketPaket::class, 'id_user');
    }
}
