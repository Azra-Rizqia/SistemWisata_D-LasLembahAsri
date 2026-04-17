<?php

namespace App\Http\Controllers;

use App\Models\Wahana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WahanaController extends Controller
{
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

    public function create()
    {
        return view('wahana.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_wahana' => 'required|string|min:5|max:20',
            'deskripsi_wahana' => 'required|string',
            'tentang_wahana' => 'required|string|max:1000',
            'pengelola_wahana' => 'required|string|max:255',
            'status_wahana' => 'required|in:Aktif,Tidak Aktif',
            'harga_tiket_wahana' => 'required|integer|min:1000',
            'url_gambar_wahana' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_wahana.required' => 'Nama wahana wajib diisi',
            'nama_wahana.min' => 'Nama Wahana minimal 5 karakter',
            'nama_wahana.max' => 'Nama Wahana maksimal 20 karakter',

            'harga_tiket_wahana.required' => 'Harga tiket wajib diisi',
            'harga_tiket_wahana.integer' => 'Harga harus berupa angka',
            'harga_tiket_wahana.min' => 'Harga minimal Rp 1000',
        ]);

        if ($request->hasFile('url_gambar_wahana')) {
            $validated['url_gambar_wahana'] =
                $request->file('url_gambar_wahana')->store('wahana', 'public');
        }

        Wahana::create($validated);

        return redirect()
            ->route('wahana.index')
            ->with('success', 'Data wahana berhasil ditambahkan');
    }

    public function show(Wahana $wahana)
    {
        return view('wahana.show', compact('wahana'));
    }

    public function edit(Wahana $wahana)
    {
        return view('wahana.edit', compact('wahana'));
    }

    public function update(Request $request, Wahana $wahana)
    {
        $validated = $request->validate([
            'nama_wahana' => 'required|string|min:5|max:20',
            'deskripsi_wahana' => 'required|string',
            'tentang_wahana' => 'required|string|max:1000',
            'pengelola_wahana' => 'required|string|max:255',
            'status_wahana' => 'required|in:Aktif,Tidak Aktif',
            'harga_tiket_wahana' => 'required|integer|min:1000',
            'url_gambar_wahana' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_wahana.required' => 'Nama wahana wajib diisi',
            'nama_wahana.min' => 'Nama Wahana minimal 5 karakter',
            'nama_wahana.max' => 'Nama Wahana maksimal 20 karakter',
        ]);

        if ($request->hasFile('url_gambar_wahana')) {

            if ($wahana->url_gambar_wahana) {
                Storage::disk('public')->delete($wahana->url_gambar_wahana);
            }

            $validated['url_gambar_wahana'] =
                $request->file('url_gambar_wahana')->store('wahana', 'public');
        }

        $wahana->update($validated);

        return redirect()
            ->route('wahana.index')
            ->with('success', 'Data wahana berhasil diperbarui');
    }

    public function destroy(Wahana $wahana)
    {
        if ($wahana->url_gambar_wahana) {
            Storage::disk('public')->delete($wahana->url_gambar_wahana);
        }

        $wahana->delete();

        return redirect()
            ->route('wahana.index')
            ->with('success', 'Data wahana berhasil dihapus');
    }
}