<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::create([
            'lokasi_tenant' => 'Kios A-01',
            'status_tenant' => 'Tidak Digunakan',
        ]);

        Tenant::create([
            'lokasi_tenant' => 'Kios A-02',
            'status_tenant' => 'Tidak Digunakan',
        ]);

        Tenant::create([
            'lokasi_tenant' => 'Kios B-01',
            'status_tenant' => 'Perbaikan',
        ]);
    }
}
