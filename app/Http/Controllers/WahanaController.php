<?php

namespace App\Http\Controllers;

use App\Models\Wahana;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WahanaController extends Controller
{
    /**
     * Menampilkan seluruh data wahana
     */
    public function index()
    {
        $wahana = Wahana::orderBy('created_at', 'desc')->get();

        $totalWahana = Wahana::count();
        $wahanaAktif = Wahana::where('status_wahana', 'Aktif')->count();

        return view('wahana.index', compact(
            'wahana',
            'totalWahana',
            'wahanaAktif'
        ));
    }

    /**
     * Form tambah wahana
     */
    public function create()
    {
        return view('wahana.create');
    }

    /**
     * Simpan data wahana
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wahana' => 'required|string|max:255',
            'deskripsi_wahana' => 'required|string',
            'tentang_wahana' => 'required|string|max:1000',
            'pengelola_wahana' => 'required|string|max:255',
            'status_wahana' => 'required|in:Aktif,Tidak Aktif',
            'harga_tiket_wahana' => 'required|integer|min:0',
        ]);

        Wahana::create($validated);

        return redirect()
            ->route('wahana.index')
            ->with('success', 'Data wahana berhasil ditambahkan');
    }

    /**
     * Detail wahana
     */
    public function show(Wahana $wahana)
    {
        return view('wahana.show', compact('wahana'));
    }

    /**
     * Form edit wahana
     */
    public function edit(Wahana $wahana)
    {
        return view('wahana.edit', compact('wahana'));
    }

    /**
     * Update data wahana
     */
    public function update(Request $request, Wahana $wahana)
    {
        $validated = $request->validate([
            'nama_wahana' => 'required|string|max:255',
            'deskripsi_wahana' => 'required|string',
            'tentang_wahana' => 'required|string|max:1000',
            'pengelola_wahana' => 'required|string|max:255',
            'status_wahana' => 'required|in:Aktif,Tidak Aktif',
            'harga_tiket_wahana' => 'required|integer|min:0',
        ]);

        $wahana->update($validated);

        return redirect()
            ->route('wahana.index')
            ->with('success', 'Data wahana berhasil diperbarui');
    }

    /**
     * Hapus data wahana
     */
    public function destroy(Wahana $wahana)
    {
        $wahana->delete();

        return redirect()
            ->route('wahana.index')
            ->with('success', 'Data wahana berhasil dihapus');
    }
}
