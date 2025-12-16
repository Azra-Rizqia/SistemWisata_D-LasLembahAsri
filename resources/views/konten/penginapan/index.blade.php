@extends('layouts.app')

@section('content')
<div class="container-2">

    <div class="d-flex flex-column gap-1 mb-4">
        <h1 class="font-h1 m-0 text-dark">Kelola Konten</h1>
        <span class="font-T3-Regular">Kelola konten yang ada pada website</span>
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 border-bottom border-light pb-2 gap-3">
        <!-- Tab Menu -->
        <div class="d-flex gap-4 overflow-auto text-nowrap">
            <a href="{{ route('konten.penginapan.index') }}" class="text-decoration-none pb-2 border-bottom border-2 border-success active-tab">
                <span class="font-T4-SemiBold text-success">Penginapan</span>
            </a>
            <a href="{{ route('fasilitas.index') }}" class="text-decoration-none pb-2 text-secondary hover-text-primary">
                <span class="font-T4-Regular">Fasilitas</span>
            </a>
            <a href="#" class="text-decoration-none pb-2 text-secondary hover-text-primary">
                <span class="font-T4-Regular">Tiket Satuan</span>
            </a>
            <a href="#" class="text-decoration-none pb-2 text-secondary hover-text-primary">
                <span class="font-T4-Regular">Tiket Paket</span>
            </a>
            <a href="#" class="text-decoration-none pb-2 text-secondary hover-text-primary">
                <span class="font-T4-Regular">Sewa Kios</span>
            </a>
        </div>

        <a href="{{ route('konten.penginapan.create') }}" class="btn btn-primary rounded-pill px-4 py-2 font-T5-Medium d-flex align-items-center gap-2 shadow-sm text-white">
            <i class="ph ph-plus fs-5"></i>
            <span>Tambah Data</span>
        </a>
    </div>

    <div class="d-flex flex-column gap-2">
        <div class="row g-4">
            @forelse($penginapan as $item)
            <div class="col-12 col-md-6 col-xl-4 ">
                <a href="{{ route('konten.penginapan.show', $item->id) }}" class="text-decoration-none">
                    <div class="card-custom h-100">
                        <div class="card-inner d-flex flex-column h-100">

                            <div class="card-image position-relative">
                                @if($item->url_gambar_penginapan)
                                <img
                                    src="{{ asset('storage/' . $item->url_gambar_penginapan) }}"
                                    alt="{{ $item->nama_penginapan }}">
                                @else
                                <div class="image-placeholder">
                                    <i class="ph ph-image"></i>
                                </div>
                                @endif

                                @if($item->status_tersedia)
                                <span class="badge-status">Aktif</span>
                                @else
                                <span class="badge-status text-danger">Tidak Aktif</span>
                                @endif
                            </div>

                            <div class="card-content d-flex flex-column flex-grow-1">

                                <div class="mb-2">
                                    <h5 class="font-T4-SemiBold text-dark mb-1 text-truncate" title="{{ $item->nama_penginapan }}">
                                        {{ $item->nama_penginapan }}
                                    </h5>
                                    <p class="font-T5-Regular text-secondary mb-0 text-truncate-2">
                                        {{ $item->deskripsi_singkat ?? $item->deskripsi_penginapan }}
                                    </p>
                                </div>

                                <div class="price-box mt-auto mb-3">
                                    <div class="price-item">
                                        <div class="font-T4-Regular">
                                            <span>Hari Biasa</span>
                                        </div>
                                        <div class="font-T2-SemiBold">
                                            <strong>Rp{{ number_format($item->harga_weekday, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>

                                    <div class="price-divider"></div>

                                    <div class="price-item">
                                        <div class="font-T4-Regular">
                                            <span>Hari Libur</span>
                                        </div>
                                        <div class="font-T2-SemiBold">
                                            <strong>Rp{{ number_format($item->harga_weekend, 0, ',', '.') }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('konten.penginapan.edit', $item->id) }}"
                                        class="btn btn-light flex-fill rounded-pill py-2 font-T4-SemiBold btn-action">
                                        <x-phosphor-pencil class="icon-pencil" />Edit
                                    </a>

                                    <button
                                        onclick="openDeleteModal('{{ $item->id }}', '{{ $item->nama_penginapan }}')"
                                        class="btn btn-danger-outline flex-fill rounded-pill py-2 font-T4-SemiBold btn-action">
                                        <x-phosphor-trash-light class="icon-trash icon-trash:hover" /> Hapus
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 py-5">
                <div class="d-flex flex-column align-items-center justify-content-center text-center gap-3">
                    <div class="bg-light rounded-circle p-4">
                        <i class="ph ph-magnifying-glass fs-1 text-secondary"></i>
                    </div>
                    <div>
                        <h5 class="font-T4-SemiBold text-dark mb-1">Belum ada data penginapan</h5>
                        <p class="font-T5-Regular text-secondary mb-0">Silakan tambahkan data penginapan baru untuk ditampilkan di sini.</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        @if($penginapan->hasPages())
        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
            {{ $penginapan->links() }}
        </div>
        @endif

    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-3 shadow-lg">
            <div class="modal-body text-center p-4">
                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3 text-danger">
                    <i class="ph ph-trash fs-2"></i>
                </div>
                <h5 class="font-h1 fs-5 mb-2 fw-bold">Hapus Data?</h5>
                <p class="text-secondary mb-4">Apakah Anda yakin ingin menghapus <span id="deleteItemName" class="fw-bold text-dark"></span>? Data yang dihapus tidak dapat dikembalikan.</p>

                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-light rounded-pill px-4 py-2" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-4 py-2">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(id, name) {
        let url = "{{ route('konten.penginapan.destroy', ':id') }}";
        url = url.replace(':id', id);

        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteItemName').innerText = name;

        var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        myModal.show();
    }
</script>
@endsection