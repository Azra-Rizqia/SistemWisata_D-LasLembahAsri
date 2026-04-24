<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PesanTiketPaket;
use App\Models\TiketPaket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesanTiketPaketControllerAPI extends Controller
{
    public function index()
    {
        // Mengambil data lengkap dengan relasi user dan tiket paket
        $data = PesanTiketPaket::with(['user', 'tiketPaket'])->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_tiket_paket'    => 'required|exists:tiket_paket,id',
            'id_user'           => 'required|exists:users,id',
            'jumlah_tiket'      => 'required|integer|min:1',
            'tanggal_pembelian' => 'required|date',
            'status'            => 'required|in:Proses,Selesai,Dibatalkan',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Ambil data tiket untuk kalkulasi harga otomatis (Weekday/Weekend)
        $tiket = TiketPaket::findOrFail($request->id_tiket_paket);
        
        $hari = date('w', strtotime($request->tanggal_pembelian));
        $isWeekend = ($hari == 0 || $hari == 6);
        $hargaSatuan = $isWeekend ? $tiket->harga_tiket_weekend : $tiket->harga_tiket_weekday;

        $pesanan = PesanTiketPaket::create([
            'id_tiket_paket'    => $request->id_tiket_paket,
            'id_user'           => $request->id_user,
            'deskripsi_tiket'   => 'Pesanan via API',
            'harga_pesanan'     => $hargaSatuan, 
            'jumlah_tiket'      => $request->jumlah_tiket,
            'tanggal_pembelian' => $request->tanggal_pembelian,
            'status'            => $request->status,
            'qr_tiket'          => 'QR-' . uniqid(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pesanan Tiket berhasil ditambahkan!',
            'data'    => $pesanan
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $pesanan = PesanTiketPaket::find($id);

        if (!$pesanan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'jumlah_tiket' => 'integer|min:1',
            'status'       => 'in:Proses,Selesai,Dibatalkan',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pesanan->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Data pesanan berhasil diperbarui',
            'data' => $pesanan
        ], 200);
    }

    public function destroy($id)
    {
        $pesanan = PesanTiketPaket::find($id);

        if (!$pesanan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $pesanan->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pesanan berhasil dihapus'
        ], 200);
    }
}