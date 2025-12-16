<?php

namespace App\Http\Controllers;

use App\Models\PesanTiketSatuan;
use App\Models\Wahana;
use Illuminate\Http\Request;

class PesanTiketSatuanController extends Controller
{
    public function index()
    {
        $pesanan = PesanTiketSatuan::with('wahana')->get();
        return view('pesan_tiket.index', compact('pesanan'));
    }

    public function create()
    {
        $wahana = Wahana::where('status_wahana', 'Tersedia')->get();
        return view('pesan_tiket.create', compact('wahana'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_wahana' => 'required|exists:wahana,id',
            'jumlah_tiket' => 'required|integer|min:1',
        ]);

        $wahana = Wahana::findOrFail($request->id_wahana);

        PesanTiketSatuan::create([
            'id_wahana' => $wahana->id,
            'id_user' => auth()->id(),
            'jumlah_tiket' => $request->jumlah_tiket,
            'harga_pesanan' => $wahana->harga_tiket_wahana * $request->jumlah_tiket,
            'status_pesanan' => 'Pending',
        ]);

        return redirect()->route('pesan-tiket.index')
            ->with('success', 'Pesanan tiket berhasil dibuat');
    }

    public function show(PesanTiketSatuan $pesanTiketSatuan)
    {
        return view('pesan_tiket.show', compact('pesanTiketSatuan'));
    }

    public function destroy(PesanTiketSatuan $pesanTiketSatuan)
    {
        $pesanTiketSatuan->delete();

        return redirect()->route('pesan-tiket.index')
            ->with('success', 'Pesanan tiket dibatalkan');
    }
}
