<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\admin_tiket_paket;
use Illuminate\Http\Request;

class admin_tiket_paket_controller extends Controller
{
    /**
     * List tiket paket
     */
    public function index()
    {
        $tiketPaket = admin_tiket_paket::latest()->get();
        return view('admin.tiket_paket.index', compact('tiketPaket'));
    }

    /**
     * Simpan tiket paket baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tiket_paket'       => 'required',
            'deskripsi_tiket'        => 'nullable',
            'pengelola_wahana'       => 'nullable',
            'harga_tiket_weekday'    => 'required|numeric',
            'harga_tiket_weekend'    => 'required|numeric',
            'status_tiket'           => 'nullable',
            'qr_tiket'               => 'nullable',
            'id_wahana'              => 'nullable|exists:wahana,id',
        ]);

        admin_tiket_paket::create($request->only([
            'nama_tiket_paket',
            'deskripsi_tiket',
            'pengelola_wahana',
            'harga_tiket_weekday',
            'harga_tiket_weekend',
            'status_tiket',
            'qr_tiket',
            'id_wahana',
        ]));

        return redirect()->back()->with('success', 'Tiket paket berhasil ditambahkan');
    }

    /**
     * Update status tiket
     */
    public function update(Request $request, $id)
    {
        $tiket = admin_tiket_paket::findOrFail($id);
        $tiket->update($request->only('status_tiket'));

        return redirect()->back()->with('success', 'Status tiket berhasil diubah');
    }

    /**
     * Hapus tiket paket
     */
    public function destroy($id)
    {
        admin_tiket_paket::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Tiket paket berhasil dihapus');
    }
}
