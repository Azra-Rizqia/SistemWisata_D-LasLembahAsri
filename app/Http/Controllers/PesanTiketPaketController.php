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
        $pesanan = PesanTiketPaket::with(['user', 'tiketPaket'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPendapatan = PesanTiketPaket::selectRaw('SUM(harga_pesanan * jumlah_tiket) as total')->value('total') ?? 0;
        $totalData = PesanTiketPaket::count();

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
        $validated = $request->validate([
            'id_tiket_paket'   => 'required|exists:tiket_paket,id',
            'id_user'          => 'required|exists:users,id',
            'jumlah_pesanan'   => 'required|integer|min:1',
            'tanggal_pembelian'=> 'required|date',
            'status_pesanan'   => 'required|in:Proses,Selesai,Dibatalkan',
            'total_pembayaran' => 'required|integer',
            'metode_pembayaran'=> 'required|string',
        ]);

        PesanTiketPaket::create([
            'id_tiket_paket'   => $validated['id_tiket_paket'],
            'id_user'          => $validated['id_user'],
            'deskripsi_tiket'  => 'Pesanan tiket',
            'harga_pesanan'     => 100000,
            'jumlah_tiket'     => $validated['jumlah_pesanan'],
            'tanggal_pembelian'=> $validated['tanggal_pembelian'],
            'status'           => $validated['status_pesanan'],
            'qr_tiket'         => uniqid('QR-'),
        ]);

        return redirect()
            ->route('pesan_tiket_paket.index')
            ->with('success', 'Pesanan tiket paket berhasil ditambahkan');
    }

    // SHOW
    public function show(PesanTiketPaket $pesan_tiket_paket)
    {
        return view('pesan_tiket_paket.show', compact('pesan_tiket_paket'));
    }

    // EDIT
    public function edit(PesanTiketPaket $pesan_tiket_paket)
    {
        $tiketPaket = TiketPaket::all();
        $users = User::all();

        return view('pesan_tiket_paket.edit', compact(
            'pesan_tiket_paket',
            'tiketPaket',
            'users'
        ));
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
