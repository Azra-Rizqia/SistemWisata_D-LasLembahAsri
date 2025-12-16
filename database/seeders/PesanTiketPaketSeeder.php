<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesanTiketPaket;
use Carbon\Carbon;

class PesanTiketPaketSeeder extends Seeder
{
    public function run(): void
    {
        PesanTiketPaket::truncate();

        PesanTiketPaket::create([
            'kode_pesan_tiket' => 'KPT-00001',
            'deskripsi_tiket'  => 'Pesanan Paket Hemat A',
            'harga_pesanan'    => 70000,
            'jumlah_tiket'     => 2,
            'status'           => 'Selesai',
            'tanggal_pembelian'=> Carbon::now(),
            'qr_tiket'         => 'QR-KP-00001',
            'id_user'          => 1,
            'id_tiket_paket'   => 1,
        ]);

        PesanTiketPaket::create([
            'kode_pesan_tiket' => 'KPT-00002',
            'deskripsi_tiket'  => 'Pesanan Paket Keluarga',
            'harga_pesanan'    => 150000,
            'jumlah_tiket'     => 4,
            'status'           => 'Proses',
            'tanggal_pembelian'=> Carbon::now(),
            'qr_tiket'         => 'QR-KP-00002',
            'id_user'          => 1,
            'id_tiket_paket'   => 1,
        ]);
    }
}
