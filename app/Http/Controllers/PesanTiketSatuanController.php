<?php

namespace App\Http\Controllers;

use App\Models\PesanTiketSatuan;
use Illuminate\Http\Request;

class PesanTiketSatuanController extends Controller
{
    /**
     * Menampilkan halaman tiket satuan
     */
    public function index()
    {
        $pesanan = PesanTiketSatuan::orderBy('created_at', 'desc')->get();

        $totalPendapatan = PesanTiketSatuan::where('status_pembayaran', 'selesai')
            ->sum('total_pembayaran');

        $totalPembelian = PesanTiketSatuan::count();

        return view('pesan_tiket_satuan.index', compact(
            'pesanan',
            'totalPendapatan',
            'totalPembelian'
        ));
    }

    public function create()
    {
        return view('pesan_tiket_satuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'nama_tiket' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'jumlah_tiket' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer|min:0',
            'status_pembayaran' => 'required|in:pending,selesai',
        ]);

        PesanTiketSatuan::create([
            'nama_pemesan' => $request->nama_pemesan,
            'nama_tiket' => $request->nama_tiket,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'jumlah_tiket' => $request->jumlah_tiket,
            'harga_satuan' => $request->harga_satuan,
            'status_pembayaran' => $request->status_pembayaran,
            // total_pembayaran dihitung otomatis di model
        ]);

        return redirect()->route('pesan-tiket.index')
            ->with('success', 'Data tiket satuan berhasil ditambahkan');
    }

    /**
     * Detail transaksi tiket satuan
     */
    public function show(PesanTiketSatuan $pesanTiketSatuan)
    {
        return view('pesan_tiket_satuan.show', compact('pesanTiketSatuan'));
    }

    /**
     * Form edit tiket satuan
     */
    public function edit(PesanTiketSatuan $pesanTiketSatuan)
    {
        return view('pesan_tiket_satuan.edit', compact('pesanTiketSatuan'));
    }

    /**
     * Update transaksi tiket satuan
     */
    public function update(Request $request, PesanTiketSatuan $pesanTiketSatuan)
    {
        $request->validate([
            'nama_pemesan' => 'required|string|max:255',
            'nama_tiket' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'jumlah_tiket' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer|min:0',
            'status_pembayaran' => 'required|in:pending,selesai',
        ]);

        $pesanTiketSatuan->update($request->all());

        return redirect()->route('pesan-tiket.index')
            ->with('success', 'Data tiket satuan berhasil diperbarui');
    }

    /**
     * Hapus transaksi tiket satuan
     */
    public function destroy(PesanTiketSatuan $pesanTiketSatuan)
    {
        $pesanTiketSatuan->delete();

        return redirect()->route('pesan-tiket.index')
            ->with('success', 'Data tiket satuan berhasil dihapus');
    }
}
