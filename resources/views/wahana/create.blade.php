@extends('layouts.app')

@section('content')
<div class="container">

    <form action="{{ route('wahana.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="head-page-breadcrumb">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('wahana.index') }}">Kelola Konten</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Wahana</li>
                </ol>
            </nav>
            <button type="submit" class="btn btn-primary">
                Tambahkan Wahana
            </button>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="section-detail">

            <div class="subsection-main">

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Nama Wahana</label>
                        <input type="text" name="nama_wahana" id="nama_wahana" class="form-control"
                            value="{{ old('nama_wahana') }}"
                            placeholder="Masukkan nama wahana"
                            style="border-radius:32px"
                            required>

                        <small id="nama_warning" class="text-danger"></small>
                    </div>

                    <div class="input-item">
                        <label class="form-label">Harga Tiket</label>
                        <input type="number" name="harga_tiket_wahana" class="form-control"
                            value="{{ old('harga_tiket_wahana') }}"
                            placeholder="Masukkan harga"
                            style="border-radius:32px" required>
                    </div>
                </div>

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Status</label>
                        <select name="status_wahana" class="form-select"
                            style="border-radius:32px" required>
                            <option value="">Pilih status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="input-item">
                        <label class="form-label">Pengelola Wahana</label>
                        <input type="text" name="pengelola_wahana" class="form-control"
                            value="{{ old('pengelola_wahana') }}"
                            placeholder="Masukkan nama pengelola"
                            style="border-radius:32px" required>
                    </div>
                </div>

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Deskripsi Wahana</label>
                        <input type="text" name="deskripsi_wahana" class="form-control"
                            value="{{ old('deskripsi_wahana') }}"
                            placeholder="Deskripsi singkat"
                            style="border-radius:32px" required>
                    </div>
                </div>

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Tentang Wahana</label>
                        <textarea name="tentang_wahana" class="form-control"
                            rows="4"
                            style="border-radius:32px" required>{{ old('tentang_wahana') }}</textarea>
                    </div>
                </div>

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Gambar Wahana</label>
                        <input type="file" name="url_gambar_wahana" class="form-control"
                            accept="image/*"
                            style="border-radius:32px" required>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection