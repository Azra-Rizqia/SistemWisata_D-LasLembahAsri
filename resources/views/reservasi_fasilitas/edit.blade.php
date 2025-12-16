@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('reservasi_fasilitas.update', $reservasi_fasilita->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="head-page-breadcrumb">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('reservasi_fasilitas.index') }}">Reservasi Fasilitas</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Reservasi</li>
                    </ol>
                </nav>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
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
                            <label class="form-label">Kategori Reservasi</label>
                            <input type="text" name="kategori_reservasi" class="form-control"
                                value="{{ old('kategori_reservasi', $reservasi_fasilita->kategori_reservasi) }}"
                                style="border-radius:32px" required>
                        </div>

                        <div class="input-item">
                            <label class="form-label">Tanggal Reservasi</label>
                            <input type="date" name="tanggal_reservasi" class="form-control"
                                value="{{ old('tanggal_reservasi', $reservasi_fasilita->tanggal_reservasi) }}"
                                style="border-radius:32px" required>
                        </div>
                    </div>

                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Fasilitas</label>
                            <select name="id_fasilitas" id="fasilitas" class="form-select" style="border-radius:32px"
                                required>
                                <option value="">Pilih Fasilitas</option>
                                @foreach ($fasilitas as $item)
                                    <option value="{{ $item->id }}" data-harga="{{ $item->harga_fasilitas }}"
                                        {{ old('id_fasilitas', $reservasi_fasilita->id_fasilitas) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_fasilitas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-item">
                            <label class="form-label">Nama Pemesan</label>
                            <select name="id_user" class="form-select" style="border-radius:32px" required>
                                <option value="">Pilih User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('id_user', $reservasi_fasilita->id_user) == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_user ?? $user->name }} ({{ $user->email_user }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="input-item">
                        <label class="form-label">Status Reservasi</label>
                        <select name="status_reservasi" class="form-select" style="border-radius:32px" required>
                            @foreach (['Proses', 'Selesai', 'Dibatalkan'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status_reservasi', $reservasi_fasilita->status_reservasi) == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="subsection-info">
                    <div class="input-item">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran_reservasi" class="form-select" style="border-radius:32px" required>
                            @foreach (['Debit', 'QRIS'] as $metode)
                                <option value="{{ $metode }}"
                                    {{ old('metode_pembayaran_reservasi', $reservasi_fasilita->metode_pembayaran_reservasi) == $metode ? 'selected' : '' }}>
                                    {{ $metode }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="list-information">
                        <label class="form-label">Harga Sewa</label>
                        <input type="text" id="harga_reservasi_view" class="value-item" readonly>
                    </div>

                    <div class="list-information">
                        <label class="form-label">Pajak (10%)</label>
                        <input type="text" id="pajak_view" class="value-item" readonly>
                    </div>

                    <hr>

                    <div class="list-information">
                        <label class="form-label fw-bold">Total Pembayaran</label>
                        <input type="text" id="total_pembayaran_view" class="value-item fw-bold text-success" readonly>
                    </div>

                    <input type="hidden" name="total_harga_reservasi" id="total_harga_reservasi"
                        value="{{ old('total_harga_reservasi', $reservasi_fasilita->total_harga_reservasi) }}">
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fasilitasSelect = document.getElementById('fasilitas');
            const hargaView = document.getElementById('harga_reservasi_view');
            const pajakView = document.getElementById('pajak_view');
            const totalView = document.getElementById('total_pembayaran_view');
            const totalHidden = document.getElementById('total_harga_reservasi');
            const pajakRate = 0.10;

            function formatRupiah(angka) {
                if (!angka || angka == 0) return 'Rp-';
                return 'Rp' + parseInt(angka).toLocaleString('id-ID');
            }

            function updateSummary() {
                const option = fasilitasSelect.options[fasilitasSelect.selectedIndex];
                const harga = parseInt(option?.dataset.harga || 0);
                const pajak = harga * pajakRate;
                const total = harga + pajak;

                hargaView.value = formatRupiah(harga);
                pajakView.value = formatRupiah(pajak);
                totalView.value = formatRupiah(total);
                totalHidden.value = total;
            }

            fasilitasSelect.addEventListener('change', updateSummary);
            updateSummary();
        });
    </script>
@endsection
