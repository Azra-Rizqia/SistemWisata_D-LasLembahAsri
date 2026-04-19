<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TiketPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TiketPaketControllerAPI extends Controller
{
    public function index()
    {
        $data = TiketPaket::all();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_tiket_paket' => 'required',
            'harga_tiket_weekday' => 'required|numeric',
            'harga_tiket_weekend' => 'required|numeric',
            'status_tiket' => 'required|in:Tersedia,Tidak Tersedia',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tiket = TiketPaket::create([
            'nama_tiket_paket'    => $request->nama_tiket_paket,
            'deskripsi_tiket'     => $request->deskripsi_tiket,
            'pengelola_wahana'    => $request->pengelola_wahana,
            'harga_tiket_weekday' => $request->harga_tiket_weekday,
            'harga_tiket_weekend' => $request->harga_tiket_weekend,
            'status_tiket'        => $request->status_tiket,
            'qr_tiket'            => 'QR-' . uniqid(),
            'id_wahana'           => $request->id_wahana,
        ]);

        return response()->json([
            'message' => 'Paket Tiket berhasil ditambahkan!',
            'data' => $tiket
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $tiket = TiketPaket::find($id);

        if (!$tiket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'status_tiket' => 'in:Tersedia,Tidak Tersedia',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tiket->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diperbarui',
            'data' => $tiket
        ], 200);
    }

    public function destroy($id)
    {
        $tiket = TiketPaket::find($id);

        if (!$tiket) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $tiket->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ], 200);
    }   
}

