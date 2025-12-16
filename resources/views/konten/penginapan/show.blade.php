@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="mb-3">
            <a href="{{ route('konten.penginapan.index') }}" class="font-T4-Regular text-decoration-none" style="color: #787878;">Konten Website</a>
            <i style="color: #787878;">/</i>
            <i class="font-T4-SemiBold text-dark">Detail Penginapan</i>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('konten.penginapan.edit', $item->id) }}" class="btn btn-primary font-T4-SemiBold px-4 py-2 rounded-pill text-white d-flex align-items-center">
                <i class="ph ph-pencil-simple me-2"></i> Edit Data
            </a>
            <button class="btn btn-outline-danger font-T4-SemiBold px-4 py-2 rounded-pill d-flex align-items-center"
                data-bs-toggle="modal"
                data-bs-target="#delete-detail">
                <i class="ph ph-trash me-2"></i> Hapus
            </button>
        </div>
    </div>

    <div class="bg-white p-4 rounded-4 shadow-sm d-flex flex-column gap-4">
        <div class="row g-4">
            <div class="col-md-3">
                <label class="form-label font-T4-Regular text-secondary">Nama Penginapan</label>
                <div class="font-T4-SemiBold text-dark p-2 bg-light rounded-3">
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label font-T4-Regular text-secondary">Harga /malam (Weekday)</label>
                <div class="font-T4-SemiBold text-dark p-2 bg-light rounded-3">
                    Rp {{ number_format($item->harga_weekday, 0, ',', '.') }}
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label font-T4-Regular text-secondary">Harga /malam (Weekend)</label>
                <div class="font-T4-SemiBold text-dark p-2 bg-light rounded-3">
                    Rp {{ number_format($item->harga_weekend, 0, ',', '.') }}
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label font-T4-Regular text-secondary">Status</label>
                <div class="font-T4-SemiBold text-dark p-2 bg-light rounded-3">
                    @if($item->status_tersedia)
                    Aktif
                    @else
                    Tidak Aktif
                    @endif
                </div>
            </div>
        </div>

        
        <div>
            <label class="form-label font-T4-Regular text-secondary">Deskripsi Singkat</label>
            <div class="font-T4-Regular text-dark p-3 bg-light rounded-3 text-break">
                {{ $item->deskripsi_singkat ?? '-' }}
            </div>
        </div>

        <div>
            <label class="form-label font-T4-Regular text-secondary">Tentang Penginapan</label>
            <div class="font-T4-Regular text-dark p-3 bg-light rounded-3 text-break" style="white-space: pre-line; min-height: 100px;">
                {{ $item->deskripsi_penginapan ?? '-' }}
            </div>
        </div>

        <hr class="border-light opacity-50">

        <div>
            <label class="form-label font-T4-Regular text-secondary mb-3">Fasilitas Tersedia</label>
            <div class="d-flex flex-wrap gap-3">
                @if($item->fasilitas_tersedia && is_array($item->fasilitas_tersedia) && count($item->fasilitas_tersedia) > 0)
                @foreach($item->fasilitas_tersedia as $fasilitas)
                <div class="d-flex align-items-center bg-white border rounded-pill px-3 py-2 gap-3 shadow-sm" style="min-width: 180px; border-color: #E8E8E8 !important;">
                    {{-- Icon Wrapper --}}
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 position-relative overflow-hidden" style="width: 36px; height: 36px;">
                        @if(isset($fasilitas['icon']) && $fasilitas['icon'])
                        <img src="{{ asset('storage/' . $fasilitas['icon']) }}" class="w-100 h-100 object-fit-cover" alt="icon">
                        @else
                        <i class="ph ph-star text-secondary"></i>
                        @endif
                    </div>

                    {{-- Nama Fasilitas --}}
                    <span class="font-T4-Medium text-dark">{{ $fasilitas['nama'] ?? 'Fasilitas' }}</span>
                </div>
                @endforeach
                @else
                <div class="text-secondary font-T5-Regular fst-italic py-2">
                    Tidak ada fasilitas yang ditambahkan.
                </div>
                @endif
            </div>
        </div>

        <hr class="border-light opacity-50">

        <div>
            <label class="form-label font-T4-Regular text-secondary mb-3">Foto Utama</label>
            <div class="rounded-4 overflow-hidden border bg-light d-flex align-items-center justify-content-center" style="width: 200px; height: 200px;">
                @if($item->url_gambar_penginapan)
                <img src="{{ asset('storage/' . $item->url_gambar_penginapan) }}" class="w-100 h-100 object-fit-cover" alt="{{ $item->nama_penginapan }}">
                @else
                <div class="text-center text-secondary">
                    <i class="ph ph-image fs-1 mb-2"></i>
                    <div class="font-T5-Regular">Tidak ada gambar</div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

<x-modal-delete id="delete-detail" action="{{ route('konten.penginapan.destroy', $item->id) }}"
    title="Hapus Data Penginapan?"
    message="Data penginapan ini akan dihapus permanen dan tidak dapat dikembalikan." />
@endsection