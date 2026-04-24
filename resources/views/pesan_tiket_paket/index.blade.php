@extends('layouts.app')

@section('content')
<div class="container">
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Pesan Tiket Paket</h1>
            <p class="font-T3-Regular">Kelola data paket tiket yang tersedia</p>
        </div>
        <a href="{{ route('pesan_tiket_paket.create') }}" class="btn btn-primary mb-3 d-flex align-items-center">
            <i class="ph ph-plus icon icon-sm"></i>
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
                        <th><p class="font-T5-Medium" style="color: #727272">Jumlah</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Total</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Status</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Tanggal</p></th>
                        <th><p class="font-T5-Medium" style="color: #727272">Action</p></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pesanan as $item)
                    <tr>
                        <td>{{ $item->kode_pesan_tiket }}</td>
                        {{-- Bagian 3: Nama Pemesan menggunakan nama_user dari tabel users --}}
                        <td>{{ $item->user->nama_user ?? 'User Terhapus' }}</td>
                        <td>{{ $item->tiketPaket->nama_tiket_paket ?? '-' }}</td>
                        <td>{{ $item->jumlah_tiket }}</td>
                        <td>Rp{{ number_format($item->harga_pesanan * $item->jumlah_tiket, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge-pill {{ $item->status === 'Selesai' ? 'badge-success' : ($item->status === 'Proses' ? 'badge-warning' : 'badge-canceled') }}" style="{{ $item->status === 'Proses' ? 'color: #856404; background-color: #fff3cd;' : '' }}">
                            {{ $item->status }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pembelian)->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('pesan_tiket_paket.show', $item->id) }}" class="btn btn-sm">
                                    <i class="ph ph-eye icon icon-sm"></i>
                                </a>
                                <a href="{{ route('pesan_tiket_paket.edit', $item->id) }}" class="btn btn-sm">
                                    <i class="ph ph-pencil-line icon icon-sm"></i>
                                </a>
                                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#delete-{{ $item->id }}">
                                    <i class="ph ph-trash icon icon-sm icon-danger"></i>
                                </button>
                                <x-modal-delete id="delete-{{ $item->id }}"
                                    action="{{ route('pesan_tiket_paket.destroy', $item->id) }}"
                                    title="Apakah Anda Yakin Untuk Menghapus?"
                                    message="Jika anda menghapus pesanan ini, maka anda tidak dapat memulihkannya lagi" />
                            </div>
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
</div>
@endsection