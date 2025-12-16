<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasilitas;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        Fasilitas::create([
            'nama_fasilitas' => 'Aula Serbaguna',
            'deskripsi_singkat' => 'Aula luas untuk acara besar',
            'tentang_fasilitas' => 'Aula serbaguna dengan kapasitas hingga 300 orang.',
            'harga_fasilitas' => 2500000,
            'status_fasilitas' => 'tersedia',
            'fasilitas_tersedia' => [
                'AC',
                'Sound System',
                'Proyektor',
                'Kursi & Meja'
            ],
            'fasilitas_tambahan' => [
                'Dekorasi',
                'Catering'
            ],
            'url_gambar_fasilitas' => 'aula.jpg',
        ]);

        Fasilitas::create([
            'nama_fasilitas' => 'Ruang Meeting',
            'deskripsi_singkat' => 'Ruang rapat nyaman',
            'tentang_fasilitas' => 'Ruang meeting ber-AC.',
            'harga_fasilitas' => 750000,
            'status_fasilitas' => 'tersedia',
            'fasilitas_tersedia' => [
                'AC',
                'TV',
                'Whiteboard',
                'WiFi'
            ],
            'fasilitas_tambahan' => [
                'Snack',
                'Minuman'
            ],
            'url_gambar_fasilitas' => 'meeting.jpg',
        ]);
    }
}
