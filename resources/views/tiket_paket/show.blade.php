@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="head-page d-flex justify-content-between align-items-center mb-4">
        <div class="headline">
            <h1 class="font-h1">Detail Tiket Paket</h1>
            <p class="font-T3-Regular">Informasi lengkap tiket paket</p>
        </div>
        <a href="{{ route('tiket_paket.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="main-content">
        <div class="card p-4 shadow-sm">

            <div class="row mb-3 border-bottom pb-2">
                <div class="col-md-4 text-muted">Nama Paket</div>
                <div class="col-md-8 fw-semibold">
                    {{ $tiket_paket->nama_tiket_paket }}
                </div>
            </div>

            <div class="row mb-3 border-bottom pb-2">
                <div class="col-md-4 text-muted">Pengelola Wahana</div>
                <div class="col-md-8">
                    {{ $tiket_paket->pengelola_wahana }}
                </div>
            </div>

            <div class="row mb-3 border-bottom pb-2">
                <div class="col-md-4 text-muted">Deskripsi Tiket</div>
                <div class="col-md-8">
                    {{ $tiket_paket->deskripsi_tiket }}
                </div>
            </div>
            
            <div class="row mb-3 border-bottom pb-2">
                <div class="col-md-4 text-muted">Yang Didapatkan</div>
                <div class="col-md-8">
                    <pre class="m-0 p-0" style="white-space: pre-wrap; font-family: inherit;">{{ $tiket_paket->yang_didapatkan ?? '-' }}</pre>
                </div>
            </div>

            <div class="row mb-3 border-bottom pb-2">
                <div class="col-md-4 text-muted">Harga Weekday</div>
                <div class="col-md-8">
                    Rp{{ number_format($tiket_paket->harga_tiket_weekday, 0, ',', '.') }}
                </div>
            </div>

            <div class="row mb-3 border-bottom pb-2">
                <div class="col-md-4 text-muted">Harga Weekend</div>
                <div class="col-md-8">
                    Rp{{ number_format($tiket_paket->harga_tiket_weekend, 0, ',', '.') }}
                </div>
            </div>

            <div class="row mb-3 border-bottom pb-2">
                <div class="col-md-4 text-muted">Status Tiket</div>
                <div class="col-md-8">
                    <span class="badge 
                        {{ $tiket_paket->status_tiket === 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                        {{ $tiket_paket->status_tiket }}
                    </span>
                </div>
            </div>

            <div class="row mb-3 border-bottom pb-2">
                <div class="col-md-4 text-muted">QR Tiket</div>
                <div class="col-md-8">
                    {{ $tiket_paket->qr_tiket }}
                </div>
            </div>

            <div class="row mb-4 border-bottom pb-2">
                <div class="col-md-4 text-muted">Dibuat Pada</div>
                <div class="col-md-8">
                    {{ $tiket_paket->created_at->format('d M Y H:i') }}
                </div>
            </div>
            
            <h5 class="mt-4 mb-3 text-muted">Kumpulan Foto</h5>
            <div class="row">
                @php
                    $foto_array = is_string($tiket_paket->kumpulan_foto) ? json_decode($tiket_paket->kumpulan_foto, true) : ($tiket_paket->kumpulan_foto ?? []);
                @endphp

                @forelse($foto_array as $foto)
                    <div class="col-6 col-sm-4 col-md-3 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/tiket_paket_photos/' . $foto) }}" 
                                 class="card-img-top" 
                                 alt="Foto Tiket Paket" 
                                 style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2">
                                <small class="text-muted">{{ $foto }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted fst-italic">Tidak ada foto terlampir.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection