@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Header --}}
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Tiket Satuan</h1>
            <p class="font-T3-Regular">Kelola pembelian tiket satuan pengunjung</p>
        </div>
        <a href="{{ route('pesan-tiket.create') }}"
            class="btn btn-primary mb-3 d-flex align-items-center">
            <i class="ph ph-plus icon icon-sm"></i>
            Tambah Tiket
        </a>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="main-content">

        {{-- Statistik --}}
        <div class="statistics">
            <div class="card-statistic">
                <div class="icon-card-statistic1">
                    <i class="ph-fill ph-money-wavy icon icon-md icon-primary"></i>
                </div>
                <div class="content-text-card">
                    <p class="font-T5-Regular" style="color:#727272">
                        Total Pendapatan Tiket
                    </p>
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
                    <p class="font-T5-Regular" style="color:#727272">
                        Total Pembelian Tiket
                    </p>
                    <p class="font-T1-SemiBold">
                        {{ $totalPembelian }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="view-data table-responsive">
            <div class="content-text-card">
                <p class="font-T1-SemiBold">Pembelian Tiket Terakhir</p>
                <p class="font-T5-Regular" style="color:#727272">
                    Daftar transaksi pembelian tiket satuan terbaru
                </p>
            </div>

            <table class="table">
                <thead class="table-head">
                    <tr>
                        <th><p class="font-T5-Medium" style="color:#727272">ID</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Nama Pemesan</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Nama Tiket</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Tanggal Pembelian</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Jumlah</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Total Pembayaran</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Status</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Dibuat</p></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pesanan as $item)
                        <tr>
                            <td><p class="font-T5-Regular data-table">{{ $item->id }}</p></td>
                            <td><p class="font-T5-Regular data-table">{{ $item->nama_pemesan }}</p></td>
                            <td><p class="font-T5-Regular data-table">{{ $item->nama_tiket }}</p></td>
                            <td>
                                <p class="font-T5-Regular data-table">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pembelian)->locale('id')->translatedFormat('d F Y') }}
                                </p>
                            </td>
                            <td><p class="font-T5-Regular data-table">{{ $item->jumlah_tiket }}</p></td>
                            <td>
                                <p class="font-T5-Regular data-table">
                                    Rp{{ number_format($item->total_pembayaran, 0, ',', '.') }}
                                </p>
                            </td>
                            <td>
                                <span
                                    class="badge-pill font-T4-Regular
                                    {{ $item->status_pembayaran === 'selesai'
                                        ? 'badge-success'
                                        : 'badge-process' }}">
                                    {{ ucfirst($item->status_pembayaran) }}
                                </span>
                            </td>
                            <td>
                                <p class="font-T5-Regular data-table">
                                    {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F H:i') }}
                                </p>
                            </td>
                            <td>
                                <a href="{{ route('pesan-tiket.show', $item->id) }}" class="btn btn-sm">
                                    <i class="ph ph-eye icon icon-sm"></i>
                                </a>
                                <a href="{{ route('pesan-tiket.edit', $item->id) }}" class="btn btn-sm">
                                    <i class="ph ph-pencil-line icon icon-sm"></i>
                                </a>
                                <button class="btn btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#delete-{{ $item->id }}">
                                    <i class="ph ph-trash icon icon-sm icon-danger"></i>
                                </button>

                                <x-modal-delete
                                    id="delete-{{ $item->id }}"
                                    action="{{ route('pesan-tiket.destroy', $item->id) }}"
                                    title="Apakah Anda Yakin?"
                                    message="Data pembelian tiket akan dihapus permanen" />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                Data tiket satuan belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
