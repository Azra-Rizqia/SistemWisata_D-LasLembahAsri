<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FasilitasAPI extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();
        
        return response()->json([
            'status' => 'success',
            'data' => $fasilitas
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'required|string|max:150',
            'deskripsi_singkat' => 'nullable|string|max:255',
            'tentang_fasilitas' => 'nullable|string',
            'harga_fasilitas' => 'required|integer|min:0',
            'status_fasilitas' => 'required|in:tersedia,tidak_tersedia',
            'fasilitas_tersedia' => 'nullable|array',
            'fasilitas_tambahan' => 'nullable|array',
            'gambar_fasilitas' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 408);
        }

        $fasilitas = Fasilitas::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'data' => $fasilitas
        ], 201);
    }
    
    public function show(int $id)
    {
        $fasilitas = Fasilitas::find($id);

        if (!$fasilitas) {
            return response()->json([
                'message' => 'Fasilitas tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $fasilitas
        ]);
    }

    public function update(Request $request, int $id)
    {
        $fasilitas = Fasilitas::find($id);

        if (!$fasilitas) {
            return response()->json([
                'message' => 'Fasilitas tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'sometimes|required|string|max:150',
            'deskripsi_singkat' => 'nullable|string|max:255',
            'tentang_fasilitas' => 'nullable|string',
            'harga_fasilitas' => 'sometimes|required|integer|min:0',
            'status_fasilitas' => 'sometimes|required|in:tersedia,tidak_tersedia',
            'fasilitas_tersedia' => 'nullable|array',
            'fasilitas_tambahan' => 'nullable|array',
            'gambar_fasilitas' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 408);
        }

        $fasilitas->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $fasilitas
        ]);
    }

    public function destroy(int $id)
    {
        $fasilitas = Fasilitas::find($id);

        if (!$fasilitas) {
            return response()->json([
                'message' => 'Fasilitas tidak ditemukan'
            ], 404);
        }

        $fasilitas->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Fasilitas berhasil dihapus'
        ]);
    }
}