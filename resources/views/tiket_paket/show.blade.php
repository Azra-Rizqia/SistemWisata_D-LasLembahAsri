@extends('layouts.app')

@section('content')
<div class="container">
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Detail Tiket Paket</h1>
            <p class="font-T3-Regular">Informasi lengkap tiket paket</p>
        </div>
        <a href="{{ route('tiket_paket.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="main-content">
        <div class="card p-4">

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Nama Paket</div>
                <div class="col-md-8 fw-semibold">
                    {{ $tiket_paket->nama_tiket_paket }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Pengelola Wahana</div>
                <div class="col-md-8">
                    {{ $tiket_paket->pengelola_wahana }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Deskripsi Tiket</div>
                <div class="col-md-8">
                    {{ $tiket_paket->deskripsi_tiket }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Harga Weekday</div>
                <div class="col-md-8">
                    Rp{{ number_format($tiket_paket->harga_tiket_weekday, 0, ',', '.') }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Harga Weekend</div>
                <div class="col-md-8">
                    Rp{{ number_format($tiket_paket->harga_tiket_weekend, 0, ',', '.') }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">Status Tiket</div>
                <div class="col-md-8">
                    <span class="badge 
                        {{ $tiket_paket->status_tiket === 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                        {{ $tiket_paket->status_tiket }}
                    </span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 text-muted">QR Tiket</div>
                <div class="col-md-8">
                    {{ $tiket_paket->qr_tiket }}
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 text-muted">Dibuat Pada</div>
                <div class="col-md-8">
                    {{ $tiket_paket->created_at->format('d M Y H:i') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
