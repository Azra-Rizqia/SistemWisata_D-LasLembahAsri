@extends('layouts.app')

@section('content')
<div class="container">
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Pesan Tiket Satuan</h1>
            <p class="font-T3-Regular">Kelola data tiket satuan yang tersedia</p>
        </div>
        <a href="{{ route('pesan_tiket_satuan.create') }}" class="btn btn-primary mb-3">
            Tambah Tiket Satuan
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
                    <p class="font-T5-Regular" style="color:#727272">Jumlah Tiket Satuan</p>
                    <p class="font-T1-SemiBold">{{ $totalData ?? 0 }}</p>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="view-data">
            <div class="content-text-card">
                <p class="font-T1-SemiBold">Daftar Tiket Satuan</p>
                <p class="font-T5-Regular" style="color:#727272">
                    Data tiket satuan yang tersedia
                </p>
            </div>

            <table class="table">
                <thead class="table-head">
                    <tr>
                        <th><p class="font-T5-Medium" style="color: #727272">No Tiket Paket</p></th>
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
                        {{-- Nomor Reservasi --}}
                        <td>TKP-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>

                        {{-- Nama Pemesan --}}
                        <td>{{ $item->user->name ?? '-' }}</td>

                        {{-- Nama Paket --}}
                        <td>{{ $item->tiketPaket->nama_tiket_paket ?? '-' }}</td>

                        {{-- Jumlah Pesanan --}}
                        <td>{{ $item->jumlah_tiket }}</td>

                        {{-- Total Pembayaran --}}
                        <td>
                            Rp{{ number_format($item->harga_pesanan * $item->jumlah_tiket, 0, ',', '.') }}
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="badge {{ $item->status === 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->status }}
                            </span>
                        </td>

                        {{-- Tanggal Pembelian --}}
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pembelian)->format('d M Y') }}</td>

                        {{-- Action --}}
                        <td>
                            <a href="{{ route('pesan_tiket_satuan.show',$item->id) }}" class="btn btn-sm">
                                👁
                            </a>
                            <a href="{{ route('pesan_tiket_satuan.edit',$item->id) }}" class="btn btn-sm">
                                ✏
                            </a>
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
                    Yakin ingin menghapus data tiket satuan ini?
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