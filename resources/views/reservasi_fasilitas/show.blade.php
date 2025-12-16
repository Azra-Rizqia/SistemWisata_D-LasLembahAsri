@extends('layouts.app')

@section('content')
    <div class="container">
        @php
            $harga = $reservasi_fasilita->harga_fasilitas;
            $pajak = $harga * 0.1;
            $total = $harga + $pajak;
        @endphp
        <div class="head-page-breadcrumb">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('reservasi_fasilitas.index') }}">Reservasi Fasilitas</a>
                    </li>
                    <li class="breadcrumb-item active">Detail Reservasi Fasilitas</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('reservasi_fasilitas.edit', $reservasi_fasilita->id) }}"
                    class="btn btn-secondary mb-3 d-flex align-items-center"><i class="ph ph-pencil-line icon icon-sm"></i>
                    Edit
                </a>
                <button class="btn btn-danger mb-3 d-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#delete-detail">
                    <i class="ph ph-trash icon icon-sm"></i>
                    Hapus
                </button>
            </div>
        </div>
        <div class="content-detail-page">
            <div class="section-main-information-detail-page">
                <div class="item-main-information">
                    <div class="info-item-information">
                        <p class="font-h7">{{ $reservasi_fasilita->fasilitas->nama_fasilitas }}</p>
                        <p class="font-T3-Regular">
                            Rp{{ number_format($reservasi_fasilita->fasilitas->harga_fasilitas, 0, ',', '.') }}</p>
                    </div>
                    <p class="font-T4-Regular">Status Pembelian</p>
                    <span
                        class="badge-pill font-T4-Regular
                    {{ $reservasi_fasilita->status_reservasi === 'Selesai'
                        ? 'badge-success'
                        : ($reservasi_fasilita->status_reservasi === 'Proses'
                            ? 'badge-process'
                            : 'badge-canceled') }}">
                        {{ $reservasi_fasilita->status_reservasi }}
                    </span>
                </div>
                <div class="item-main-information">
                    <div class="info-item-information">
                        <p class="font-h7">{{ $reservasi_fasilita->user->nama_user }}</p>
                        <p class="font-T3-Regular">{{ $reservasi_fasilita->user->email_user }}</p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-items-stretch gap-5 section-information-detail-page">
                <div class="kolom-input">
                    <div class="info-item-information">
                        <p class="font-T4-Regular">No Reservasi</p>
                        <p class="font-T1-SemiBold">#{{ $reservasi_fasilita->kode_reservasi_fasilitas }}</p>
                    </div>
                    <div class="info-item-information">
                        <p class="font-T4-Regular">Tanggal Penggunaan</p>
                        <p class="font-T1-SemiBold">
                            {{ \Carbon\Carbon::parse($reservasi_fasilita->tanggal_reservasi)->locale('id')->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div class="info-item-information">
                        <p class="font-T4-Regular">Metode Pembayaran</p>
                        <p class="font-T1-SemiBold">{{ $reservasi_fasilita->metode_pembayaran_reservasi }}</p>
                    </div>
                    <div class="info-item-information">
                        <p class="font-T4-Regular">Total Pembayaran</p>
                        <p class="font-T1-SemiBold">
                            Rp{{ number_format($reservasi_fasilita->total_harga_reservasi, 0, ',', '.') }}</p>
                    </div>
                    <div class="info-item-information">
                        <p class="font-T4-Regular">Tanggal Pemesanan</p>
                        <p class="font-T1-SemiBold">
                            {{ \Carbon\Carbon::parse($reservasi_fasilita->created_at)->locale('id')->translatedFormat('d F H:i') ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal-delete id="delete-detail" action="{{ route('reservasi_fasilitas.destroy', $reservasi_fasilita->id) }}"
        title="Hapus Reservasi Fasilitas?"
        message="Data reservasi ini akan dihapus permanen dan tidak dapat dikembalikan." />
@endsection
