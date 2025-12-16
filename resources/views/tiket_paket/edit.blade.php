@extends('layouts.app')

@section('content')
<div class="container">
    <div class="head-page">
        <div class="headline">
            <h1 class="font-h1">Edit Tiket Paket</h1>
            <p class="font-T3-Regular">Perbarui data tiket paket</p>
        </div>
    </div>

    <div class="main-content">
        <form action="{{ route('tiket_paket.update', $tiket_paket->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nama Paket</label>
                    <input type="text" name="nama_tiket_paket"
                        class="form-control"
                        value="{{ old('nama_tiket_paket', $tiket_paket->nama_tiket_paket) }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pengelola Wahana</label>
                    <input type="text" name="pengelola_wahana"
                        class="form-control"
                        value="{{ old('pengelola_wahana', $tiket_paket->pengelola_wahana) }}"
                        required>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Deskripsi Tiket</label>
                    <textarea name="deskripsi_tiket"
                        class="form-control"
                        rows="3"
                        required>{{ old('deskripsi_tiket', $tiket_paket->deskripsi_tiket) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Harga Weekday</label>
                    <input type="number" name="harga_tiket_weekday"
                        class="form-control"
                        value="{{ old('harga_tiket_weekday', $tiket_paket->harga_tiket_weekday) }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Harga Weekend</label>
                    <input type="number" name="harga_tiket_weekend"
                        class="form-control"
                        value="{{ old('harga_tiket_weekend', $tiket_paket->harga_tiket_weekend) }}"
                        required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status Tiket</label>
                    <select name="status_tiket" class="form-select" required>
                        <option value="Tersedia"
                            {{ $tiket_paket->status_tiket == 'Tersedia' ? 'selected' : '' }}>
                            Tersedia
                        </option>
                        <option value="Tidak Tersedia"
                            {{ $tiket_paket->status_tiket == 'Tidak Tersedia' ? 'selected' : '' }}>
                            Tidak Tersedia
                        </option>
                    </select>
                </div>

            </div>

            <div class="mt-4">
                <a href="{{ route('tiket_paket.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
