@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('wahana.index') }}" class="text-decoration-none">
                            Kelola Konten
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Detail Data Wahana Satuan
                    </li>
                </ol>
            </nav>
            <h4 class="fw-semibold mb-0">Detail Data Wahana Satuan</h4>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('wahana.edit', $wahana->id) }}"
               class="btn btn-outline-secondary rounded-pill px-4">
                Edit
            </a>

            <form action="{{ route('wahana.destroy', $wahana->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger rounded-pill px-4"
                        onclick="return confirm('Yakin ingin menghapus wahana ini?')">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4">

        <div class="row mb-4">
            <div class="col-md-3">
                <p class="text-muted mb-1">ID Wahana</p>
                <h6 class="fw-semibold">{{ $wahana->id }}</h6>
            </div>

            <div class="col-md-3">
                <p class="text-muted mb-1">Nama Wahana</p>
                <h6 class="fw-semibold">{{ $wahana->nama_wahana }}</h6>
            </div>

            <div class="col-md-3">
                <p class="text-muted mb-1">Harga</p>
                <h6 class="fw-semibold">
                    Rp{{ number_format($wahana->harga_tiket_wahana, 0, ',', '.') }}
                </h6>
            </div>

            <div class="col-md-3">
                <p class="text-muted mb-1">Status</p>
                <span class="badge-pill
                    {{ $wahana->status_wahana == 'Aktif' ? 'badge-success' : 'badge-secondary' }}">
                    {{ $wahana->status_wahana }}
                </span>
            </div>
        </div>

        <hr>

        <div class="mb-4">
            <p class="text-muted mb-1">Deskripsi Singkat</p>
            <p class="mb-0">
                {{ $wahana->deskripsi_wahana }}
            </p>
        </div>

        <hr>

        <div class="mb-4">
            <p class="text-muted mb-1">Tentang Wahana</p>
            <p class="mb-0" style="line-height: 1.7;">
                {{ $wahana->tentang_wahana }}
            </p>
        </div>

        <hr>

        <div>
            <p class="text-muted mb-3">Foto Wahana</p>

            <div class="d-flex gap-3 flex-wrap">
                @if ($wahana->url_gambar_wahana)
                    <img src="{{ asset('storage/' . $wahana->url_gambar_wahana) }}"
                         class="rounded-4"
                         style="width: 160px; height: 160px; object-fit: cover;">
                @else
                    <p class="text-muted">Belum ada foto</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
