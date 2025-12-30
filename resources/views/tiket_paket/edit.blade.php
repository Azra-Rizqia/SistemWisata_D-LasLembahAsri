@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Edit Tiket Paket</h1>
            <p class="font-T3-Regular">Perbarui data tiket paket</p>
        </div>
    </div>

    <div class="main-content mt-4">
        <form action="{{ route('tiket_paket.update', $tiket_paket->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted">Nama Paket</label>
                    <input type="text" name="nama_tiket_paket"
                        class="form-control"
                        style="border-radius: 10px;"
                        value="{{ old('nama_tiket_paket', $tiket_paket->nama_tiket_paket) }}"
                        required>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted">Pengelola Wahana</label>
                    <input type="text" name="pengelola_wahana"
                        class="form-control"
                        style="border-radius: 10px;"
                        value="{{ old('pengelola_wahana', $tiket_paket->pengelola_wahana) }}"
                        required>
                </div>
                <div class="col-md-12">
                    <label class="form-label text-muted">Tentang Tiket Paket</label>
                    <textarea name="deskripsi_tiket"
                        class="form-control"
                        style="border-radius: 10px;"
                        rows="3"
                        required>{{ old('deskripsi_tiket', $tiket_paket->deskripsi_tiket) }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label text-muted">Benefit yang Didapatkan</label>
                    <textarea name="yang_didapatkan"
                        class="form-control"
                        style="border-radius: 10px;"
                        rows="3">{{ old('yang_didapatkan', $tiket_paket->yang_didapatkan ?? '') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted">Harga Hari Biasa (Weekday)</label>
                    <input type="number" name="harga_tiket_weekday"
                        class="form-control"
                        style="border-radius: 10px;"
                        value="{{ old('harga_tiket_weekday', $tiket_paket->harga_tiket_weekday) }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Harga Hari Libur (Weekend)</label>
                    <input type="number" name="harga_tiket_weekend"
                        class="form-control"
                        style="border-radius: 10px;"
                        value="{{ old('harga_tiket_weekend', $tiket_paket->harga_tiket_weekend) }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Status</label>
                    <select name="status_tiket" class="form-select" style="border-radius: 10px;" required>
                        <option value="Tersedia"
                            {{ old('status_tiket', $tiket_paket->status_tiket) == 'Tersedia' ? 'selected' : '' }}>
                            Tersedia
                        </option>
                        <option value="Tidak Tersedia"
                            {{ old('status_tiket', $tiket_paket->status_tiket) == 'Tidak Tersedia' ? 'selected' : '' }}>
                            Tidak Tersedia
                        </option>
                    </select>
                </div>
                
                <div class="col-md-12 mt-4">
                    <label class="form-label text-muted">Gambar Tiket Paket</label>
                    
                    @if($tiket_paket->kumpulan_foto)
                        <p class="form-text mb-1">File saat ini: **{{ count($tiket_paket->kumpulan_foto) }} file terlampir**</p>
                    @endif

                    <input type="file" name="kumpulan_foto[]" id="kumpulan_foto" class="form-control" style="border-radius: 10px;" multiple>
                    
                    <small class="form-text text-muted">*Kosongkan jika tidak ingin mengganti atau menghapus file yang sudah ada</small>
                </div>

            </div>

            <div class="mt-4">
                <a href="{{ route('tiket_paket.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection