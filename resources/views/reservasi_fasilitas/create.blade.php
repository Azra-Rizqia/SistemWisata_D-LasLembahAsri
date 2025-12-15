@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('reservasi_fasilitas.index') }}">Reservasi Fasilitas</a>
                </li>
                <li class="breadcrumb-item active">Tambah Reservasi</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Reservasi Fasilitas</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('reservasi_fasilitas.store') }}" method="POST">
                    @csrf

                    {{-- Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">

                        {{-- Kategori --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori Reservasi</label>
                            <input type="text" name="kategori_reservasi" class="form-control"
                                value="{{ old('kategori_reservasi') }}" required>
                        </div>

                        {{-- Tanggal --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Reservasi</label>
                            <input type="date" name="tanggal_reservasi" class="form-control"
                                value="{{ old('tanggal_reservasi') }}" required>
                        </div>

                        {{-- Fasilitas --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fasilitas</label>
                            <select name="id_fasilitas" id="fasilitas" class="form-select">
                                <option value="">-- Pilih Fasilitas --</option>
                                @foreach ($fasilitas as $item)
                                    <option value="{{ $item->id }}" data-harga="{{ $item->harga_fasilitas }}"
                                        {{ old('id_fasilitas') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_fasilitas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- User --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pemesan</label>
                            <select name="id_user" class="form-select">
                                <option value="">-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('id_user') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_user ?? $user->name }} ({{ $user->email_user }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran_reservasi" class="form-select" required>
                                <option value="Debit">Debit</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Reservasi</label>
                            <select name="status_reservasi" class="form-select" required>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Harga Reservasi</label>
                            <input type="text" id="harga_view" class="form-control" readonly>
                            <input type="hidden" name="total_harga_reservasi" id="total_harga_reservasi"
                                value="{{ old('total_harga_reservasi') }}">
                        </div>

                        {{-- Catatan --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan_user_reservasi" class="form-control" rows="3">{{ old('catatan_user_reservasi') }}</textarea>
                        </div>

                    </div>

                    <hr>

                    {{-- Button --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('reservasi_fasilitas.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fasilitas = document.getElementById('fasilitas');
            const hargaView = document.getElementById('harga_view');
            const hargaHidden = document.getElementById('total_harga_reservasi');

            fasilitas.addEventListener('change', function() {
                const option = this.options[this.selectedIndex];
                const harga = option.dataset.harga;

                if (!harga) {
                    hargaView.value = '';
                    hargaHidden.value = '';
                    return;
                }

                hargaView.value = formatRupiah(harga);
                hargaHidden.value = harga;
            });

            function formatRupiah(angka) {
                return 'Rp' + parseInt(angka).toLocaleString('id-ID');
            }
        });
    </script>
@endsection
