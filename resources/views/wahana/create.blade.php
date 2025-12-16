@extends('layouts.app')

@section('content')
<div class="container mt-4"> 

    <form action="{{ route('wahana.store') }}" method="POST" enctype="multipart/form-data">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb" class="mb-0">
                <ol class="breadcrumb mb-0 p-0 bg-transparent"> 
                    <li class="breadcrumb-item">
                        <a href="{{ route('wahana.index') }}" class="text-decoration-none">Kelola Konten</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data Wahana Satuan</li>
                </ol>
            </nav>

            <button type="submit" class="btn btn-success text-white">
                Tambahkan Tiket Wahana Satuan
            </button>
        </div>

        <div class="card p-4 shadow-sm"> 
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="namaWahana" class="form-label">Nama Wahana</label>
                        <input type="text" class="form-control" id="namaWahana" name="nama" placeholder="Masukan nama">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" placeholder="Masukan harga"> 
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option selected>Pilih status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsiSingkat" class="form-label">Deskripsi Singkat</label>
                    <input type="text" class="form-control" id="deskripsiSingkat" name="deskripsi_singkat" placeholder="Tambahkan deskripsi singkat">
                </div>

                <div class="mb-3">
                    <label for="tentangWahana" class="form-label">Tentang Wahana</label>
                    <textarea class="form-control" id="tentangWahana" name="tentang_wahana" rows="5" placeholder="Tambahkan tentang wahana"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Tiket</label>
                    <div class="d-flex align-items-center">
                        <div class="custom-upload-box d-flex flex-column align-items-center justify-content-center border rounded p-4 text-center" style="width: 150px; height: 150px; cursor: pointer;">
                            <input type="file" id="fotoUpload" name="gambar[]" multiple hidden>
                            <label for="fotoUpload" class="d-flex flex-column align-items-center justify-content-center m-0" style="cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cloud-upload mb-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.406 1.3A5.5 5.5 0 0 1 12 5.5V10h-2.5a.5.5 0 0 0 0 1H10v.5a.5.5 0 0 1 1 0v-.5h2a.5.5 0 0 0 0-1h-2a.5.5 0 0 1-.5-.5V5.5a4.5 4.5 0 1 0-8.232-1.932A2.5 2.5 0 0 0 2 5.5a.5.5 0 0 1-1 0 3.5 3.5 0 1 1 3.757-3.399z"/>
                                    <path d="M7.75 8a.5.5 0 0 1 .5-.5h2.5a.5.5 0 0 1 0 1H8.25a.5.5 0 0 1-.5-.5z"/>
                                    <path d="M7.75 9.5a.5.5 0 0 1 .5-.5h2.5a.5.5 0 0 1 0 1H8.25a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                                <span>Unggah gambar</span>
                            </label>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </form>
</div>

@endsection