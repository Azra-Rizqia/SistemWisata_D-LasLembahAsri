@extends('layouts.app')

@section('content')
<div class="container py-4">
    <form action="{{ route('pesan_tiket_paket.update', $pesananTiket->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('pesan_tiket_paket.index') }}">Daftar Pesanan</a></li>
                        <li class="breadcrumb-item active">Edit Pesanan</li>
                    </ol>
                </nav>
                <h4 class="fw-bold mt-2">Edit Transaksi Paket</h4>
            </div>
            <button type="submit" class="btn btn-success px-4" style="border-radius: 8px;">
                Simpan Perubahan
            </button>
        </div>

        {{-- ERROR HANDLING --}}
        @if ($errors->any())
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- MAIN CONTENT (Struktur Simpel Gambar 1) --}}
        <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
            <div class="row g-4">
                
                {{-- Baris 1: Paket & Pemesan --}}
                <div class="col-md-6">
                    <label class="form-label text-muted">Pilih Paket Tiket</label>
                    <select name="id_tiket_paket" id="id_tiket_paket" class="form-select" style="border-radius: 10px;" required>
                        @foreach ($tiketPaket as $paket)
                            <option value="{{ $paket->id }}" 
                                data-harga="{{ $paket->harga_tiket_weekday }}"
                                {{ $paket->id == old('id_tiket_paket', $pesananTiket->id_tiket_paket) ? 'selected' : '' }}>
                                {{ $paket->nama_tiket_paket }} (Rp{{ number_format($paket->harga_tiket_weekday, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Nama Pemesan</label>
                    <select name="id_user" class="form-select" style="border-radius: 10px;" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" 
                                {{ $user->id == old('id_user', $pesananTiket->id_user) ? 'selected' : '' }}>
                                {{ $user->nama_user }} ({{ $user->email_user }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Baris 2: Tanggal & Jumlah --}}
                <div class="col-md-6">
                    <label class="form-label text-muted">Tanggal Pembelian</label>
                    <input type="datetime-local" name="tanggal_pembelian" class="form-control" style="border-radius: 10px;"
                        value="{{ old('tanggal_pembelian', \Carbon\Carbon::parse($pesananTiket->tanggal_pembelian)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Jumlah Tiket</label>
                    <input type="number" name="jumlah_pesanan" id="jumlah_pesanan" class="form-control" style="border-radius: 10px;"
                        value="{{ old('jumlah_pesanan', $pesananTiket->jumlah_tiket) }}" min="1" required>
                </div>

                {{-- Baris 3: Status & Rincian Harga --}}
                <div class="col-md-6">
                    <label class="form-label text-muted">Status Pesanan</label>
                    <select name="status_pesanan" class="form-select" style="border-radius: 10px;" required>
                        <option value="Proses" {{ old('status_pesanan', $pesananTiket->status) == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ old('status_pesanan', $pesananTiket->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ old('status_pesanan', $pesananTiket->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label text-muted">Total Bayar (Otomatis)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light" style="border-radius: 10px 0 0 10px;">Rp</span>
                        <input type="text" id="label_total" class="form-control fw-bold text-success" 
                            style="border-radius: 0 10px 10px 0; background-color: #f8f9fa;" readonly>
                    </div>
                    <small class="text-muted">*Termasuk Pajak 10%</small>
                </div>

            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-5 border-top pt-3">
                <a href="{{ route('pesan_tiket_paket.index') }}" class="btn btn-outline-secondary">
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        {{-- Hidden Input untuk data harga ke database --}}
        <input type="hidden" name="harga_pesanan" id="input_harga_pesanan">
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectPaket = document.getElementById('id_tiket_paket');
        const inputJumlah = document.getElementById('jumlah_pesanan');
        const labelTotal = document.getElementById('label_total');
        const inputHargaPesanan = document.getElementById('input_harga_pesanan');

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }

        function hitungTotal() {
            const selectedOption = selectPaket.options[selectPaket.selectedIndex];
            const hargaDasar = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const jumlah = parseInt(inputJumlah.value) || 0;

            const subtotal = hargaDasar * jumlah;
            const pajak = subtotal * 0.10;
            const total = subtotal + pajak;

            labelTotal.value = formatRupiah(total);
            
            // Simpan harga per tiket (harga dasar + pajak per unit) untuk dikirim ke controller
            // Sesuai logika database: harga_pesanan biasanya harga satuan setelah pajak
            inputHargaPesanan.value = hargaDasar + (hargaDasar * 0.10);
        }

        selectPaket.addEventListener('change', hitungTotal);
        inputJumlah.addEventListener('input', hitungTotal);

        hitungTotal(); // Jalankan saat pertama kali buka halaman
    });
</script>
@endsection