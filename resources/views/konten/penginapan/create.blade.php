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

            <button type="submit" class="btn btn-primary font-T5-Medium d-flex align-items-center px-4 py-2">
                Tambahkan Penginapan
            </button>
        </div>

        <div class="bg-white p-4 rounded-4 shadow-sm d-flex flex-column gap-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <label class="form-label font-T5-Medium">Nama Penginapan</label>
                    <input type="text" name="nama_penginapan" class="form-control rounded-3 py-2 px-3 bg-light border-0 font-T4-Regular" placeholder="Masukan nama" value="{{ old('nama_penginapan') }}">
                    @error('nama_penginapan') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label font-T5-Medium">Harga /malam (Weekday)</label>
                    <input type="number" name="harga_weekday" class="form-control rounded-3 py-2 px-3 bg-light border-0 font-T4-Regular" placeholder="Rp 0" value="{{ old('harga_weekday') }}">
                    @error('harga_weekday') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label font-T5-Medium">Harga /malam (Weekend)</label>
                    <input type="number" name="harga_weekend" class="form-control rounded-3 py-2 px-3 bg-light border-0 font-T4-Regular" placeholder="Rp 0" value="{{ old('harga_weekend') }}">
                    @error('harga_weekend') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-2">
                    <label class="form-label font-T5-Medium">Status</label>
                    <div class="position-relative">
                        <select name="status_tersedia" class="form-select rounded-3 py-2 px-3 bg-light border-0 font-T4-Regular" style="cursor: pointer;">
                            <option value="1">Tersedia</option>
                            <option value="0">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label class="form-label font-T5-Medium">Deskripsi Singkat</label>
                <input type="text" name="deskripsi_singkat" class="form-control rounded-3 py-2 px-3 bg-light border-0 font-T4-Regular" placeholder="Tambahkan deskripsi singkat" value="{{ old('deskripsi_singkat') }}">
            </div>

            <div>
                <label class="form-label font-T5-Medium">Tentang Penginapan</label>
                <textarea name="deskripsi_penginapan" rows="4" class="form-control rounded-3 py-2 px-3 bg-light border-0 font-T4-Regular" placeholder="Tambahkan tentang penginapan">{{ old('deskripsi_penginapan') }}</textarea>
                @error('deskripsi_penginapan') <small class="text-danger font-T5-Regular">{{ $message }}</small> @enderror
            </div>

            <hr class="border-light opacity-50">
            <div>
                <label class="form-label font-T5-Medium mb-3">Fasilitas Tersedia</label>

                <div class="d-flex flex-wrap gap-3 align-items-start">
                    <div id="fasilitas-container" class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center bg-white border-1 rounded-pill px-2 py-1 gap-2 shadow-sm" style="height: 50px; min-width: 200px; border-radius: 20px; border-style: solid;">
                            <label class="cursor-pointer bg-light rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 position-relative overflow-hidden" style="width: 36px; height: 36px; background: #E8E8E8;">
                                <x-phosphor-upload-simple />
                                <img id="img-preview-0" src="#" class="d-none w-100 h-100 object-fit-cover position-absolute">
                                <input type="file" name="fasilitas[0][icon]" class="d-none" accept="image/*" onchange="previewIcon(this, 0)">
                            </label>

                            <input type="text" name="fasilitas[0][nama]" class="form-control border-0 bg-transparent p-0 font-T4-Regular text-dark shadow-none" placeholder="Nama fasilitas" style="width: 120px;" required>

                            <button type="button" class="btn p-0 text-danger disabled border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M20.25 4.5H16.5V3.75C16.5 3.15326 16.2629 2.58097 15.841 2.15901C15.419 1.73705 14.8467 1.5 14.25 1.5H9.75C9.15326 1.5 8.58097 1.73705 8.15901 2.15901C7.73705 2.58097 7.5 3.15326 7.5 3.75V4.5H3.75C3.55109 4.5 3.36032 4.57902 3.21967 4.71967C3.07902 4.86032 3 5.05109 3 5.25C3 5.44891 3.07902 5.63968 3.21967 5.78033C3.36032 5.92098 3.55109 6 3.75 6H4.5V19.5C4.5 19.8978 4.65804 20.2794 4.93934 20.5607C5.22064 20.842 5.60218 21 6 21H18C18.3978 21 18.7794 20.842 19.0607 20.5607C19.342 20.2794 19.5 19.8978 19.5 19.5V6H20.25C20.4489 6 20.6397 5.92098 20.7803 5.78033C20.921 5.63968 21 5.44891 21 5.25C21 5.05109 20.921 4.86032 20.7803 4.71967C20.6397 4.57902 20.4489 4.5 20.25 4.5ZM9 3.75C9 3.55109 9.07902 3.36032 9.21967 3.21967C9.36032 3.07902 9.55109 3 9.75 3H14.25C14.4489 3 14.6397 3.07902 14.7803 3.21967C14.921 3.36032 15 3.55109 15 3.75V4.5H9V3.75ZM18 19.5H6V6H18V19.5ZM10.5 9.75V15.75C10.5 15.9489 10.421 16.1397 10.2803 16.2803C10.1397 16.421 9.94891 16.5 9.75 16.5C9.55109 16.5 9.36032 16.421 9.21967 16.2803C9.07902 16.1397 9 15.9489 9 15.75V9.75C9 9.55109 9.07902 9.36032 9.21967 9.21967C9.36032 9.07902 9.55109 9 9.75 9C9.94891 9 10.1397 9.07902 10.2803 9.21967C10.421 9.36032 10.5 9.55109 10.5 9.75ZM15 9.75V15.75C15 15.9489 14.921 16.1397 14.7803 16.2803C14.6397 16.421 14.4489 16.5 14.25 16.5C14.0511 16.5 13.8603 16.421 13.7197 16.2803C13.579 16.1397 13.5 15.9489 13.5 15.75V9.75C13.5 9.55109 13.579 9.36032 13.7197 9.21967C13.8603 9.07902 14.0511 9 14.25 9C14.4489 9 14.6397 9.07902 14.7803 9.21967C14.921 9.36032 15 9.55109 15 9.75Z" fill="#FF0000" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="button" id="btnAddFasilitas" class="btn btn-outline-light text-dark border-1 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 20px; border-style: solid; border-color: #E8E8E8;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M21 12C21 12.1989 20.921 12.3897 20.7803 12.5303C20.6397 12.671 20.4489 12.75 20.25 12.75H12.75V20.25C12.75 20.4489 12.671 20.6397 12.5303 20.7803C12.3897 20.921 12.1989 21 12 21C11.8011 21 11.6103 20.921 11.4697 20.7803C11.329 20.6397 11.25 20.4489 11.25 20.25V12.75H3.75C3.55109 12.75 3.36032 12.671 3.21967 12.5303C3.07902 12.3897 3 12.1989 3 12C3 11.8011 3.07902 11.6103 3.21967 11.4697C3.36032 11.329 3.55109 11.25 3.75 11.25H11.25V3.75C11.25 3.55109 11.329 3.36032 11.4697 3.21967C11.6103 3.07902 11.8011 3 12 3C12.1989 3 12.3897 3.07902 12.5303 3.21967C12.671 3.36032 12.75 3.55109 12.75 3.75V11.25H20.25C20.4489 11.25 20.6397 11.329 20.7803 11.4697C20.921 11.6103 21 11.8011 21 12Z" fill="#101010" />
                        </svg>
                    </button>
                </div>
            </div>

            <hr class="border-light opacity-50">

            <div>
                <label class="form-label font-T5-Medium mb-3">Foto Utama</label>
                <div class="d-flex gap-3 flex-wrap">
                    <label for="uploadFoto" class="cursor-pointer d-flex flex-column align-items-center justify-content-center border rounded-4 bg-white" style="width: 150px; height: 150px; border-style: dashed !important; border-color: #d1d5db !important; transition: all 0.2s;">
                        <div class="text-center">
                            <x-phosphor-upload-simple />
                            <span class="d-block font-T5-Regular text-secondary">Unggah gambar</span>
                        </div>
                        <input type="file" name="url_gambar_penginapan" id="uploadFoto" class="d-none" accept="image/*" onchange="previewMainImage(event)">
                    </label>

                    <div id="mainPreviewBox" class="d-none position-relative rounded-4 overflow-hidden shadow-sm" style="width: 150px; height: 150px;">
                        <img id="mainImgPreview" src="#" class="w-100 h-100 object-fit-cover">
                        <button type="button" onclick="removeMainImage()" class="btn btn-white bg-white text-danger position-absolute top-0 end-0 m-2 p-1 rounded-circle shadow-sm d-flex justify-content-center align-items-center" style="width: 24px; height: 24px;">x</button>
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
        newRow.id = `fasilitas-row-${index}`;

        newRow.innerHTML = `
            <label class="cursor-pointer bg-light rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 position-relative overflow-hidden" style="width: 36px; height: 36px;">
                <svg id="icon-preview-${index}" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="17 8 12 3 7 8"></polyline>
                    <line x1="12" y1="3" x2="12" y2="15"></line>
                </svg>
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
@endsection