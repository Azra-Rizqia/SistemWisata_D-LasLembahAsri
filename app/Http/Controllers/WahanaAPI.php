<?php

namespace App\Http\Controllers;

use App\Models\Wahana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class WahanaAPI extends Controller
{
    public function index()
    {
        $wahana = Wahana::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'status' => 'success',
            'total' => $wahana->count(),
            'data' => $wahana
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_wahana' => 'required|string|max:20',
            'deskripsi_wahana' => 'required|string',
            'tentang_wahana' => 'required|string|max:1000',
            'pengelola_wahana' => 'required|string|max:255',
            'status_wahana' => 'required|in:Aktif,Tidak Aktif',
            'harga_tiket_wahana' => 'required|integer|min:1000',
            'url_gambar_wahana' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        if ($request->hasFile('url_gambar_wahana')) {
            $validated['url_gambar_wahana'] = $request->file('url_gambar_wahana')->store('wahana', 'public');
        }

        $wahana = Wahana::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Wahana berhasil dibuat',
            'data' => $wahana
        ], 201);
    }

    public function show($id)
    {
        $wahana = Wahana::find($id);

        if (!$wahana) {
            return response()->json([
                'status' => 'error',
                'message' => 'Wahana tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $wahana
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $wahana = Wahana::find($id);

        if (!$wahana) {
            return response()->json([
                'status' => 'error',
                'message' => 'Wahana tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_wahana' => 'sometimes|required|string|max:20',
            'deskripsi_wahana' => 'sometimes|required|string',
            'tentang_wahana' => 'sometimes|required|string|max:1000',
            'pengelola_wahana' => 'sometimes|required|string|max:255',
            'status_wahana' => 'sometimes|required|in:Aktif,Tidak Aktif',
            'harga_tiket_wahana' => 'sometimes|required|integer|min:1000',
            'url_gambar_wahana' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $dataUpdate = $validator->validated();

        if ($request->hasFile('url_gambar_wahana')) {
            if ($wahana->url_gambar_wahana) {
                Storage::disk('public')->delete($wahana->url_gambar_wahana);
            }
            $dataUpdate['url_gambar_wahana'] = $request->file('url_gambar_wahana')->store('wahana', 'public');
        }

        $wahana->update($dataUpdate);

        return response()->json([
            'status' => 'success',
            'message' => 'Wahana berhasil diperbarui',
            'data' => $wahana
        ], 200);
    }

    public function destroy($id)
    {
        $wahana = Wahana::find($id);

        if (!$wahana) {
            return response()->json([
                'status' => 'error',
                'message' => 'Wahana tidak ditemukan'
            ], 404);
        }

        if ($wahana->url_gambar_wahana) {
            Storage::disk('public')->delete($wahana->url_gambar_wahana);
        }

        $wahana->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Wahana berhasil dihapus'
        ], 200);
    }
}