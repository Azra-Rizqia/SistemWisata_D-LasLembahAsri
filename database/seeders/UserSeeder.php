<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_user' => 'Admin',
            'email_user' => 'admin@mail.com',
            'password_user' => Hash::make('password'),
        ]);

        User::create([
            'nama_user' => 'Budi',
            'email_user' => 'budi@mail.com',
            'password_user' => Hash::make('password'),
        ]);
    }
}
