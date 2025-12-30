@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Tambah Data Tiket Paket</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('tiket_paket.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="nama_tiket_paket" class="form-label text-muted">Nama Paket</label>
                        <input type="text" name="nama_tiket_paket" id="nama_tiket_paket" class="form-control" placeholder="Masukkan nama" required>
                    </div>

                    <div class="col-md-3">
                        <label for="harga_tiket_weekday" class="form-label text-muted">Harga Hari Biasa</label>
                        <input type="number" name="harga_tiket_weekday" id="harga_tiket_weekday" class="form-control" placeholder="Masukkan harga" required>
                    </div>

                    <div class="col-md-3">
                        <label for="harga_tiket_weekend" class="form-label text-muted">Harga Hari Libur</label>
                        <input type="number" name="harga_tiket_weekend" id="harga_tiket_weekend" class="form-control" placeholder="Masukkan harga" required>
                    </div>

                    <div class="col-md-3">
                        <label for="status_tiket" class="form-label text-muted">Status</label>
                        <select name="status_tiket" id="status_tiket" class="form-select">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="pengelola_wahana" class="form-label text-muted">Pengelola Wahana</label>
                    <input type="text" name="pengelola_wahana" id="pengelola_wahana" class="form-control" placeholder="Masukkan pengelola" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi_tiket" class="form-label text-muted">Tentang Tiket Paket</label>
                    <textarea name="deskripsi_tiket" id="deskripsi_tiket" class="form-control" rows="4" placeholder="Masukkan tentang paket ini" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="yang_didapatkan" class="form-label text-muted">Benefit yang Didapatkan</label>
                    <textarea name="yang_didapatkan" id="yang_didapatkan" class="form-control" rows="4" placeholder="Masukkan list wahana pada tiket ini . Contoh:&#10;*D'Las Zoo&#10;*Dino Land*&#10;dst"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted">Kumpulan Foto</label>

                    <input type="file" name="kumpulan_foto[]" id="kumpulan_foto" class="form-control" multiple>
                    
                    </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success me-2">Simpan Tiket Paket</button>
                    <a href="{{ route('tiket_paket.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection