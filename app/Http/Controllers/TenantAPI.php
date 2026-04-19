<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Validator;

class TenantAPI extends Controller
{
    public function index()
    {
        return response()->json(Tenant::all());
        $fasilitas = Fasilitas::all();
        
        return response()->json([
            'status' => 'success',
            'data' => $tenant
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'lokasi_tenant' => 'required|string',
        'status_tenant' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422); // Gunakan 422 untuk Unprocessable Entity
        }

        $tenant = Tenant::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'data' => $tenant
        ], 201);
    }

    public function show($id)
    {
        $tenant = Tenant::findOrFail($id);

        if (!$tenant) {
            return response()->json([
                'message' => 'Tenant tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $tenant
        ]);
    }

    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $tenant->update($request->all());
        if (!$tenant) {
            return response()->json([
                'message' => 'Tenant tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $tenant
        ]);
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();

        return response()->json(['message' => 'Tenant berhasil dihapus']);
    } 
}
