<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    // Menampilkan tenant
    public function index()
    {
        return response()->json(Tenant::all());
    }

    // Simpan tenant
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lokasi_tenant' => 'required|string',
            'status_tenant' => 'nullable|string',
        ]);

        $tenant = Tenant::create($validated);

        return response()->json([
            'message' => 'Tenant berhasil dibuat',
            'data' => $tenant
        ]);
    }

    // Detail tenant
    public function show($id)
    {
        $tenant = Tenant::findOrFail($id);
        return response()->json($tenant);
    }

    // update tenant
    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $tenant->update($request->all());

        return response()->json([
            'message' => 'Tenant berhasil diperbarui',
            'data' => $tenant
        ]);
    }

    // hapus tenant
    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        return response()->json(['message' => 'Tenant berhasil dihapus']);
    }
}
