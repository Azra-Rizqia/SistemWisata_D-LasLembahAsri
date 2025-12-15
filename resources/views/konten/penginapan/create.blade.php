@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('konten.penginapan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex flex-column gap-1">
                <div class="d-flex gap-2 align-items-center font-T4-Regular">
                    <span>Konten Website</span>
                    <span>/</span>
                    <span class="text-dark fw-bold">Tambah Data Penginapan</span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary font-T4-SemiBold d-flex align-items-center px-4 py-2">
                Tambahkan Penginapan
            </button>
        </div>

        <div class="bg-white p-4 rounded-4 shadow-sm d-flex flex-column gap-4">
            
            <div class="row g-4">
                <div class="col-md-4" style="gap: 10px;">
                    <label class="form-label font-T4-Regular">Nama Penginapan</label>
                    <input type="text" name="nama_penginapan" class="form-input-style font-T4-Regular" placeholder="Masukan nama" value="{{ old('nama_penginapan') }}">
                    @error('nama_penginapan') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3" style="gap: 10px;">
                    <label class="form-label font-T4-Regular">Harga /malam (Weekday)</label>
                    <input type="number" name="harga_weekday" class="form-input-style font-T4-Regular" placeholder="Rp 0" value="{{ old('harga_weekday') }}">
                    @error('harga_weekday') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3" style="gap: 10px;">
                    <label class="form-label font-T4-Regular">Harga /malam (Weekend)</label>
                    <input type="number" name="harga_weekend" class="form-input-style font-T4-Regular" placeholder="Rp 0" value="{{ old('harga_weekend') }}">
                    @error('harga_weekend') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-2" style="gap: 10px;">
                    <label class="form-label font-T4-Regular">Status</label>
                    <div class="position-relative">
                        <select name="status_tersedia" class="form-input-style font-T4-Regular">
                            <option value="1">Tersedia</option>
                            <option value="0">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
            </div>

            <div style="gap: 10px;">
                <label class="form-label font-T4-Regular">Deskripsi Singkat</label>
                <input type="text" name="deskripsi_singkat" class="form-input-style font-T4-Regular" placeholder="Tambahkan deskripsi singkat" value="{{ old('deskripsi_singkat') }}">
            </div>

            <div style="gap: 10px;">
                <label class="form-label font-T4-Regular">Tentang Penginapan</label>
                <textarea name="deskripsi_penginapan" rows="4" class="form-input-style font-T4-Regular" placeholder="Tambahkan tentang penginapan">{{ old('deskripsi_penginapan') }}</textarea>
                @error('deskripsi_penginapan') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
            </div>

            <hr class="border-light opacity-50">

            <div>
                <label class="form-label font-T4-Regular mb-3">Fasilitas Tersedia</label>

                <div class="d-flex flex-wrap gap-3 align-items-start">
                    <div id="fasilitas-container" class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center bg-white border rounded-pill px-2 py-1 gap-2 shadow-sm" style="height: 50px; min-width: 200px; border: 1px solid #E8E8E8;">
                            <label class="cursor-pointer bg-light rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 position-relative overflow-hidden" style="width: 36px; height: 36px; background: #E8E8E8;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <img id="img-preview-0" src="#" class="d-none w-100 h-100 object-fit-cover position-absolute">
                                <input type="file" name="fasilitas[0][icon]" class="d-none" accept="image/*" onchange="previewIcon(this, 0)">
                            </label>

                            <input type="text" name="fasilitas[0][nama]" class="form-control border-0 bg-transparent p-0 font-T4-Regular text-dark shadow-none" placeholder="Nama fasilitas" style="width: 120px;" required>

                            <button type="button" class="btn p-0 text-danger disabled border-0">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </div>

                    <button type="button" id="btnAddFasilitas" class="btn btn-outline-light text-dark d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 20px; border: 1px solid #E8E8E8;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                </div>
            </div>

            <hr class="border-light opacity-50">

            <div>
                <label class="form-label font-T4-Regular mb-3">Foto Utama</label>
                <div class="d-flex gap-3 flex-wrap">
                    <label for="uploadFoto" class="cursor-pointer d-flex flex-column align-items-center justify-content-center border rounded-4 bg-white" style="width: 150px; height: 150px; border-style: dashed !important; border-color: #d1d5db !important; transition: all 0.2s;">
                        <div class="text-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2" class="mb-2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <span class="d-block font-T5-Regular text-secondary">Unggah gambar</span>
                        </div>
                        <input type="file" name="url_gambar_penginapan" id="uploadFoto" class="d-none" accept="image/*" onchange="previewMainImage(event)">
                    </label>

                    <div id="mainPreviewBox" class="d-none position-relative rounded-4 overflow-hidden shadow-sm" style="width: 150px; height: 150px;">
                        <img id="mainImgPreview" src="#" class="w-100 h-100 object-fit-cover">
                        <button type="button" onclick="removeMainImage()" class="btn btn-white bg-white text-danger position-absolute top-0 end-0 m-2 p-1 rounded-circle shadow-sm d-flex justify-content-center align-items-center" style="width: 24px; height: 24px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                </div>
                @error('url_gambar_penginapan') <small class="text-danger mt-1 d-block font-T5-Regular">{{ $message }}</small> @enderror
            </div>

        </div>
    </form>
</div>

<script>
    let fasilitasCount = 1;
    const container = document.getElementById('fasilitas-container');
    const btnAdd = document.getElementById('btnAddFasilitas');

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
                <svg id="icon-preview-${index}" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <img id="img-preview-${index}" src="#" class="d-none w-100 h-100 object-fit-cover position-absolute">
                <input type="file" name="fasilitas[${index}][icon]" class="d-none" accept="image/*" onchange="previewIcon(this, ${index})">
            </label>
            
            <input type="text" name="fasilitas[${index}][nama]" class="form-control border-0 bg-transparent p-0 font-T4-Regular text-dark shadow-none" placeholder="Nama fasilitas" style="width: 120px;" required>
            
            <button type="button" onclick="removeRow(${index})" class="btn p-0 text-danger border-0">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
        `;
        container.appendChild(newRow);
        fasilitasCount++;
    });

    function removeRow(index) {
        document.getElementById(`fasilitas-row-${index}`).remove();
    }

    window.previewIcon = function(input, index) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(`img-preview-${index}`).src = e.target.result;
                document.getElementById(`img-preview-${index}`).classList.remove('d-none');
                document.getElementById(`icon-preview-${index}`).classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    window.previewMainImage = function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('mainImgPreview').src = e.target.result;
                document.getElementById('mainPreviewBox').classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    }

    window.removeMainImage = function() {
        document.getElementById('uploadFoto').value = "";
        document.getElementById('mainPreviewBox').classList.add('d-none');
        document.getElementById('mainImgPreview').src = "#";
    }
</script>

<style>
    .cursor-pointer { cursor: pointer; }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; margin: 0; 
    }
</style>
@endsection