@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Tiket Paket</h1>

    <form action="{{ route('tiket_paket.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Tiket Paket</label>
            <input type="text" name="nama_tiket_paket" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi Tiket</label>
            <textarea name="deskripsi_tiket" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Pengelola Wahana</label>
            <input type="text" name="pengelola_wahana" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Harga Weekday</label>
            <input type="number" name="harga_tiket_weekday" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Harga Weekend</label>
            <input type="number" name="harga_tiket_weekend" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status_tiket" class="form-control">
                <option value="Tersedia">Tersedia</option>
                <option value="Tidak Tersedia">Tidak Tersedia</option>
            </select>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('tiket_paket.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
