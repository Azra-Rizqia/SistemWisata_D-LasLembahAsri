<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama_user' => 'Admin',
            'email_user' => 'admin@gmail.com',
            'password_user' => Hash::make('password'),
        ]);

        User::create([
            'nama_user' => 'Budi',
            'email_user' => 'budi@gmail.com',
            'password_user' => Hash::make('password'),
        ]);
    }
}
