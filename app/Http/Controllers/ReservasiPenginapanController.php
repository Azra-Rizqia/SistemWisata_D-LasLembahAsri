<?php

namespace App\Http\Controllers;

use App\Models\reservasi_penginapan;
use App\Models\admin_konten_penginapan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservasiPenginapanController extends Controller
{
    /**
     * Menampilkan seluruh data reservasi
     */
    public function index()
    {
        $reservasi = reservasi_penginapan::with(['penginapan', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10); 

        $totalPendapatan = reservasi_penginapan::where('status_reservasi', 'Selesai')->sum('total_pembayaran');
        $totalData = reservasi_penginapan::count();

        return view('reservasi_penginapan.index', compact(
            'reservasi',
            'totalPendapatan',
            'totalData'
        ));
    }

    /**
     * Menampilkan form tambah reservasi
     */
    public function create()
    {
        $kamar = admin_konten_penginapan::where('status_tersedia', true)->get();
        $users = User::all();

        return view('reservasi_penginapan.create', compact('kamar', 'users'));
    }

    /**
     * Menyimpan data ke database (SESUAI SCHEMA BARU)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Form
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_kamar' => 'required|exists:penginapan,id', 
            'tanggal_checkin' => 'required|date|after_or_equal:today',
            'tanggal_checkout' => 'required|date|after:tanggal_checkin',
            'jumlah_tamu' => 'required|integer|min:1', // Input ini ada di form
            'status_reservasi' => 'required|in:Proses,Selesai,Dibatalkan',
            'metode_pembayaran_reservasi' => 'required|string', 
            'total_harga' => 'required|numeric|min:0',
        ]);

        $nomorReservasi = 'RP-' . strtoupper(Str::random(8));
        
        $totalPembayaran = $request->total_harga;
        $baseHarga = $totalPembayaran / 1.1; 
        $pajak = $totalPembayaran - $baseHarga;

        reservasi_penginapan::create([
            'user_id' => $request->id_user,
            'id_penginapan' => $request->id_kamar,
            'nomor_reservasi' => $nomorReservasi,
            'tanggal_masuk' => $request->tanggal_checkin,
            'tanggal_keluar' => $request->tanggal_checkout,
            'base_harga' => $baseHarga,
            'pajak' => $pajak,
            'total_pembayaran' => $totalPembayaran,
            'status_reservasi' => $request->status_reservasi,
            'metode_pembayaran' => $request->metode_pembayaran_reservasi,
            'tanggal_pemesanan' => now(),
            
            'catatan_user_reservasi' => 'Jumlah Tamu: ' . $request->jumlah_tamu,
        ]);

        return redirect()
            ->route('reservasi_penginapan.index')
            ->with('success', 'Reservasi penginapan berhasil ditambahkan');
    }

    /**
     * Menampilkan detail
     */
    public function show($id)
    {
        $reservasi = reservasi_penginapan::with(['penginapan', 'user'])->findOrFail($id);
        return view('reservasi_penginapan.show', compact('reservasi'));
    }

    /**
     * Menampilkan form edit
     */
    public function edit($id)
    {
        $reservasi = reservasi_penginapan::findOrFail($id);
        $kamar = admin_konten_penginapan::all(); 
        $users = User::all();

        return view('reservasi_penginapan.edit', compact('reservasi', 'kamar', 'users'));
    }

    /**
     * Update data (SESUAI SCHEMA BARU)
     */
    public function update(Request $request, $id)
    {
        $reservasi = reservasi_penginapan::findOrFail($id);

        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_kamar' => 'required|exists:penginapan,id',
            'tanggal_checkin' => 'required|date',
            'tanggal_checkout' => 'required|date|after:tanggal_checkin',
            'status_reservasi' => 'required|in:Proses,Selesai,Dibatalkan',
            'metode_pembayaran_reservasi' => 'required|string',
            'total_harga' => 'required|numeric|min:0',
        ]);

        // Kalkulasi ulang keuangan jika ada perubahan harga
        $totalPembayaran = $request->total_harga;
        $baseHarga = $totalPembayaran / 1.1; 
        $pajak = $totalPembayaran - $baseHarga;

        $reservasi->update([
            'user_id' => $request->id_user,
            'id_penginapan' => $request->id_kamar,
            'tanggal_masuk' => $request->tanggal_checkin,
            'tanggal_keluar' => $request->tanggal_checkout,
            'base_harga' => $baseHarga,
            'pajak' => $pajak,
            'total_pembayaran' => $totalPembayaran,
            'status_reservasi' => $request->status_reservasi,
            'metode_pembayaran' => $request->metode_pembayaran_reservasi,
            // Opsional: Update catatan jika ada input jumlah tamu di edit form
            // 'catatan_user_reservasi' => ... 
        ]);

        return redirect()
            ->route('reservasi_penginapan.index')
            ->with('success', 'Reservasi penginapan berhasil diperbarui');
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        $reservasi = reservasi_penginapan::findOrFail($id);
        $reservasi->delete();

        return redirect()
            ->route('reservasi_penginapan.index')
            ->with('success', 'Reservasi penginapan berhasil dihapus');
    }
}