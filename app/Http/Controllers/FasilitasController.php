<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class fasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();
        return view('fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('fasilitas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_fasilitas' => 'required|string|max:150',
            'deskripsi_singkat' => 'nullable|string|max:255',
            'tentang_fasilitas' => 'nullable|string',
            'harga_fasilitas' => 'required|integer|min:0',
            'status_fasilitas' => 'required|in:tersedia,tidak_tersedia',
            'fasilitas_tersedia' => 'nullable|array',
            'fasilitas_tambahan' => 'nullable|array',
            'gambar_fasilitas' => 'nullable|string|max:255',
        ]);

        Fasilitas::create($data);

        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan');
    }

    public function show(Fasilitas $fasilitas)
    {
        return view('fasilitas.show', compact('fasilitas'));
    }

    public function edit(Fasilitas $fasilitas)
    {
        return view('fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, Fasilitas $fasilitas)
    {
        $data = $request->validate([
            'nama_fasilitas' => 'required|string|max:150',
            'deskripsi_singkat' => 'nullable|string|max:255',
            'tentang_fasilitas' => 'nullable|string',
            'harga_fasilitas' => 'required|integer|min:0',
            'status_fasilitas' => 'nullable|in:tersedia,tidak_tersedia',
            'fasilitas_tersedia' => 'nullable|array',
            'fasilitas_tambahan' => 'nullable|array',
            'gambar_fasilitas' => 'nullable|string|max:255',
        ]);

        $fasilitas->update($data);

        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil diupdate');
    }

    public function destroy(Fasilitas $fasilitas)
    {
        $fasilitas->delete();
        return redirect()->route('fasilitas.index')->with('success', 'Fasilitas berhasil dihapus');
    }
}
