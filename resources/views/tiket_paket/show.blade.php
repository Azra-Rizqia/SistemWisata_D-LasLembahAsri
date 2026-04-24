@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Breadcrumb & Navigasi --}}
    <div class="breadcrumb mb-3">
        <a href="{{ route('tiket_paket.index') }}" class="text-decoration-none text-primary">Master Tiket</a> 
        <span class="mx-2 text-muted">/</span> 
        <span class="text-muted">Detail Tiket Paket</span>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-4">
        <a href="{{ route('tiket_paket.edit', $tiket_paket->id) }}" class="btn btn-outline-dark px-4 shadow-sm">
            <i class="fas fa-edit me-1"></i> Edit Paket
        </a>
        <a href="{{ route('tiket_paket.index') }}" class="btn btn-secondary px-4 shadow-sm">
            Kembali
        </a>
    </div>

    {{-- Baris Informasi Utama --}}
    <div class="row g-4 mb-4">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h2 class="fw-bold mb-1">{{ $tiket_paket->nama_tiket_paket }}</h2>
                        <h4 class="text-success fw-bold">Rp{{ number_format($tiket_paket->harga_tiket_weekday, 0, ',', '.') }} <small class="text-muted fw-normal" style="font-size: 14px;">(Weekday)</small></h4>
                    </div>
                    <div class="text-end">
                        <span class="text-muted d-block mb-1">Status Tiket</span>
                        <span class="badge px-3 py-2 
                            {{ $tiket_paket->status_tiket === 'Tersedia' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}" 
                            style="border-radius: 8px;">
                            {{ $tiket_paket->status_tiket }}
                        </span>
                    </div>
                </div>
                <hr>
                <p class="text-muted mb-1">Deskripsi:</p>
                <p class="mb-0">{{ $tiket_paket->deskripsi_tiket }}</p>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 15px;">
                <h6 class="text-muted text-uppercase small fw-bold">Pengelola Wahana</h6>
                <h3 class="fw-bold mb-3 text-dark">{{ $tiket_paket->pengelola_wahana }}</h3>
                
                <div class="bg-light p-3" style="border-radius: 10px;">
                    <p class="text-muted small mb-1">ID/QR Referensi:</p>
                    <code class="text-primary fw-bold">{{ $tiket_paket->qr_tiket ?? '-' }}</code>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris Detail Fasilitas & Harga --}}
    <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 15px;">
        <div class="row">
            <div class="col-md-6 border-end">
                <h5 class="fw-bold mb-3"><i class="fas fa-star text-warning me-2"></i>Yang Didapatkan</h5>
                <div class="p-3 bg-light" style="border-radius: 12px; min-height: 100px;">
                    <pre class="m-0 p-0" style="white-space: pre-wrap; font-family: inherit; font-size: 14px;">{{ $tiket_paket->yang_didapatkan ?? 'Tidak ada informasi tambahan.' }}</pre>
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="fw-bold mb-3"><i class="fas fa-tags text-primary me-2"></i>Rincian Harga</h5>
                <div class="row text-center mt-4">
                    <div class="col-6 border-end">
                        <p class="text-muted mb-1">Harga Weekday</p>
                        <h5 class="fw-bold text-dark">Rp{{ number_format($tiket_paket->harga_tiket_weekday, 0, ',', '.') }}</h5>
                    </div>
                    <div class="col-6">
                        <p class="text-muted mb-1">Harga Weekend</p>
                        <h5 class="fw-bold text-primary">Rp{{ number_format($tiket_paket->harga_tiket_weekend, 0, ',', '.') }}</h5>
                    </div>
                </div>
                <div class="text-center mt-4 pt-3 border-top">
                    <small class="text-muted small">Data master dibuat pada: {{ $tiket_paket->created_at->format('d F Y H:i') }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Kumpulan Foto --}}
    <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
        <h5 class="fw-bold mb-4"><i class="fas fa-images me-2"></i>Kumpulan Foto Wahana</h5>
        <div class="row">
            @php
                $foto_array = is_string($tiket_paket->kumpulan_foto) ? json_decode($tiket_paket->kumpulan_foto, true) : ($tiket_paket->kumpulan_foto ?? []);
            @endphp

            @forelse($foto_array as $foto)
                <div class="col-6 col-sm-4 col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 12px;">
                        <img src="{{ asset('storage/tiket_paket_photos/' . $foto) }}" 
                             class="card-img-top" 
                             alt="Foto Tiket Paket" 
                             style="height: 180px; object-fit: cover;">
                        <div class="card-body p-2 text-center bg-light">
                            <small class="text-muted" style="font-size: 11px;">{{ $foto }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" style="width: 80px; opacity: 0.5;" alt="no-data">
                    <p class="text-muted fst-italic mt-2">Tidak ada foto terlampir untuk paket ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection