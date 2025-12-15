<?php

namespace App\Http\Controllers;

use App\Models\ReservasiFasilitas;
use App\Models\Fasilitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReservasiFasilitasController extends Controller
{
    /**
     * Menampilkan seluruh data reservasi
     */
    public function index()
    {
        $reservasi = ReservasiFasilitas::with(['fasilitas', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPendapatan = ReservasiFasilitas::sum('total_harga_reservasi');
        $totalData = ReservasiFasilitas::count();

        return view('reservasi_fasilitas.index', compact(
            'reservasi',
            'totalPendapatan',
            'totalData'
        ));
    }

    public function create()
    {
        $fasilitas = Fasilitas::all();
        $users = User::all();

        return view('reservasi_fasilitas.create', compact('fasilitas', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_reservasi' => 'required|string',
            'tanggal_reservasi' => 'required|date',
            'total_harga_reservasi' => 'required|integer',
            'status_reservasi' => 'required|in:Proses,Selesai,Dibatalkan',
            'metode_pembayaran_reservasi' => 'required|in:Debit,QRIS',
            'catatan_user_reservasi' => 'nullable|string',
            'id_fasilitas' => 'nullable|exists:fasilitas,id',
            'id_user' => 'nullable|exists:users,id',
        ]);

        $validated['kode_reservasi_fasilitas'] = 'RF-' . strtoupper(Str::random(8));

        ReservasiFasilitas::create($validated);

        return redirect()
            ->route('reservasi_fasilitas.index')
            ->with('success', 'Reservasi fasilitas berhasil ditambahkan');
    }

    public function show(ReservasiFasilitas $reservasi_fasilita)
    {
        return view('reservasi_fasilitas.show', compact('reservasi_fasilita'));
    }

    public function edit(ReservasiFasilitas $reservasi_fasilitas)
    {
        $fasilitas = Fasilitas::all();
        $users = User::all();

        return view('reservasi_fasilitas.edit', compact(
            'reservasi_fasilitas',
            'fasilitas',
            'users'
        ));
    }

    public function update(Request $request, ReservasiFasilitas $reservasi_fasilitas)
    {
        $validated = $request->validate([
            'kategori_reservasi' => 'required|string',
            'tanggal_reservasi' => 'required|date',
            'total_harga_reservasi' => 'required|integer',
            'status_reservasi' => 'required|in:Menunggu,Dibayar,Dibatalkan',
            'metode_pembayaran_reservasi' => 'required|in:Debit,QRIS',
            'catatan_user_reservasi' => 'nullable|string',
            'id_fasilitas' => 'nullable|exists:fasilitas,id',
            'id_user' => 'nullable|exists:users,id',
        ]);

        $reservasi_fasilitas->update($validated);

        return redirect()
            ->route('reservasi_fasilitas.index')
            ->with('success', 'Reservasi fasilitas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $reservasi_fasilitas = ReservasiFasilitas::findOrFail($id);
        $reservasi_fasilitas->delete();
        return redirect()
            ->route('reservasi_fasilitas.index')
            ->with('success', 'Reservasi fasilitas berhasil dihapus');
    }
}
