<?php

namespace App\Http\Controllers;

use App\Models\Wahana;
use Illuminate\Http\Request;

class WahanaController extends Controller
{
    public function index()
    {
        $wahana = Wahana::all();
        return view('wahana.index', compact('wahana'));
    }

    public function create()
    {
        return view('wahana.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_wahana' => 'required',
            'deskripsi_wahana' => 'required',
            'harga_tiket_wahana' => 'required|integer',
        ]);

        Wahana::create($request->all());

        return redirect()->route('wahana.index')
            ->with('success', 'Wahana berhasil ditambahkan');
    }

    public function edit(Wahana $wahana)
    {
        return view('wahana.edit', compact('wahana'));
    }

    public function update(Request $request, Wahana $wahana)
    {
        $request->validate([
            'nama_wahana' => 'required',
            'deskripsi_wahana' => 'required',
            'harga_tiket_wahana' => 'required|integer',
        ]);

        $wahana->update($request->all());

        return redirect()->route('wahana.index')
            ->with('success', 'Wahana berhasil diperbarui');
    }

    public function destroy(Wahana $wahana)
    {
        $wahana->delete();

        return redirect()->route('wahana.index')
            ->with('success', 'Wahana berhasil dihapus');
    }
}
