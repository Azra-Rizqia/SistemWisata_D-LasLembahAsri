<?php

namespace App\Http\Controllers;

use App\Models\PesanTiketPaket;
use App\Models\TiketPaket;
use App\Models\User;
use Illuminate\Http\Request;

class PesanTiketPaketController extends Controller
{
    public function index()
    {
        $pesanan = PesanTiketPaket::with(['user', 'tiketPaket'])->get();

        $totalPendapatan = $pesanan->sum(function ($item) {
        return $item->harga_pesanan * $item->jumlah_tiket;
    });

        $totalData = $pesanan->count();

        return view('pesan_tiket_paket.index', compact(
            'pesanan',
            'totalPendapatan',
            'totalData'
    ));
    }



    public function create()
    {
        $tiketPaket = TiketPaket::where('status_tiket', 'Tersedia')->get();
        $users = User::all();

        return view('pesan_tiket_paket.create', compact('tiketPaket', 'users'));
    }


        public function store(Request $request)
    {
        $request->validate([
            'id_tiket_paket'    => 'required|exists:tiket_paket,id',
            'id_user'           => 'required|exists:users,id',
            'jumlah_tiket'      => 'required|integer|min:1',
            'tanggal_pembelian' => 'required',
            'status_pesanan'    => 'required', 
            'harga_pesanan'     => 'required|numeric', 
        ], [
            'id_user.required' => 'Harap Memilih Pengguna / User Terlebih Dahulu !!!',
            'id_tiket_paket.required' => 'Harap Memasukkan Paket Terlebih Dahulu !!!',
        ]);

        $tiket = \App\Models\TiketPaket::findOrFail($request->id_tiket_paket);
        $kode_pesan_tiket = 'PSN-' . strtoupper(uniqid());

        // --- LOGIC MIDTRANS START ---
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $kode_pesan_tiket,
                'gross_amount' => (int) $request->harga_pesanan,
            ],
            'customer_details' => [
                'first_name' => 'Customer Arthur', // Bisa ganti jadi $request->user()->name jika login
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        // --- LOGIC MIDTRANS END ---

        \App\Models\PesanTiketPaket::create([
            'kode_pesan_tiket'  => $kode_pesan_tiket,
            'id_tiket_paket'    => $request->id_tiket_paket,
            'id_user'           => $request->id_user,
            'deskripsi_tiket'   => 'Pembelian ' . $tiket->nama_tiket_paket,
            'harga_pesanan'     => $request->harga_pesanan,
            'jumlah_tiket'      => $request->jumlah_tiket,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'status'            => $request->status_pesanan,
            'qr_tiket'          => 'QR-' . uniqid(),
            'snap_token'        => $snapToken, // Token tersimpan otomatis di phpMyAdmin
        ]);

        return redirect()->route('pesan_tiket_paket.index')
            ->with('success', 'Transaksi berhasil disimpan dan token pembayaran siap!');
    }    

    public function show($id)
    {
        // Ambil data dengan relasi user dan tiketPaket
        $pesananTiket = PesanTiketPaket::with(['user', 'tiketPaket'])->findOrFail($id);
        
        // Pastikan nama variabel di compact adalah 'pesananTiket'
        return view('pesan_tiket_paket.show', compact('pesananTiket'));
    }

    // EDIT
    public function edit($id)
    {
        $pesananTiket = PesanTiketPaket::findOrFail($id);
        $users = User::all();
        $tiketPaket = TiketPaket::all();
        
        return view('pesan_tiket_paket.edit', compact('pesananTiket', 'users', 'tiketPaket'));
    }

    // UPDATE
    public function update(Request $request, PesanTiketPaket $pesan_tiket_paket)
    {
        $validated = $request->validate([
            'jumlah_pesanan' => 'required|integer|min:1',
            'status_pesanan' => 'required|in:Proses,Selesai,Dibatalkan',
        ]);

        $pesan_tiket_paket->update([
            'jumlah_tiket' => $validated['jumlah_pesanan'],
            'status'       => $validated['status_pesanan'],
        ]);

        return redirect()
            ->route('pesan_tiket_paket.index')
            ->with('success', 'Pesanan berhasil diperbarui');
    }

    // DESTROY
    public function destroy(PesanTiketPaket $pesan_tiket_paket)
    {
        $pesan_tiket_paket->delete();

        return redirect()
            ->route('pesan_tiket_paket.index')
            ->with('success', 'Pesanan berhasil dihapus');
    }
}
