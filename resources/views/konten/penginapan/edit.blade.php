@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('konten.penginapan.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="d-flex justify-content-between align-items-center mb-4">
            {{-- Breadcrumb --}}
            <div class="mb-3">
                <a href="{{ route('konten.penginapan.index') }}" class="font-T4-Regular text-decoration-none" style="color: #787878;">Konten Website</a> <i style="color: #787878;">/</i> <i class="font-T4-SemiBold">Edit Data Penginapan</i>
            </div>

            <button type="submit" class="btn btn-primary font-T4-SemiBold d-flex align-items-center px-4 py-2">
                Simpan Perubahan
            </button>
        </div>

        <div class="bg-white p-4 rounded-4 shadow-sm d-flex flex-column gap-4">

            <div class="row g-4">
                <div class="col-md-3 form-group-input">
                    <label class="form-label font-T4-Regular">Nama Penginapan</label>
                    <input type="text" name="nama_penginapan" class="form-input-style font-T4-Regular" placeholder="Masukan nama" value="{{ old('nama_penginapan', $item->nama_penginapan) }}">
                    @error('nama_penginapan') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3 form-group-input">
                    <label class="form-label font-T4-Regular">Harga /malam (Weekday)</label>
                    <input type="number" name="harga_weekday" class="form-input-style font-T4-Regular" placeholder="Rp 0" value="{{ old('harga_weekday', $item->harga_weekday) }}">
                    @error('harga_weekday') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3 form-group-input">
                    <label class="form-label font-T4-Regular">Harga /malam (Weekend)</label>
                    <input type="number" name="harga_weekend" class="form-input-style font-T4-Regular" placeholder="Rp 0" value="{{ old('harga_weekend', $item->harga_weekend) }}">
                    @error('harga_weekend') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-2 form-group-input">
                    <label class="form-label font-T4-Regular">Status</label>
                    <div class="position-relative">
                        <select name="status_tersedia" class="form-input-style font-T4-Regular">
                            <option value="1" {{ old('status_tersedia', $item->status_tersedia) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('status_tersedia', $item->status_tersedia) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group-input">
                <label class="form-label font-T4-Regular">Deskripsi Singkat</label>
                <input type="text" name="deskripsi_singkat" class="form-input-style font-T4-Regular" placeholder="Tambahkan deskripsi singkat" value="{{ old('deskripsi_singkat', $item->deskripsi_singkat) }}">
            </div>

            <div class="form-group-input">
                <label class="form-label font-T4-Regular">Tentang Penginapan</label>
                <textarea name="deskripsi_penginapan" rows="4" class="form-input-style font-T4-Regular" placeholder="Tambahkan tentang penginapan">{{ old('deskripsi_penginapan', $item->deskripsi_penginapan) }}</textarea>
                @error('deskripsi_penginapan') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
            </div>

            <hr class="border-light opacity-50">

            <div>
                <label class="form-label font-T4-Regular mb-3">Fasilitas Tersedia</label>

                <div class="d-flex flex-wrap gap-3 align-items-start">
                    <div id="fasilitas-container" class="d-flex flex-wrap gap-3">
                        {{-- Loop Existing Facilities (Menggunakan fasilitas_tersedia dan akses Array) --}}
                        @if($item->fasilitas_tersedia && is_array($item->fasilitas_tersedia) && count($item->fasilitas_tersedia) > 0)
                        @foreach($item->fasilitas_tersedia as $index => $fasilitas)
                        <div id="fasilitas-row-{{ $index }}" class="d-flex align-items-center bg-white border rounded-pill px-2 py-1 gap-2 shadow-sm" style="height: 50px; min-width: 200px; border: 1px solid #E8E8E8;">
                            <label class="cursor-pointer bg-light rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 position-relative overflow-hidden" style="width: 36px; height: 36px; background: #E8E8E8;">
                                {{-- Cek if icon exists in array --}}
                                @php $icon = $fasilitas['icon'] ?? null; @endphp
                                <x-phosphor-upload-simple id="icon-preview-{{ $index }}" class="icon-upload-fasilitas {{ $icon ? 'd-none' : '' }}" />
                                <img id="img-preview-{{ $index }}" src="{{ $icon ? asset('storage/' . $icon) : '#' }}" class="{{ $icon ? '' : 'd-none' }} w-100 h-100 object-fit-cover position-absolute">

                                <input type="file" name="fasilitas[{{ $index }}][icon]" class="d-none" accept="image/*" onchange="previewIcon(this, '{{ $index }}')">
                            </label>

                            <input type="text" name="fasilitas[{{ $index }}][nama]" class="form-control border-0 bg-transparent p-0 font-T4-Regular text-dark shadow-none" placeholder="Nama fasilitas" style="width: 120px;" value="{{ $fasilitas['nama'] ?? '' }}" required>

                            <button type="button" onclick="removeRow('{{ $index }}')" class="btn p-0 text-danger border-0">
                                <x-phosphor-trash-light class="icon-trash" />
                            </button>
                        </div>
                        @endforeach
                        @else
                        <div class="d-flex align-items-center bg-white border rounded-pill px-2 py-1 gap-2 shadow-sm" style="height: 50px; min-width: 200px; border: 1px solid #E8E8E8;" id="fasilitas-row-0">
                            <label class="cursor-pointer bg-light rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 position-relative overflow-hidden" style="width: 36px; height: 36px; background: #E8E8E8;">
                                <x-phosphor-upload-simple class="icon-upload-fasilitas" id="icon-preview-0" />
                                <img id="img-preview-0" src="#" class="d-none w-100 h-100 object-fit-cover position-absolute">
                                <input type="file" name="fasilitas[0][icon]" class="d-none" accept="image/*" onchange="previewIcon(this, 0)">
                            </label>

                            <input type="text" name="fasilitas[0][nama]" class="form-control border-0 bg-transparent p-0 font-T4-Regular text-dark shadow-none" placeholder="Nama fasilitas" style="width: 120px;" required>

                            <button type="button" class="btn p-0 text-danger disabled border-0">
                                <x-phosphor-trash-light class="icon-trash" />
                            </button>
                        </div>
                        @endif
                    </div>

                    <button type="button" id="btnAddFasilitas" class="btn btn-outline-light text-dark d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 20px; border: 1px solid #E8E8E8;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <hr class="border-light opacity-50">

            <div>
                <label class="form-label font-T4-Regular mb-3">Foto Utama</label>
                <div class="d-flex gap-3 flex-wrap">
                    <label for="uploadFoto" class="cursor-pointer d-flex flex-column align-items-center justify-content-center border rounded-4 bg-white" style="width: 150px; height: 150px; border-style: dashed !important; border-color: #d1d5db !important; transition: all 0.2s;">
                        <div class="text-center">
                            <x-phosphor-upload-simple class="icon-upload-image" />
                            <span class="d-block font-T5-Regular text-secondary">Unggah gambar</span>
                        </div>
                        <input type="file" name="url_gambar_penginapan" id="uploadFoto" class="d-none" accept="image/*" onchange="previewMainImage(event)">
                    </label>

                    {{-- Preview Box: show if exists --}}
                    <div id="mainPreviewBox" class="{{ $item->url_gambar_penginapan ? '' : 'd-none' }} position-relative rounded-4 overflow-hidden shadow-sm" style="width: 150px; height: 150px;">
                        <img id="mainImgPreview" src="{{ $item->url_gambar_penginapan ? asset('storage/' . $item->url_gambar_penginapan) : '#' }}" class="w-100 h-100 object-fit-cover">
                        <button type="button" onclick="removeMainImage()" class="btn btn-white bg-white text-danger position-absolute top-0 end-0 m-2 p-1 rounded-circle shadow-sm d-flex justify-content-center align-items-center" style="width: 24px; height: 24px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
                @error('url_gambar_penginapan') <small class="text-danger mt-1 d-block font-T5-Regular">{{ $message }}</small> @enderror
            </div>

        </div>
    </form>
</div>

@php
$initialCount = 1;
if($item->fasilitas_tersedia && is_array($item->fasilitas_tersedia) && count($item->fasilitas_tersedia) > 0) {
$initialCount = count($item->fasilitas_tersedia);
}
@endphp

<script>
    let fasilitasCount = '{{ $initialCount }}';

    if (fasilitasCount === 0) fasilitasCount = 1;

    const container = document.getElementById('fasilitas-container');
    const btnAdd = document.getElementById('btnAddFasilitas');

    if (btnAdd) {
        btnAdd.addEventListener('click', function() {
            const index = fasilitasCount;
            const newRow = document.createElement('div');
            newRow.className = 'd-flex align-items-center bg-white border rounded-pill px-2 py-1 gap-2 shadow-sm';
            newRow.style.height = '50px';
            newRow.style.minWidth = '200px';
            newRow.style.border = '1px solid #E8E8E8';
            newRow.id = `fasilitas-row-${index}`;

            newRow.innerHTML = `
                <label class="cursor-pointer bg-light rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 position-relative overflow-hidden" style="width: 36px; height: 36px; background: #E8E8E8;">
                    <x-phosphor-upload-simple id="icon-preview-${index}" class="icon-upload-fasilitas"/>
                    <img id="img-preview-${index}" src="#" class="d-none w-100 h-100 object-fit-cover position-absolute">
                    <input type="file" name="fasilitas[${index}][icon]" class="d-none" accept="image/*" onchange="previewIcon(this, ${index})">
                </label>
                
                <input type="text" name="fasilitas[${index}][nama]" class="form-control border-0 bg-transparent p-0 font-T4-Regular text-dark shadow-none" placeholder="Nama fasilitas" style="width: 120px;" required>
                
                <button type="button" onclick="removeRow(${index})" class="btn p-0 text-danger border-0">
                    <x-phosphor-trash-light class="icon-trash"/>
                </button>
            `;
            container.appendChild(newRow);
            fasilitasCount++;
        });
    }

    function removeRow(index) {
        const row = document.getElementById(`fasilitas-row-${index}`);
        if (row) row.remove();
    }

    window.previewIcon = function(input, index) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            const iconPreview = document.getElementById(`icon-preview-${index}`);
            const imgPreview = document.getElementById(`img-preview-${index}`);

            reader.onload = function(e) {
                if (imgPreview) {
                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('d-none');
                }
                if (iconPreview) iconPreview.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    window.previewMainImage = function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('mainImgPreview');
                const box = document.getElementById('mainPreviewBox');
                if (img) img.src = e.target.result;
                if (box) box.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    }

    window.removeMainImage = function() {
        const input = document.getElementById('uploadFoto');
        const box = document.getElementById('mainPreviewBox');
        const img = document.getElementById('mainImgPreview');

        if (input) input.value = "";
        if (box) box.classList.add('d-none');
        if (img) img.src = "#";
    }
</script>

<style>
    .cursor-pointer {
        cursor: pointer;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection