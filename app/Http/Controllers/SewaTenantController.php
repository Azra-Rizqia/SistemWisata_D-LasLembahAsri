<?php

namespace App\Http\Controllers;

use App\Models\SewaTenant;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;

class SewaTenantController extends Controller
{
    // Nampilkan semua data
    public function index()
    {
        $sewa_kio = SewaTenant::with(['tenant', 'user'])
            ->orderBy('created_at', 'desc') // ← DATA TERBARU DI ATAS
            ->get();
        $totalPendapatan = SewaTenant::sum('harga_sewa_tenant');
        $totalData = SewaTenant::count('id_tenant');

        return view('sewa_kios.index', compact('sewa_kio', 'totalPendapatan', 'totalData'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        $users = User::all();

        return view('sewa_kios.create', compact('tenants', 'users'));
    }

    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds', true);
    }

    // Membuat sewa tenant
    public function store(Request $request)
    {
        $totalPembayaran = $request->harga_sewa_tenant;
        $id = $request->id;
        $validated = $request->validate([
            'id',
            'tanggal_mulai_sewa' => 'required|date',
            'tanggal_selesai_sewa' => 'required|date|after_or_equal:tanggal_mulai_sewa',
            'status_pembayaran_tenant' => 'Unpaid',
            'metode_pembayaran' => 'required|in:Debit,QRIS',
            'harga_sewa_tenant' => 'required|integer',
            'id_tenant' => 'required|exists:tenant,id',
            'id_user' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->id_user);
        $params = [
            'transaction_details' => [
                'order_id' => $id,
                'gross_amount' => $totalPembayaran,
            ],
            'customer_details' => [
                'first_name' => $user->name ?? $user->nama_user ?? 'Tamu',
                'email' => $user->email ?? $user->email_user ?? 'guest@example.com',
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $sewa = SewaTenant::create(
            collect($validated)->except('metode_pembayaran')->toArray()
        );

        $sewa->setAttribute('Metode Pembayaran', $validated['metode_pembayaran']);
        $sewa->save();

        return redirect()
            ->route('sewa_kios.index')
            ->with('success', 'Sewa tenant berhasil ditambahkan');
    }



    // detail  sewa tenant
    public function show(SewaTenant $sewa_kio)
    {
        return view('sewa_kios.show', compact('sewa_kio'));
    }

    public function edit(SewaTenant $sewa_kio)
    {
        $tenants = Tenant::all();
        $users = User::all();

        return view('sewa_kios.edit', compact('sewa_kio', 'tenants', 'users'));
    }

    // update sewa tenant
    public function update(Request $request, SewaTenant $sewa_kio)
    {
        $validated = $request->validate([
            'tanggal_mulai_sewa' => 'required|date',
            'tanggal_selesai_sewa' => 'required|date|after_or_equal:tanggal_mulai_sewa',
            'status_pembayaran_tenant' => 'required|in:Menunggu,Dibayar,Dibatalkan',
            'harga_sewa_tenant' => 'required|integer',
            'id_tenant' => 'required|exists:tenant,id',
            'id_user' => 'required|exists:users,id',
        ]);

        $sewa_kio->update($validated);

        return redirect()
            ->route('sewa_kios.index')
            ->with('success', 'Data sewa tenant berhasil diperbarui');
    }



    // Menghapus tenant
    public function destroy($id)
    {
        $sewa = SewaTenant::findOrFail($id);
        $sewa->delete();
        return redirect()
            ->route('sewa_kios.index')
            ->with('success', 'Sewa tenant berhasil dihapus');
    }
}
