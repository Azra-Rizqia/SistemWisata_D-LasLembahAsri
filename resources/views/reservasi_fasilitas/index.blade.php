@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="head-page">
            <div class="headline">
                <h1 class="font-h1">Reservasi Fasilitas</h1>
                <p class="font-T3-Regular">Kelola reservasi fasilitas dari pengunjung</p>
            </div>
            <a href="{{ route('reservasi_fasilitas.create') }}" class="btn btn-primary mb-3">
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
                    <div class="icon-card-statistic1"><x-phosphor-calendar-check-fill class="icon icon-primary icon-md" />
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
                    <div class="icon-card-statistic2"><x-phosphor-calendar-check-fill /></i></div>
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
                    <p class="font-T5-Regular" style="color:#727272">
                        Daftar transaksi reservasi fasilitas terbaru
                    </p>
                </div>

                <table class="table">
                    <thead class="table-head">
                        <tr>
                            <th>No Reservasi</th>
                            <th>Nama Pemesan</th>
                            <th>Fasilitas</th>
                            <th>Kategori</th>
                            <th>Tanggal Reservasi</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th>Metode Pembayaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($reservasi as $item)
                            <tr>
                                <td>#{{ $item->kode_reservasi_fasilitas }}</td>
                                <td>{{ $item->user->name ?? '-' }}</td>
                                <td>{{ $item->fasilitas->nama_fasilitas ?? '-' }}</td>
                                <td>{{ $item->kategori_reservasi }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_reservasi)->format('d M Y') }}</td>
                                <td>
                                    Rp{{ number_format($item->total_harga_reservasi, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span
                                        class="badge
                                    {{ $item->status_reservasi === 'Dibayar'
                                        ? 'bg-success'
                                        : ($item->status_reservasi === 'Menunggu'
                                            ? 'bg-warning'
                                            : 'bg-danger') }}">
                                        {{ $item->status_reservasi }}
                                    </span>
                                </td>
                                <td>{{ $item->metode_pembayaran_reservasi }}</td>
                                <td>
                                    <a href="{{ route('reservasi_fasilitas.show', $item->id) }}"
                                        class="btn btn-info btn-sm">Detail</a>

                                    <a href="{{ route('reservasi_fasilitas.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('reservasi_fasilitas.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus reservasi?')">
                                            Delete
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
    </div>
@endsection
