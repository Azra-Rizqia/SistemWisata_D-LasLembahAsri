<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\admin_konten_penginapan;

class KontenPenginapanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $penginapan = admin_konten_penginapan::all();
        $penginapan = admin_konten_penginapan::paginate(10);
        return view('konten.penginapan.index', compact('penginapan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('konten.penginapan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_penginapan' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string', 
            'deskripsi_penginapan' => 'nullable|string',
            'harga_weekend' => 'required|integer',
            'harga_weekday' => 'required|integer',
            'fasilitas_tersedia' => 'nullable|array',
            'status_tersedia' => 'boolean',
            'url_gambar_penginapan' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',

            'fasilitas' => 'nullable|array',
            'fasilitas.*.nama' => 'required|string',
            'fasilitas.*.icon' => 'nullable|image|mimes:svg,png,jpg|max:1024',
        ]);

        $pathFoto = null;
        if ($request->hasFile('url_gambar_penginapan')) {
            $pathFoto = $request->file('url_gambar_penginapan')->store('penginapan', 'public');
        }
        
        $fasilitasData = [];
        if ($request->has('fasilitas')) {
            foreach ($request->fasilitas as $item) {
                $iconPath = null;
                
                if (isset($item['icon']) && $item['icon'] instanceof \Illuminate\Http\UploadedFile) {
                    $iconPath = $item['icon']->store('penginapan/icon', 'public');
                }

                $fasilitasData[] = [
                    'nama' => $item['nama'],
                    'icon' => $iconPath
                ];
            }
        }

        admin_konten_penginapan::create([
            'nama_penginapan' => $data['nama_penginapan'],
            'deskripsi_singkat' => $data['deskripsi_singkat'] ?? null,
            'deskripsi_penginapan' => $data['deskripsi_penginapan'] ?? null,
            'harga_weekend' => $data['harga_weekend'],
            'harga_weekday' => $data['harga_weekday'],
            'fasilitas_tersedia' => $fasilitasData,
            'status_tersedia' => $data['status_tersedia'] ?? true,
            'url_gambar_penginapan' => $pathFoto,
        ]);
        return redirect()->route('konten.penginapan.index')->with('success', 'Konten penginapan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = admin_konten_penginapan::findOrFail($id);
        return view('konten.penginapan.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = admin_konten_penginapan::findOrFail($id);
        return view('konten.penginapan.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penginapan = admin_konten_penginapan::findOrFail($id);
        $data = $request->validate([
            'nama_penginapan' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string',
            'deskripsi_penginapan' => 'nullable|string',
            'harga_weekend' => 'required|integer',
            'harga_weekday' => 'required|integer',
            'fasilitas_tersedia' => 'nullable|array',
            'status_tersedia' => 'boolean',
            'url_gambar_penginapan' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($request->hasFile('url_gambar_penginapan')) {
            $pathFoto = $request->file('url_gambar_penginapan')->store('penginapan', 'public');
            $data['url_gambar_penginapan'] = $pathFoto;
        }

        $fasilitasBaru = [];
        $oldFasilitas = $penginapan->fasilitas_tersedia ?? [];
        
        // Logika update fasilitas disederhanakan agar tidak error jika tidak ada upload baru
        if ($request->has('fasilitas')) {
            foreach ($request->fasilitas as $index => $item) {
                // Ambil path lama jika ada
                $iconPath = $oldFasilitas[$index]['icon'] ?? null;  
                
                // Jika ada upload baru, timpa path
                if (isset($item['icon']) && $item['icon'] instanceof \Illuminate\Http\UploadedFile) {
                    $iconPath = $item['icon']->store('penginapan/icon', 'public');
                }
                
                $fasilitasBaru[] = [
                    'nama' => $item['nama'],
                    'icon' => $iconPath
                ];
            }
            $data['fasilitas_tersedia'] = $fasilitasBaru;
        }

        $penginapan->update($data);
        return redirect()->route('konten.penginapan.index')->with('success', 'Konten penginapan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penginapan = admin_konten_penginapan::findOrFail($id);

        if ($penginapan->url_gambar_penginapan) {
            Storage::disk('public')->delete($penginapan->url_gambar_penginapan);
        }

        if (!empty($penginapan->fasilitas_tersedia)) {
            foreach ($penginapan->fasilitas_tersedia as $fasilitas) {
                if (isset($fasilitas['icon'])) {
                    Storage::disk('public')->delete($fasilitas['icon']);
                }
            }
        }

        $penginapan->delete();
        return redirect()->route('konten.penginapan.index')->with('success', 'Konten penginapan berhasil dihapus');
    }
}