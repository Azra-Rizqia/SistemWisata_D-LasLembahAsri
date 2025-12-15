@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="head-page">
            <div class="headline">
                <h1 class="font-h1">Persewaan Kios</h1>
                <p class="font-T3-Regular">Kelola Reservasi penginapan dari pengunjung</p>
            </div>
            <a href="{{ route('sewa_kios.create') }}" class="btn btn-primary mb-3"> Tambah Sewa </a>
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
                    <div class="icon-card-statistic1"><i class="ph-fill ph-money-wavy icon icon-md icon-primary"></i></div>
                    <div class="content-text-card">
                        <p class="font-T5-Regular" style="color: #727272">Pendapatan Penyewaan Kios</p>
                        <p class="font-T1-SemiBold">Rp{{ number_format($totalPendapatan,0,',','.') }}</p>
                    </div>
                </div>
                <div class="card-statistic">
                    <div class="icon-card-statistic2"><i class="ph-fill ph-calendar-check icon icon-md icon-warning"></i></div>
                    <div class="content-text-card">
                        <p class="font-T5-Regular" style="color: #727272">Jumlah Penyewa</p>
                        <p class="font-T1-SemiBold">{{ $totalData }}</p>
                    </div>
                </div>
            </div>
            <div class="view-data">
                <div class="content-text-card">
                    <p class="font-T1-SemiBold">Transaksi Sewa Terakhir</p>
                    <p class="font-T5-Regular" style="color: #727272">Berbagai transaksi terakhir yang terjadi</p>
                </div>
                <table class="table">
                    <thead class="table-head">
                        <tr>
                            <th><p class="font-T5-Medium" style="color: #727272">No Sewa</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Nama Pemesan</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Nomor Kios</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Tanggal Dimulai</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Tanggal Berakhir</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Total Pembayaran</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Status Pembayaran</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Tanggal Pembayaran</p></th>
                            <th><p class="font-T5-Medium" style="color: #727272">Action</p></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sewa_kio as $item)
                            <tr>
                                <td><p class="font-T5-Regular data-table">#{{ $item->id }}</p></td>
                                <td><p class="font-T5-Regular data-table">{{ $item->user->nama_user ?? '-' }}</p></td>
                                <td><p class="font-T5-Regular data-table">{{ $item->tenant->lokasi_tenant ?? '-' }}</p></td>
                                <td><p class="font-T5-Regular data-table">{{ \Carbon\Carbon::parse($item->tanggal_mulai_sewa)->format('d M Y') }}</p></td>
                                <td><p class="font-T5-Regular data-table">{{ \Carbon\Carbon::parse($item->tanggal_selesai_sewa)->format('d M Y') }}</p></td>
                                <td><p class="font-T5-Regular data-table">Rp{{ number_format($item->harga_sewa_tenant, 0, ',', '.') }}</p></td>
                                <td>
                                    <span class="badge
                                        {{ $item->status_pembayaran_tenant === 'Dibayar' ? 'bg-success' :
                                        ($item->status_pembayaran_tenant === 'Menunggu' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $item->status_pembayaran_tenant }}
                                    </span>
                                </td>
                                <td><p class="font-T5-Regular">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</p></td>

                                <td>
                                    <a href="{{ route('sewa_kios.show', $item->id) }}" class="btn btn-sm"><i
                                            class="ph ph-eye icon icon-sm"></i>
                                    </a>

                                    <a href="{{ route('sewa_kios.edit', $item->id) }}" class="btn btn-sm"><i
                                            class="ph ph-pencil-line icon icon-sm"></i>
                                    </a>
                                    <form action="{{ route('sewa_kios.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop"><i
                                                class="ph ph-trash icon icon-sm icon-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    Data sewa tenant belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
