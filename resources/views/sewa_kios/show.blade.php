@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $harga = $sewa_kio->harga_sewa_tenant;
        $pajak = $harga * 0.10;
        $total = $harga + $pajak;
    @endphp
    <div class="head-page-breadcrumb">
        <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('sewa_kios.index') }}">Sewa Kios</a>
                    </li>
                <li class="breadcrumb-item active">Detail Sewa</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('sewa_kios.edit', $sewa_kio->id) }}" class="btn btn-secondary">
                    Edit
                </a>
                <form action="{{ route('sewa_kios.destroy', $sewa_kio->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-hapus" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Hapus
                    </button>
                </form>
            </div>
    </div>
    <div class="content-detail-page">
        <div class="section-main-information-detail-page">
            <div class="item-main-information">
                <div class="info-item-information">
                    <p class="font-h7">{{$sewa_kio->tenant->lokasi_tenant}}</p>
                    <p class="font-T3-Regular">Rp10.000</p>
                </div>
                <p class="font-T4-Regular">Status Pembelian</p>
                <span class="badge
                    {{ $sewa_kio->status_pembayaran_tenant === 'Dibayar' ? 'bg-success' :
                    ($sewa_kio->status_pembayaran_tenant === 'Menunggu' ? 'bg-warning' : 'bg-danger') }}">
                    {{ $sewa_kio->status_pembayaran_tenant }}
                </span>
            </div>
            <div class="item-main-information">
                <div class="info-item-information">
                    <p class="font-h7">{{$sewa_kio->user->nama_user}}</p>
                    <p class="font-T3-Regular">{{$sewa_kio->user->email_user}}</p>
                </div>
            </div>
        </div>
        <div class="section-information-detail-page">
            <div class="kolom-input">
                <div class="info-item-information">
                    <p class="font-T4-Regular">No Sewa</p>
                    <p class="font-T1-SemiBold">#{{ $sewa_kio->id }}</p>
                </div>
                <div class="info-item-information">
                    <p class="font-T4-Regular">Tanggal Dimulai</p>
                    <p class="font-T1-SemiBold">{{ \Carbon\Carbon::parse($sewa_kio->tanggal_mulai_sewa)->format('d M Y') }}</p>
                </div>
                <div class="info-item-information">
                    <p class="font-T4-Regular">Tanggal Berakhir</p>
                    <p class="font-T1-SemiBold">{{ \Carbon\Carbon::parse($sewa_kio->tanggal_selesai_sewa)->format('d M Y') }}</p>
                </div>
            </div>
            <div class="kolom-input">
                <div class="info-item-information">
                    <p class="font-T4-Regular">Total Pembayaran</p>
                    <p class="font-T1-SemiBold">Rp{{ number_format($sewa_kio->harga_sewa_tenant, 0, ',', '.') }}</p>
                </div>
                <div class="info-item-information">
                    <p class="font-T4-Regular">Metode Pembayaran</p>
                    <p class="font-T1-SemiBold">{{ $sewa_kio->{'Metode Pembayaran'} ?? '-' }}</p>
                </div>
                <div class="info-item-information">
                    <p class="font-T4-Regular">Tanggal Pemesanan</p>
                    <p class="font-T1-SemiBold">{{ $sewa_kio->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
