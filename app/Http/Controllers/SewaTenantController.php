<?php

namespace App\Http\Controllers;

use App\Models\SewaTenant;
use Illuminate\Http\Request;

class SewaTenantController extends Controller
{
    // Nampilkan semua data
    public function index()
    {
        $sewaTenants = SewaTenant::with(['tenant', 'user'])->get();
        $totalPendapatan = SewaTenant::sum('harga_sewa_tenant');
        $totalData = SewaTenant::count('id_tenant');

        return view('sewa_kios.index', compact('sewaTenants', 'totalPendapatan', 'totalData'));
    }


    // Membuat sewa tenant
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_mulai_sewa' => 'required|date',
            'tanggal_selesai_sewa' => 'required|date|after_or_equal:tanggal_mulai_sewa',
            'status_pembayaran_tenant' => 'nullable|string',
            'metode_pembayaran' => 'required|string',
            'harga_sewa_tenant' => 'required|integer',
            'id_tenant' => 'required|exists:tenant,id_tenant',
            'id_user' => 'required|exists:users,id',
        ]);
        $sewa = SewaTenant::create($validated);
        return response()->json([
            'message' => 'Sewa tenant berhasil dibuat',
            'data' => $sewa
        ]);
    }

    // detail  sewa tenant
    public function show($id)
    {
        $sewa = SewaTenant::with(['tenant', 'user'])->findOrFail($id);
        return response()->json($sewa);
    }

    // detail sewa tenant
    public function update(Request $request, $id)
    {
        $sewa = SewaTenant::findOrFail($id);
        $sewa->update($request->all());
        return response()->json([
            'message' => 'Data sewa tenant berhasil diperbarui',
            'data' => $sewa
        ]);
    }

    // Menghapus tenant
    public function destroy($id)
    {
        $sewa = SewaTenant::findOrFail($id);
        $sewa->delete();
        return response()->json(['message' => 'Sewa tenant berhasil dihapus']);
    }
}
