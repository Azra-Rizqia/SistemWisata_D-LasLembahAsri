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
        // FILTER TAHUN & BULAN
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan'); // boleh null

        // TIKET SATUAN
        // $tiketSatuan = PesanTiketSatuan::whereYear('tanggal_pembelian', $tahun);
        // if ($bulan) $tiketSatuan->whereMonth('tanggal_pembelian', $bulan);

        // $sumTiketSatuan   = $tiketSatuan->sum('harga_pesanan');
        // $countTiketSatuan = $tiketSatuan->count();
        // $qtyTiketSatuan   = $tiketSatuan->sum('jumlah_tiket');


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
        $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
        $dataPendapatanChart = [];
        $dataPengunjungChart = [];

        for ($i = 1; $i <= 12; $i++) {
            $pendapatan = 
                // PesanTiketSatuan::whereYear('tanggal_kunjungan', $tahun)->whereMonth('tanggal_kunjungan', $i)->sum('harga_total') +
                PesanTiketPaket::whereYear('tanggal_pembelian', $tahun)->whereMonth('tanggal_pembelian', $i)->sum('harga_pesanan') +
                reservasi_penginapan::whereYear('tanggal_pemesanan', $tahun)->whereMonth('tanggal_pemesanan', $i)->sum('total_pembayaran') +
                ReservasiFasilitas::whereYear('tanggal_reservasi', $tahun)->whereMonth('tanggal_reservasi', $i)->sum('total_harga_reservasi') +
                SewaTenant::whereYear('tanggal_mulai_sewa', $tahun)->whereMonth('tanggal_mulai_sewa', $i)->sum('harga_sewa_tenant');

            $pengunjung =
                // PesanTiketSatuan::whereYear('tanggal_kunjungan', $tahun)->whereMonth('tanggal_kunjungan', $i)->sum('jumlah_tiket') +
                PesanTiketPaket::whereYear('tanggal_pembelian', $tahun)->whereMonth('tanggal_pembelian', $i)->sum('jumlah_tiket');

            $dataPendapatanChart[] = $pendapatan;
            $dataPengunjungChart[] = $pengunjung;
        }

        $recentTransactions = collect()
            ->merge(
                PesanTiketSatuan::latest()->limit(5)->get()->map(function ($item) {
                    return (object)[
                        'tanggal' => $item->tanggal_kunjungan,
                        'kategori' => 'Tiket Satuan',
                        'nama_pemesan' => $item->nama_pemesan ?? 'Tamu',
                        'total' => $item->harga_total,
                        'status' => $item->status ?? null,
                        'created_at' => $item->created_at
                    ];
                })
            )
            ->merge(
                PesanTiketPaket::latest()->limit(5)->get()->map(function ($item) {
                    return (object)[
                        'tanggal' => $item->tanggal_kunjungan,
                        'kategori' => 'Tiket Paket',
                        'nama_pemesan' => $item->nama_pemesan ?? 'Tamu',
                        'total' => $item->harga_total,
                        'status' => $item->status ?? null,
                        'created_at' => $item->created_at
                    ];
                })
            )
            ->merge(
                reservasi_penginapan::latest()->limit(5)->get()->map(function ($item) {
                    return (object)[
                        'tanggal' => $item->tanggal_mulai,
                        'kategori' => 'Penginapan',
                        'nama_pemesan' => $item->nama_pemesan ?? 'Tamu',
                        'total' => $item->total_harga,
                        'status' => $item->status ?? null,
                        'created_at' => $item->created_at
                    ];
                })
            )
            ->merge(
                ReservasiFasilitas::latest()->limit(5)->get()->map(function ($item) {
                    return (object)[
                        'tanggal' => $item->tanggal_reservasi,
                        'kategori' => 'Fasilitas',
                        'nama_pemesan' => $item->nama_pemesan ?? 'Tamu',
                        'total' => $item->total_harga,
                        'status' => $item->status ?? null,
                        'created_at' => $item->created_at
                    ];
                })
            )
            ->merge(
                SewaTenant::latest()->limit(5)->get()->map(function ($item) {
                    return (object)[
                        'tanggal' => $item->tanggal_mulai,
                        'kategori' => 'Tenant',
                        'nama_pemesan' => $item->nama_penyewa ?? 'Tamu',
                        'total' => $item->harga_total,
                        'status' => $item->status ?? null,
                        'created_at' => $item->created_at
                    ];
                })
            )
            ->sortByDesc('created_at')
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
