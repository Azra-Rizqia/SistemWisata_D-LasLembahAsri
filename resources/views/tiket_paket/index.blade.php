@extends('layouts.app')

@section('content')
<div class="container">
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Tiket Paket</h1>
            <p class="font-T3-Regular">Kelola data tiket paket yang tersedia</p>
        </div>
        <a href="{{ route('tiket_paket.create') }}" class="btn btn-primary mb-3">
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
                    <p class="font-T5-Regular" style="color:#727272">Pendapatan Tiket Paket</p>
                    <p class="font-T1-SemiBold">
                        Rp{{ number_format($hargaTermurah ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="card-statistic">
                <div class="icon-card-statistic2">
                    <i class="ph-fill ph-ticket icon icon-md icon-warning"></i>
                </div>
                <div class="content-text-card">
                    <p class="font-T5-Regular" style="color:#727272">Total Tiket Terjual</p>
                    <p class="font-T1-SemiBold">
                        {{ $totalData ?? 0 }}
                    </p>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="view-data">
            <div class="content-text-card">
                <p class="font-T1-SemiBold">Daftar Tiket Paket</p>
                <p class="font-T5-Regular" style="color:#727272">
                    Data tiket paket yang tersedia
                </p>
            </div>

            <table class="table">
                <thead class="table-head">
                    <tr>
                        <th><p class="font-T5-Medium" style="color:#727272">Kode</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Nama Paket</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Pengelola</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Harga Weekday</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Harga Weekend</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Status</p></th>
                        <th><p class="font-T5-Medium" style="color:#727272">Action</p></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tiketPaket as $item)
                    <tr>
                        <td>TP-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $item->nama_tiket_paket }}</td>
                        <td>{{ $item->pengelola_wahana }}</td>
                        <td>Rp{{ number_format($item->harga_tiket_weekday, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->harga_tiket_weekend, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $item->status_tiket === 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->status_tiket }}
                            </span>
                        </td>

                        {{-- ACTION --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                {{-- SHOW --}}
                                <a href="{{ route('tiket_paket.show', $item->id) }}"
                                class="btn btn-sm btn-light"
                                title="Detail">
                                    👁
                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('tiket_paket.edit', $item->id) }}"
                                class="btn btn-sm btn-light"
                                title="Edit">
                                    ✏
                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('tiket_paket.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus tiket paket ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-light text-danger"
                                            title="Hapus">
                                        🗑
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada tiket paket</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
