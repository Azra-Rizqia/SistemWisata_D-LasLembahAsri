<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = [
        'nama_admin',
        'email_admin',
        'password_admin',
    ];
    protected $hidden = [
        'password_admin',
        'remember_token',
    ];
    public function getAuthPassword(): mixed
    {
        return $this->password_admin;
    }
}
