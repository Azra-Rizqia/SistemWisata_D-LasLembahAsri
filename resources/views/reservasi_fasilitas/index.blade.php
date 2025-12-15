@extends('layouts.app')

@section('content')
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Reservasi Fasilitas</h1>
            <p class="font-T3-Regular">Kelola Reservasi Fasilitas dari pengunjung</p>
        </div>
        <a href="{{ route('reservasi_fasilitas.create') }}" class="btn btn-primary mb-3 align-items-center"><i
                class="ph ph-plus icon icon-sm"></i>
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
                        Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
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
                        {{ $totalData }}
                    </p>
                </div>
            </div>
        </div>

        <div class="view-data">
            <div class="content-text-card">
                <p class="font-T1-SemiBold">Reservasi Terakhir</p>
                <p class="font-T4-Regular" style="color:#727272">
                    Daftar transaksi reservasi fasilitas terbaru
                </p>
            </div>

            <table class="table font-T4-Regular">
                <thead class="table-head">
                    <tr>
                        <th>No Reservasi</th>
                        <th>Nama Pemesan</th>
                        <th>Nama Fasilitas</th>
                        <th>Tanggal Penggunaan</th>
                        <th>Kategori</th>
                        <th>Total Pembayaran</th>
                        <th>Status Reservasi</th>
                        <th>Tanggal Pemesanan</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reservasi as $item)
                        <tr>
                            <td>#{{ $item->kode_reservasi_fasilitas }}</td>
                            <td>{{ $item->user->nama_user ?? '-' }}</td>
                            <td>{{ $item->fasilitas->nama_fasilitas ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_reservasi)->locale('id')->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ $item->kategori_reservasi }}</td>
                            <td>
                                Rp{{ number_format($item->total_harga_reservasi, 0, ',', '.') }}
                            </td>
                            <td>
                                <span
                                    class="badge-pill font-T4-Regular
                                    {{ $item->status_reservasi === 'Selesai'
                                        ? 'badge-success'
                                        : ($item->status_reservasi === 'Proses'
                                            ? 'badge-secondary'
                                            : 'badge-canceled') }}">
                                    {{ $item->status_reservasi }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F H:i') ?? '-' }}
                            </td>
                            <td>
                                <a href="{{ route('reservasi_fasilitas.show', $item->id) }}" class="btn btn-sm"><i
                                        class="ph ph-eye icon icon-sm"></i>
                                </a>

                                <a href="{{ route('reservasi_fasilitas.edit', $item->id) }}" class="btn btn-sm"><i
                                        class="ph ph-pencil-line icon icon-sm"></i>
                                </a>
                                <form action="{{ route('reservasi_fasilitas.destroy', $item->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i
                                            class="ph ph-trash icon icon-sm icon-danger"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                Data reservasi fasilitas belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 24px; padding: 20px;">
                <div class="modal-header d-flex justify-content-center">
                    <div class="icon-card-delete items-center"><i class="ph ph-trash icon icon-md icon-danger"></i>
                    </div> 
                </div>
                <div class="modal-body d-flex flex-column text-center gap-3">
                    <h1 class="font-T1-SemiBold">Apakah Anda Yakin Untuk Menghapus?</h1>
                    <p class="font-T3-Regular">Jika anda menghapus pesanan ini, maka anda tidak dapat memulihkannya lagi
                    </p>
                </div>
                <div class="modal-footer font-T4-Regular">
                    <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">Kembali</button>
                    <button type="button" class="btn btn-danger flex-fill">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection
