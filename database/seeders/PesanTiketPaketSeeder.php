<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesanTiketPaket;
use App\Models\User;
use App\Models\TiketPaket;

class PesanTiketPaketSeeder extends Seeder
{
    public function run(): void
    {
        // ambil 1 user & 1 tiket paket (pastikan sudah ada datanya)
        $user = User::first();
        $tiket = TiketPaket::first();

        PesanTiketPaket::create([
            'deskripsi_tiket'   => 'Pesanan tiket paket via seeder',
            'harga_pesanan'     => $tiket->harga_tiket ?? 100000,
            'jumlah_tiket'      => 2,
            'status'            => 'Tersedia',
            'tanggal_pembelian' => now()->toDateString(),
            'qr_tiket'          => uniqid('QR-'),
            'id_user'           => $user?->id,
            'id_tiket_paket'    => $tiket?->id,
        ]);
    }
}
