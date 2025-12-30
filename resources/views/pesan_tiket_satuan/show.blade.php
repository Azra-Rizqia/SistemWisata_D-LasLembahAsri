@extends('layouts.app')

@section('content')
<div class="container">

    <div class="head-page-breadcrumb">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('pesan-tiket.index') }}">Tiket Satuan</a>
                </li>
                <li class="breadcrumb-item active">Detail Tiket Satuan</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('pesan-tiket.edit', $pesanTiketSatuan->id) }}"
               class="btn btn-secondary mb-3 d-flex align-items-center">
                <i class="ph ph-pencil-line icon icon-sm"></i>
                Edit
            </a>

            <button class="btn btn-danger mb-3 d-flex align-items-center"
                data-bs-toggle="modal"
                data-bs-target="#delete-detail">
                <i class="ph ph-trash icon icon-sm"></i>
                Hapus
            </button>
        </div>
    </div>

    <div class="content-detail-page">

        {{-- Main Info --}}
        <div class="section-main-information-detail-page">

            <div class="item-main-information">
                <div class="info-item-information">
                    <p class="font-h7">{{ $pesanTiketSatuan->nama_tiket }}</p>
                    <p class="font-T3-Regular">
                        Rp{{ number_format($pesanTiketSatuan->harga_satuan, 0, ',', '.') }}
                    </p>
                </div>

                <p class="font-T4-Regular">Status Pembayaran</p>
                <span class="badge-pill font-T4-Regular
                    {{ $pesanTiketSatuan->status_pembayaran === 'selesai'
                        ? 'badge-success'
                        : 'badge-process' }}">
                    {{ ucfirst($pesanTiketSatuan->status_pembayaran) }}
                </span>
            </div>

            <div class="item-main-information">
                <div class="info-item-information">
                    <p class="font-h7">{{ $pesanTiketSatuan->nama_pemesan }}</p>
                </div>
            </div>

        </div>

        {{-- Detail --}}
        <div class="d-flex justify-items-stretch gap-5 section-information-detail-page">
            <div class="kolom-input">

                <div class="info-item-information">
                    <p class="font-T4-Regular">Tanggal Pembelian</p>
                    <p class="font-T1-SemiBold">
                        {{ \Carbon\Carbon::parse($pesanTiketSatuan->tanggal_pembelian)
                            ->locale('id')
                            ->translatedFormat('d F Y') }}
                    </p>
                </div>

                <div class="info-item-information">
                    <p class="font-T4-Regular">Jumlah Tiket</p>
                    <p class="font-T1-SemiBold">
                        {{ $pesanTiketSatuan->jumlah_tiket }}
                    </p>
                </div>

                <div class="info-item-information">
                    <p class="font-T4-Regular">Total Pembayaran</p>
                    <p class="font-T1-SemiBold">
                        Rp{{ number_format($pesanTiketSatuan->total_pembayaran, 0, ',', '.') }}
                    </p>
                </div>

                <div class="info-item-information">
                    <p class="font-T4-Regular">Tanggal Input</p>
                    <p class="font-T1-SemiBold">
                        {{ $pesanTiketSatuan->created_at
                            ->locale('id')
                            ->translatedFormat('d F Y H:i') }}
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Modal Delete --}}
<x-modal-delete
    id="delete-detail"
    action="{{ route('pesan-tiket.destroy', $pesanTiketSatuan->id) }}"
    title="Hapus Tiket Satuan?"
    message="Data tiket satuan ini akan dihapus permanen dan tidak dapat dikembalikan."
/>
@endsection
