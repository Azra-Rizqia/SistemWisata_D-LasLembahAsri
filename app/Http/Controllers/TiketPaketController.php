<?php

namespace App\Http\Controllers;

use App\Models\TiketPaket;
use Illuminate\Http\Request;

class TiketPaketController extends Controller
{
    public function index()
    {
        $tiketPaket = TiketPaket::all();

        return view('tiket_paket.index', compact('tiketPaket'));
    }

    public function create()
    {
        return view('tiket_paket.create');
    }

    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds', true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => $request->id,
            'nama_tiket_paket'       => $request->nama_tiket_paket,
            'deskripsi_tiket'        => $request->deskripsi_wahana,
            'pengelola_wahana'       => $request->pengelola_wahana,
            'harga_tiket_weekday'    => $request->harga_tiket_weekday,
            'harga_tiket_weekend'    => $request->harga_tiket_weekend,
            'status_tiket'           => 'Unpaid',
        ]);

        $user = User::findOrFail($request->id_user);
        $params = [
            'transaction_details' => [
                'order_id' => $id,
                'gross_amount' => $totalPembayaran,
            ],
            'customer_details' => [
                'first_name' => $user->name ?? $user->nama_user ?? 'Tamu',
                'email' => $user->email ?? $user->email_user ?? 'guest@example.com',
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        TiketPaket::create([
            ...$validated,
            'qr_tiket' => 'QR-TP-' . uniqid(),
        ]);

        return redirect()
            ->route('tiket_paket.index')
            ->with('success', 'Tiket paket berhasil ditambahkan');
    }
    public function edit(TiketPaket $tiket_paket)
    {
        return view('tiket_paket.edit', compact('tiket_paket'));
    }

    public function update(Request $request, TiketPaket $tiket_paket)
    {
        $validated = $request->validate([
            'nama_tiket_paket'      => 'required|string|max:255',
            'deskripsi_tiket'       => 'required|string',
            'pengelola_wahana'      => 'required|string|max:255',
            'harga_tiket_weekday'   => 'required|integer|min:0',
            'harga_tiket_weekend'   => 'required|integer|min:0',
            'status_tiket'          => 'required|in:Tersedia,Tidak Tersedia',
        ]);

        $tiket_paket->update($validated);

        return redirect()
            ->route('tiket_paket.index')
            ->with('success', 'Tiket paket berhasil diperbarui');
    }

    public function show(TiketPaket $tiket_paket)
    {
        return view('tiket_paket.show', compact('tiket_paket'));
    }

    public function destroy(TiketPaket $tiket_paket)
    {
        $tiket_paket->delete();

        return redirect()
            ->route('tiket_paket.index')
            ->with('success', 'Data tiket paket berhasil dihapus');
    }

}
