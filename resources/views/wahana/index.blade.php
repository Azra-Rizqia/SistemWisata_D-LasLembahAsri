@extends('layouts.app')

@section('content')
<div class="container">
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Kelola Konten</h1>
            <p class="font-T3-Regular">Kelola konten yang ada di website</p>
        </div>
        <a href="{{ route('sewa_kios.create') }}" class="btn btn-primary mb-3"> Tambah Wahana </a>
    </div>

    {{-- Card Grid --}}
    <div class="row g-4">
        @foreach ($wahana as $item)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="row g-0">

                    {{-- Image --}}
                    <div class="col-md-5 position-relative">
                        <span class="badge bg-light text-success position-absolute m-2">
                            {{ $item->status_wahana }}
                        </span>
                        <img src="{{ asset('storage/' . $item->url_gambar_wahana) }}"
                             class="img-fluid h-100 rounded-start"
                             style="object-fit: cover;">
                    </div>

                    {{-- Content --}}
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class="fw-semibold">{{ $item->nama_wahana }}</h5>
                            <p class="text-muted small">
                                {{ Str::limit($item->deskripsi_wahana, 80) }}
                            </p>

                            <p class="mb-1 text-muted">Harga</p>
                            <h6 class="fw-bold">Rp{{ number_format($item->harga_tiket_wahana) }}</h6>

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('wahana.edit', $item->id) }}"
                                   class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                    ✏️ Edit
                                </a>

                                <form action="{{ route('wahana.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                            onclick="return confirm('Hapus wahana ini?')">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
