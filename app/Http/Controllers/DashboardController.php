<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reservasi_penginapan;
use App\Models\ReservasiFasilitas; // Pastikan model ini ada
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $dashboard = 'Dashboard Page';
        return view('dashboard.index', compact('dashboard'));
        // // 1. Hitung Total Pendapatan (Penginapan + Fasilitas yang Selesai)
        // $pendapatanPenginapan = reservasi_penginapan::where('status_reservasi', 'Selesai')->sum('total_pembayaran');
        // // Asumsi kolom di fasilitas adalah 'total_harga_reservasi'
        // // $pendapatanFasilitas = ReservasiFasilitas::where('status_reservasi', 'Selesai')->sum('total_harga_reservasi'); 
        
        // $totalPendapatan = $pendapatanPenginapan + $pendapatanFasilitas;

        // // 2. Hitung Total Transaksi
        // $countPenginapan = reservasi_penginapan::count();
        // // $countFasilitas = ReservasiFasilitas::count();
        // // $totalTransaksi = $countPenginapan + $countFasilitas;

        // // 3. Hitung Total User/Pengunjung
        // $totalUser = User::where('role', '!=', 'admin')->count(); // Asumsi ada kolom role, atau hitung semua User::count()

        // // 4. Ambil 5 Transaksi Terbaru (Penginapan)
        // $recentPenginapan = reservasi_penginapan::with(['user', 'penginapan'])
        //     ->latest()
        //     ->take(5)
        //     ->get();

        // return view('dashboard.index', compact(
        //     'totalPendapatan',
        //     'countPenginapan',
        //     'countFasilitas',
        //     'totalUser',
        //     'recentPenginapan'
        // ));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    
}
