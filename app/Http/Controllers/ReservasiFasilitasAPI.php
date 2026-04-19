<?php

namespace App\Http\Controllers;

use App\Models\ReservasiFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ReservasiFasilitasAPI extends Controller
{
    public function index()
    {
        $reservasi = ReservasiFasilitas::with(['fasilitas', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $reservasi
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_reservasi' => 'required|string',
            'tanggal_reservasi' => 'required|date',
            'total_harga_reservasi' => 'required|integer',
            'status_reservasi' => 'required|in:Proses,Selesai,Dibatalkan',
            'metode_pembayaran_reservasi' => 'required|in:Debit,QRIS',
            'catatan_user_reservasi' => 'nullable|string',
            'id_fasilitas' => 'nullable|exists:fasilitas,id',
            'id_user' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 408);
        }

        $data = $validator->validated();
        $data['kode_reservasi_fasilitas'] = 'RF-' . strtoupper(Str::random(8));

        $reservasi = ReservasiFasilitas::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $reservasi
        ], 201);
    }

    public function show(int $id)
    {
        $reservasi = ReservasiFasilitas::with(['fasilitas', 'user'])->find($id);

        if (!$reservasi) {
            return response()->json([
                'message' => 'Reservasi fasilitas tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success', 
            'data' => $reservasi
        ]);
    }

    public function update(Request $request, int $id)
    {
        $reservasi = ReservasiFasilitas::find($id);

        if (!$reservasi) {
            return response()->json([
                'message' => 'Reservasi fasilitas tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kategori_reservasi' => 'sometimes|required|string',
            'tanggal_reservasi' => 'sometimes|required|date',
            'total_harga_reservasi' => 'sometimes|required|integer',
            'status_reservasi' => 'sometimes|required|in:Proses,Selesai,Dibatalkan',
            'metode_pembayaran_reservasi' => 'sometimes|required|in:Debit,QRIS',
            'id_fasilitas' => 'nullable|exists:fasilitas,id',
            'id_user' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 408);
        }

        $reservasi->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $reservasi
        ]);
    }

    public function destroy(int $id)
    {
        $reservasi = ReservasiFasilitas::find($id);

        if (!$reservasi) {
            return response()->json([
                'message' => 'Reservasi fasilitas tidak ditemukan'
            ], 404);
        }

        $reservasi->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Reservasi fasilitas berhasil dihapus'
        ]);
    }
}