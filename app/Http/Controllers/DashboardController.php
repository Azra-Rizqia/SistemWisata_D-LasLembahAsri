<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PesanTiketSatuan;
use App\Models\PesanTiketPaket;
use App\Models\reservasi_penginapan;
use App\Models\ReservasiFasilitas;
use App\Models\SewaTenant;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan'); 

        //TIKET SATUAN
        $tiketSatuan = PesanTiketSatuan::whereYear('tanggal_pembelian', $tahun);
        if ($bulan) $tiketSatuan->whereMonth('tanggal_pembelian', $bulan);

        $sumTiketSatuan   = $tiketSatuan->sum('total_pembayaran');
        $countTiketSatuan = $tiketSatuan->count();
        $qtyTiketSatuan   = $tiketSatuan->sum('jumlah_tiket');


        $tiketPaket = PesanTiketPaket::whereYear('tanggal_pembelian', $tahun);
        if ($bulan) $tiketPaket->whereMonth('tanggal_pembelian', $bulan);

        $sumTiketPaket   = $tiketPaket->sum('harga_pesanan');
        $countTiketPaket = $tiketPaket->count();
        $qtyTiketPaket   = $tiketPaket->sum('jumlah_tiket');

        // PENGINAPAN
        $penginapan = reservasi_penginapan::whereYear('tanggal_pemesanan', $tahun);
        if ($bulan) $penginapan->whereMonth('tanggal_pemesanan', $bulan);

        $sumPenginapan   = $penginapan->sum('total_pembayaran');
        $countPenginapan = $penginapan->count();

        // FASILITAS
        $fasilitas = ReservasiFasilitas::whereYear('tanggal_reservasi', $tahun);
        if ($bulan) $fasilitas->whereMonth('tanggal_reservasi', $bulan);

        $sumFasilitas   = $fasilitas->sum('total_harga_reservasi');
        $countFasilitas = $fasilitas->count();

        // TENANT
        $tenant = SewaTenant::whereYear('tanggal_mulai_sewa', $tahun);
        if ($bulan) $tenant->whereMonth('tanggal_mulai_sewa', $bulan);

        $sumTenant   = $tenant->sum('harga_sewa_tenant');
        $countTenant = $tenant->count();

        // AGREGASI TOTAL
        $totalPendapatan   = $sumTiketPaket + $sumPenginapan + $sumFasilitas + $sumTenant;
        $totalTiketTerjual = $qtyTiketPaket;
        $jumlahPengunjung  = $totalTiketTerjual;

        // DATA CHART PER BULAN
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataPendapatanChart = [];
        $dataPengunjungChart = [];

        for ($i = 1; $i <= 12; $i++) {
            $pendapatan =
                PesanTiketSatuan::whereYear('tanggal_pembelian', $tahun)->whereMonth('tanggal_pembelian', $i)->sum('total_pembayaran') +
                PesanTiketPaket::whereYear('tanggal_pembelian', $tahun)->whereMonth('tanggal_pembelian', $i)->sum('harga_pesanan') +
                reservasi_penginapan::whereYear('tanggal_pemesanan', $tahun)->whereMonth('tanggal_pemesanan', $i)->sum('total_pembayaran') +
                ReservasiFasilitas::whereYear('tanggal_reservasi', $tahun)->whereMonth('tanggal_reservasi', $i)->sum('total_harga_reservasi') +
                SewaTenant::whereYear('tanggal_mulai_sewa', $tahun)->whereMonth('tanggal_mulai_sewa', $i)->sum('harga_sewa_tenant');

            $pengunjung =
                PesanTiketSatuan::whereYear('tanggal_pembelian', $tahun)->whereMonth('tanggal_pembelian', $i)->sum('jumlah_tiket') +
                PesanTiketPaket::whereYear('tanggal_pembelian', $tahun)->whereMonth('tanggal_pembelian', $i)->sum('jumlah_tiket');

            $dataPendapatanChart[] = $pendapatan;
            $dataPengunjungChart[] = $pengunjung;
        }

        $recentTransactions = collect()
            ->merge(
                PesanTiketSatuan::latest()->limit(5)->get()->map(function ($item) {
                    return (object)[
                        'kode' => $item->nomor_pesanan ?? $item->id,  
                        'nama' => $item->nama_pemesan ?? 'Tamu',      
                        'jenis' => 'Tiket Satuan',                    
                        'total' => $item->total_pembayaran,
                        'status' => $item->status ?? null,
                        'tanggal' => $item->tanggal_pembelian         
                    ];
                })
            )
            ->merge(
                PesanTiketPaket::latest()->limit(5)->get()->map(function ($item) {
                    return (object)[
                        'kode' => $item->nomor_pesanan ?? $item->id,
                        'nama' => $item->nama_pemesan ?? 'Tamu',
                        'jenis' => 'Tiket Paket',
                        'total' => $item->harga_total,
                        'status' => $item->status ?? null,
                        'tanggal' => $item->tanggal_kunjungan
                    ];
                })
            )
            ->merge(
                reservasi_penginapan::latest()->limit(5)->get()->map(function ($item) {
                    return (object)[
                        'kode' => $item->nomor_reservasi,  
                        'nama' => $item->user->nama_user ?? 'Tamu',  
                        'jenis' => 'Penginapan',
                        'total' => $item->total_pembayaran,  
                        'status' => $item->status_reservasi, 
                        'tanggal' => $item->tanggal_masuk    
                    ];
                })
            )
            ->merge(
                ReservasiFasilitas::latest()->limit(5)->get()->map(function ($item) {
                    return (object)[
                        'kode' => $item->nomor_reservasi ?? $item->id,
                        'nama' => $item->nama_pemesan ?? 'Tamu',
                        'jenis' => 'Fasilitas',
                        'total' => $item->total_harga_reservasi,
                        'status' => $item->status ?? null,
                        'tanggal' => $item->tanggal_reservasi
                    ];
                })
            )
            ->merge(
                SewaTenant::latest()->limit(5)->get()->map(function ($item) {
                    return (object)[
                        'kode' => $item->nomor_sewa ?? $item->id,
                        'nama' => $item->nama_penyewa ?? 'Tamu',
                        'jenis' => 'Tenant',
                        'total' => $item->harga_sewa_tenant,  
                        'status' => $item->status ?? null,
                        'tanggal' => $item->tanggal_mulai_sewa
                    ];
                })
            )
            ->sortByDesc('tanggal')  
            ->take(10)
            ->values();

        return view('dashboard.index', compact(
            'totalPendapatan',
            'totalTiketTerjual',
            'jumlahPengunjung',
            'countTiketPaket',
            'countPenginapan',
            'countFasilitas',
            'countTenant',
            'months',
            'dataPendapatanChart',
            'dataPengunjungChart',
            'recentTransactions'
        ));
    }
}
