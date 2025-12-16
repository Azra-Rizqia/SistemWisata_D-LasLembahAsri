@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('reservasi_fasilitas.store') }}" method="POST">
            @csrf

            <div class="head-page-breadcrumb">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('reservasi_fasilitas.index') }}">Reservasi Fasilitas</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Reservasi</li>
                    </ol>
                </nav>
                <button type="submit" class="btn btn-primary">
                    Tambahkan Reservasi
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
                            <input type="text" name="kategori_reservasi" class="form-control" placeholder="Masukan Kategori Reservasi"
                                value="{{ old('kategori_reservasi') }}" style="border-radius : 32px" required>
                        </div>
                        <div class="input-item">
                            <label class="form-label">Tanggal Reservasi</label>
                            <input type="date" name="tanggal_reservasi" class="form-control"
                                value="{{ old('tanggal_reservasi') }}" style="border-radius : 32px" required>
                        </div>
                    </div>

                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Fasilitas</label>
                            <select name="id_fasilitas" id="fasilitas" class="form-select" style="border-radius : 32px" required>
                                <option value="">Pilih Fasilitas</option>
                                @foreach ($fasilitas as $item)
                                    <option value="{{ $item->id }}" data-harga="{{ $item->harga_fasilitas }}"
                                        {{ old('id_fasilitas') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_fasilitas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-item">
                            <label class="form-label">Nama Pemesan</label>
                            <select name="id_user" class="form-select" style="border-radius : 32px" required>
                                <option value="">Pilih User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('id_user') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_user ?? $user->name }} ({{ $user->email_user }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="input-item">
                        <label class="form-label">Status Reservasi</label>
                        <select name="status_reservasi" class="form-select" style="border-radius : 32px" required>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <div class="subsection-info">
                    <div class="input-item">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran_reservasi" class="form-select" style="border-radius : 32px" required>
                            <option value="Debit">Debit</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>

                    <div class="list-information">
                        <label class="form-label">Harga Sewa</label>
                        <input type="text" id="harga_reservasi_view" class="value-item" readonly value="Rp-">
                    </div>

                    <div class="list-information">
                        <label class="form-label">Pajak (10%)</label>
                        <input type="text" id="pajak_view" class="value-item" readonly value="Rp-">
                    </div>

                    <hr>

                    <div class="list-information">
                        <label class="form-label fw-bold">Total Pembayaran</label>
                        <input type="text" id="total_pembayaran_view" class="value-item fw-bold text-success" readonly
                            value="Rp-">
                    </div>

                    <input type="hidden" name="total_harga_reservasi" id="total_harga_reservasi"
                        value="{{ old('total_harga_reservasi') }}">
                </div>
            </div>

        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fasilitasSelect = document.getElementById('fasilitas');
            const hargaReservasiView = document.getElementById('harga_reservasi_view');
            const pajakView = document.getElementById('pajak_view');
            const totalPembayaranView = document.getElementById('total_pembayaran_view');
            const totalHargaHidden = document.getElementById('total_harga_reservasi');
            const pajakRate = 0.10;

            function formatRupiah(angka) {
                if (!angka || angka == 0) return 'Rp-';
                return 'Rp' + parseInt(angka).toLocaleString('id-ID');
            }

            function updateSummary() {
                const selectedOption = fasilitasSelect.options[fasilitasSelect.selectedIndex];
                const hargaReservasi = parseInt(selectedOption.dataset.harga || 0);
                const hargaTambahan = 0;
                const totalDasar = hargaReservasi + hargaTambahan;
                const pajak = totalDasar * pajakRate;
                const totalPembayaran = totalDasar + pajak;
                hargaReservasiView.value = formatRupiah(hargaReservasi);
                pajakView.value = formatRupiah(pajak);
                totalPembayaranView.value = formatRupiah(totalPembayaran);
                totalHargaHidden.value = totalPembayaran;
            }
            fasilitasSelect.addEventListener('change', updateSummary);
            updateSummary();
        });
    </script>
@endsection
