@extends('layouts.app')

@section('content')
<div class="container">
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Kelola Wahana</h1>
            <p class="font-T3-Regular">Kelola wahana yang ada di website</p>
        </div>
        <a href="{{ route('wahana.create') }}" class="btn btn-primary mb-3 d-flex align-items-center">
                <i class="ph ph-plus icon icon-sm"></i> Tambah Wahana </a>
    </div>

    <div class="row g-4">
        @foreach ($wahana as $item)
        <div class="col-md-6">
            
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="row g-0">
                    <div class="col-md-4">
                        <div class="position-relative p-3 h-100">

                            <span class="badge badge-pill
                                {{ $item->status_wahana === 'Aktif'
                                    ? 'badge-success'
                                    : 'badge-canceled' }}
                                position-absolute top-0 start-0 m-4"
                                style="z-index: 10;">
                                {{ $item->status_wahana }}
                            </span>

                            <img
                                src="{{ asset('storage/' . $item->url_gambar_wahana) }}"
                                class="img-fluid w-100 h-100 rounded-4"
                                style="object-fit: cover;">
                        </div>
                    </div>

                    <div class="col p-3">
                        <div class="card-body">
                            <h5 class="fw-semibold">{{ $item->nama_wahana }}</h5>
                            <p class="text-muted small">
                                {{ Str::limit($item->deskripsi_wahana, 80) }}
                            </p>

                            <p class="mb-1 text-muted">Harga</p>
                            <h6 class="fw-bold">Rp{{ number_format($item->harga_tiket_wahana) }}</h6>

                            <div class="d-flex gap-2 mt-3">
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('wahana.show', $item->id) }}"
                                       class="btn btn-secondary mb-3 d-flex align-items-center">
                                        <i class="ph ph-eye icon icon-sm"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ route('wahana.edit', $item->id) }}"
                                        class="btn btn-secondary mb-3 d-flex align-items-center"><i class="ph ph-pencil-line icon icon-sm"></i>
                                        Edit
                                    </a>
                                    <button class="btn btn-secondary-danger mb-3 d-flex align-items-center" data-bs-toggle="modal"
                                            data-bs-target="#delete-{{ $item->id }}">
                                            <i class="ph ph-trash icon icon-sm icon-danger"></i>Hapus
                                        </button>
                                        <x-modal-delete id="delete-{{ $item->id }}"
                                            action="{{ route('wahana.destroy', $item->id) }}"
                                            title="Apakah Anda Yakin Untuk Menghapus?"
                                            message="Jika anda menghapus pesanan ini, maka anda tidak dapat memulihkannya lagi" />
                                </div>
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
