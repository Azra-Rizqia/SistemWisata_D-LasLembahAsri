<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
    ['email_user' => 'arthur@gmail.com'],
    [
        'nama_user' => 'Arthur',
        'password_user' => bcrypt('password'),
    ]);

    }
}
