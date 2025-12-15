@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('sewa_kios.index') }}">Sewa Kios</a>
            </li>
            <li class="breadcrumb-item active">Detail Sewa</li>
        </ol>
    </nav>

    {{-- Content --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Pesanan Sewa Tenant</h5>
        </div>

        <div class="card-body">
            <h6 class="mb-3">Informasi Sewa</h6>
            <table class="table table-bordered">
                <tr>
                    <th width="30%">No Sewa</th>
                    <td>#{{ $sewa_kio->id }}</td>
                </tr>
                <tr>
                    <th>Nama Pemesan</th>
                    <td>{{ $sewa_kio->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email Pemesan</th>
                    <td>{{ $sewa_kio->user->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tenant</th>
                    <td>{{ $sewa_kio->tenant->lokasi_tenant ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ \Carbon\Carbon::parse($sewa_kio->tanggal_mulai_sewa)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Selesai</th>
                    <td>{{ \Carbon\Carbon::parse($sewa_kio->tanggal_selesai_sewa)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Status Pembayaran</th>
                    <td>
                        <span class="badge
                            {{ $sewa_kio->status_pembayaran_tenant === 'Dibayar' ? 'bg-success' :
                            ($sewa_kio->status_pembayaran_tenant === 'Menunggu' ? 'bg-warning' : 'bg-danger') }}">
                            {{ $sewa_kio->status_pembayaran_tenant }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Metode Pembayaran</th>
                    <td>{{ $sewa_kio->{'Metode Pembayaran'} ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Dibuat</th>
                    <td>{{ $sewa_kio->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>

            <hr>

            {{-- PERHITUNGAN --}}
            @php
                $harga = $sewa_kio->harga_sewa_tenant;
                $pajak = $harga * 0.10;
                $total = $harga + $pajak;
            @endphp

            <h6 class="mb-3">Rincian Pembayaran</h6>
            <table class="table table-striped">
                <tr>
                    <th>Harga Sewa</th>
                    <td>Rp{{ number_format($harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Pajak (10%)</th>
                    <td>Rp{{ number_format($pajak, 0, ',', '.') }}</td>
                </tr>
                <tr class="table-success">
                    <th>Total Pembayaran</th>
                    <td class="fw-bold">
                        Rp{{ number_format($total, 0, ',', '.') }}
                    </td>
                </tr>
            </table>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('sewa_kios.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <a href="{{ route('sewa_kios.edit', $sewa_kio->id) }}"
                   class="btn btn-warning">
                    Edit
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
