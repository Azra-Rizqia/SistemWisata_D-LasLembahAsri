<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
<<<<<<< HEAD
    // protected $primaryKey = null;
    // public $incrementing = false;
=======
    protected $primaryKey = null;
    public $incrementing = false;
>>>>>>> 4f7d7e3e0984709077d5ebd57a4ee5554c8b456a

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
