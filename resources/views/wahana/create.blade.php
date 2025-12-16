@extends('layouts.app')

@section('content')
<div class="container mt-4"> 

    <form action="{{ route('wahana.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb" class="mb-0">
                <ol class="breadcrumb mb-0 p-0 bg-transparent"> 
                    <li class="breadcrumb-item">
                        <a href="{{ route('wahana.index') }}" class="text-decoration-none">
                            Kelola Konten
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Tambah Data Wahana
                    </li>
                </ol>
            </nav>

            <button type="submit" class="btn btn-success">
                Simpan Wahana
            </button>
        </div>

        <div class="card p-4 shadow-sm"> 

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nama Wahana</label>
                    <input type="text" class="form-control"
                           name="nama_wahana"
                           placeholder="Masukkan nama wahana"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga Tiket</label>
                    <input type="number" class="form-control"
                           name="harga_tiket_wahana"
                           placeholder="Masukkan harga"
                           required>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status_wahana" required>
                        <option value="">Pilih status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="mb-3">
                    <label class="form-label">Pengelola Wahana</label>
                    <input type="text" class="form-control"
                           name="pengelola_wahana"
                           required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi Wahana</label>
                <input type="text" class="form-control"
                       name="deskripsi_wahana"
                       placeholder="Deskripsi singkat"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tentang Wahana</label>
                <textarea class="form-control"
                          name="tentang_wahana"
                          rows="4"
                          required></textarea>
            </div>
        </div>
    </form>
