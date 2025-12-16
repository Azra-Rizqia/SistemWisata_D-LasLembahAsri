@extends('layouts.app')

@section('content')
<div class="container">
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Pesan Tiket Paket</h1>
            <p class="font-T3-Regular">Kelola data paket tiket yang tersedia</p>
        </div>
        <a href="{{ route('pesan_tiket_paket.create') }}" class="btn btn-primary mb-3">
            Tambah Tiket Paket
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="main-content">

        {{-- STATISTIK --}}
        <div class="statistics">
            <div class="card-statistic">
                <div class="icon-card-statistic1">
                    <i class="ph-fill ph-money-wavy icon icon-md icon-primary"></i>
                </div>
                <div class="content-text-card">
                    <p class="font-T5-Regular" style="color:#727272">Total Nilai Tiket</p>
                    <p class="font-T1-SemiBold">
                       Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="card-statistic">
                <div class="icon-card-statistic2">
                    <i class="ph-fill ph-ticket icon icon-md icon-warning"></i>
                </div>
                <div class="content-text-card">
                    <p class="font-T5-Regular" style="color:#727272">Jumlah Paket Tiket</p>
                    <p class="font-T1-SemiBold">{{ $totalData ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="view-data">
            <div class="content-text-card">
                <p class="font-T1-SemiBold">Daftar Tiket Paket</p>
                <p class="font-T5-Regular" style="color:#727272">
                    Data paket tiket yang tersedia
                </p>
            </div>

            <table class="table">
                <thead class="table-head">
                    <tr>
                        <th><p class="font-T5-Medium" style="color: #727272">Kode</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Nama Pemesan</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Nama Paket</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Jumlah Pesanan</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Total Pembayaran</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Status</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Tanggal Dibuat</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Action</p></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pesanan as $item)
                    <tr>
                        <td>{{ $item->kode_pesan_tiket }}</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>{{ $item->tiketPaket->nama_tiket_paket ?? '-' }}</td>
                        <td>{{ $item->jumlah_tiket }}</td>
                        <td>Rp{{ number_format($item->harga_pesanan * $item->jumlah_tiket, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge 
                                @if($item->status === 'Selesai') bg-success
                                @elseif($item->status === 'Proses') bg-warning
                                @else bg-danger
                                @endif
                            ">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pembelian)->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('pesan_tiket_paket.show',$item->id) }}" class="btn btn-sm">👁</a>
                            <a href="{{ route('pesan_tiket_paket.edit',$item->id) }}" class="btn btn-sm">✏</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada pesanan tiket</td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

    {{-- MODAL DELETE --}}
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus data tiket paket ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="button" class="btn btn-danger">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
