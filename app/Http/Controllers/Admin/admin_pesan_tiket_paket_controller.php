<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin_pesan_tiket_paket;

class admin_pesan_tiket_paket_controller extends Controller
{
    /**
     * Tampilkan daftar pesanan tiket paket
     */
    public function index()
    {
        $pesanan = admin_pesan_tiket_paket::with(['user', 'tiketPaket'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.pesan_tiket_paket.index', compact('pesanan'));
    }
}
