<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'nama_admin' => 'Super Admin',
            'email_admin' => 'admindlas@gmail.com',
            'password_admin' => Hash::make('admin12345!'),
        ]);
    }
}
