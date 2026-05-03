<?php

namespace App\Http\Controllers;

use App\Models\SewaTenant;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SewaTenantController extends Controller
{
    // Nampilkan semua data
    public function index()
    {
        $sewa_kio = SewaTenant::with(['tenant', 'user'])
            ->orderBy('created_at', 'desc')
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


    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_mulai_sewa' => 'required|date',
            'tanggal_selesai_sewa' => 'required|date|after_or_equal:tanggal_mulai_sewa',
            'status_pembayaran_tenant' => 'required|in:Menunggu,Dibayar,Dibatalkan',
            'metode_pembayaran' => 'required',
            'harga_sewa_tenant' => 'required|integer',
            'id_tenant' => 'required|exists:tenant,id',
            'id_user' => 'required|exists:users,id',
        ]);

        $no_pembayaran = 'PT-' . Str::random(8);

        $validated['no_pembayaran'] = $no_pembayaran;

        $sewatenant = SewaTenant::create($validated);

        $user = User::findOrFail($request->id_user);

        // Konfigurasi Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $no_pembayaran,
                'gross_amount' => (int) $sewatenant->harga_sewa_tenant,
            ],
            'customer_details' => [
                'first_name' => $user->nama_user,
                'email' => $user->email_user,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return view('sewa_kios.pay', compact('snapToken', 'sewatenant'));
        } catch (\Exception $e) {
            return "Error Midtrans: " . $e->getMessage();
        }
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key') ?? env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $reservasi = SewaTenant::where('no_pembayaran', $request->order_id)->first();

            if ($reservasi) {
                $status = $request-> transaction_status;
                if ($status == 'capture' || $status == 'settlement') {
                    $reservasi->update(['status_pembayaran_tenant' => 'Dibayar']);
                } else if ($status == 'expire' || $status == 'cancel') {
                    $reservasi->update([
                        'status_pembayaran_tenant' => 'Dibatalkan'
                    ]);
                } else if ($status == 'pending') {
                    $reservasi->update([
                        'status_pembayaran_tenant' => 'Menunggu'
                    ]);
                }
            }
        }
        return response()->json(['message' => 'Notifikasi diterima']);
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
