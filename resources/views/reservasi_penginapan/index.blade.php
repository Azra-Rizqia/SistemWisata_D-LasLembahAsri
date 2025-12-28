@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="head-page">
            <div class="headline">
                <h1 class="font-h1">Reservasi Penginapan</h1>
                <p class="font-T3-Regular">Kelola Reservasi Penginapan dari pengunjung</p>
            </div>
            <a href="{{ route('reservasi_penginapan.create') }}" class="btn btn-primary mb-3 d-flex align-items-center">
                <i class="ph ph-plus icon icon-sm"></i>
                Tambah Reservasi
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="main-content">
            <div class="statistics">
                <div class="card-statistic">
                    <div class="icon-card-statistic1"><i class="ph-fill ph-money-wavy icon icon-md icon-primary"></i>
                    </div>
                    <div class="content-text-card">
                        <p class="font-T5-Regular" style="color:#727272">
                            Total Pendapatan Reservasi
                        </p>
                        <p class="font-T1-SemiBold">
                            Rp{{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="card-statistic">
                    <div class="icon-card-statistic2"><i class="ph-fill ph-calendar-check icon icon-md icon-warning"></i>
                    </div>
                    <div class="content-text-card">
                        <p class="font-T5-Regular" style="color:#727272">
                            Total Reservasi
                        </p>
                        <p class="font-T1-SemiBold">
                            {{ $totalData ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="view-data table-responsive">
                <div class="content-text-card">
                    <p class="font-T1-SemiBold">Reservasi Terakhir</p>
                    <p class="font-T5-Regular" style="color:#727272">
                        Daftar transaksi reservasi penginapan terbaru
                    </p>
                </div>

                <table class="table">
                    <thead class="table-head">
                        <tr>
                            <th><p class="font-T5-Medium" style="color: #727272">No. Reservasi</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Nama Pemesan</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Penginapan</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Jadwal Check-In</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Jadwal Check-Out</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Total Pembayaran</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Status</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Tanggal Pemesanan</p></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($reservasi as $item)
                            <tr>
                                <td><p class="font-T5-Regular data-table">{{ $item->nomor_reservasi }}</p></td>
                                <td><p class="font-T5-Regular data-table">{{ $item->user->nama_user ?? $item->user->name ?? '-' }}</p></td>
                                <td><p class="font-T5-Regular data-table">{{ $item->penginapan->nama_penginapan ?? '-' }}</p></td>
                                <td>
                                    <p class="font-T5-Regular data-table">
                                        {{ \Carbon\Carbon::parse($item->tanggal_masuk)->locale('id')->translatedFormat('d M Y') }}
                                    </p>
                                </td>
                                <td>
                                    <p class="font-T5-Regular data-table">
                                        {{ \Carbon\Carbon::parse($item->tanggal_keluar)->locale('id')->translatedFormat('d M Y') }}
                                    </p>
                                </td>
                                <td><p class="font-T5-Regular data-table">Rp{{ number_format($item->total_pembayaran, 0, ',', '.') }}</p></td>
                                
                                <td>
                                    <span class="badge-pill font-T4-Regular
                                        {{ $item->status_reservasi === 'Selesai' 
                                            ? 'badge-success' 
                                            : ($item->status_reservasi === 'Proses' 
                                                ? 'badge-process' 
                                                : 'badge-canceled') }}">
                                        {{ $item->status_reservasi }}
                                    </span>
                                </td>
                                
                                <td><p class="font-T5-Regular data-table">{{ \Carbon\Carbon::parse($item->tanggal_pemesanan)->locale('id')->translatedFormat('d F H:i') ?? '-' }}</p></td>
                                
                                <td>
                                    <div class="d-flex gap-2">
                                        {{-- Tombol Detail/Show (Jika ada routenya) --}}
                                        <a href="{{ route('reservasi_penginapan.show', $item->id) }}" class="btn btn-sm">
                                            <i class="ph ph-eye icon icon-sm"></i>
                                        </a>

                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('reservasi_penginapan.edit', $item->id) }}" class="btn btn-sm">
                                            <i class="ph ph-pencil-line icon icon-sm"></i>
                                        </a>
                                        
                                        {{-- Tombol Hapus (Modal) --}}
                                        <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#delete-{{ $item->id }}">
                                            <i class="ph ph-trash icon icon-sm icon-danger"></i>
                                        </button>
                                        
                                        {{-- Modal Component --}}
                                        <x-modal-delete id="delete-{{ $item->id }}"
                                            action="{{ route('reservasi_penginapan.destroy', $item->id) }}"
                                            title="Apakah Anda Yakin Untuk Menghapus?"
                                            message="Jika anda menghapus pesanan ini, maka anda tidak dapat memulihkannya lagi" />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center p-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <p class="font-T5-Regular text-muted">Data reservasi penginapan belum tersedia</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Links --}}
            <div class="mt-4">
                {{ $reservasi->links() }}
            </div>
        </div>
    </div>
@endsection