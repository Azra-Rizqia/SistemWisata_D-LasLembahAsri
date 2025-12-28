@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Form Edit Reservasi Penginapan --}}
        <form action="{{ route('reservasi_penginapan.update', $reservasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="head-page-breadcrumb">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('reservasi_penginapan.index') }}">Reservasi Penginapan</a>
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
                {{-- Bagian Kiri: Form Input --}}
                <div class="subsection-main">
                    
                    {{-- Baris 1: Informasi Tamu --}}
                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Nama Pemesan</label>
                            <select name="id_user" class="form-select" style="border-radius:32px" required>
                                <option value="">Pilih User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" 
                                        {{ (string) old('id_user', $reservasi->user_id) == (string) $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_user ?? $user->name }} ({{ $user->email_user ?? $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-item">
                            <label class="form-label">Jumlah Tamu</label>
                            {{-- Mengambil jumlah tamu dari catatan karena kolom khusus tidak ada, atau default 1 --}}
                            @php
                                $jumlahTamu = 1;
                                if(preg_match('/Jumlah Tamu: (\d+)/', $reservasi->catatan_user_reservasi, $matches)) {
                                    $jumlahTamu = $matches[1];
                                }
                            @endphp
                            <input type="number" name="jumlah_tamu" class="form-control" placeholder="1" min="1"
                                value="{{ old('jumlah_tamu', $jumlahTamu) }}" style="border-radius:32px" required>
                        </div>
                    </div>

                    {{-- Baris 2: Tanggal Menginap --}}
                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Tanggal Check-In</label>
                            <input type="date" name="tanggal_checkin" id="tanggal_checkin" class="form-control"
                                value="{{ old('tanggal_checkin', $reservasi->tanggal_masuk) }}" 
                                style="border-radius:32px" required>
                        </div>
                        <div class="input-item">
                            <label class="form-label">Tanggal Check-Out</label>
                            <input type="date" name="tanggal_checkout" id="tanggal_checkout" class="form-control"
                                value="{{ old('tanggal_checkout', $reservasi->tanggal_keluar) }}" 
                                style="border-radius:32px" required>
                        </div>
                    </div>

                    {{-- Baris 3: Kamar & Status --}}
                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Tipe Penginapan</label>
                            <select name="id_kamar" id="id_kamar" class="form-select" style="border-radius:32px" required>
                                <option value="" data-harga="0">Pilih Penginapan</option>
                                @foreach ($kamar as $item)
                                    {{-- PERBAIKAN: Menggunakan (string) casting agar perbandingan lebih akurat --}}
                                    <option value="{{ $item->id }}" 
                                        data-harga="{{ $item->harga_weekday }}" 
                                        {{ (string) old('id_kamar', $reservasi->id_penginapan) == (string) $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_penginapan }} - Rp{{ number_format($item->harga_weekday, 0, ',', '.') }}/malam
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-item">
                            <label class="form-label">Status Reservasi</label>
                            <select name="status_reservasi" class="form-select" style="border-radius:32px" required>
                                @foreach (['Proses', 'Selesai', 'Dibatalkan'] as $status)
                                    <option value="{{ $status }}" 
                                        {{ old('status_reservasi', $reservasi->status_reservasi) == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Bagian Kanan: Ringkasan Biaya --}}
                <div class="subsection-info">
                    <div class="input-item">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran_reservasi" class="form-select" style="border-radius:32px" required>
                            @foreach (['Transfer Bank', 'QRIS', 'Tunai'] as $metode)
                                <option value="{{ $metode }}" 
                                    {{ old('metode_pembayaran_reservasi', $reservasi->metode_pembayaran) == $metode ? 'selected' : '' }}>
                                    {{ $metode }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="list-information">
                        <label class="form-label">Harga per Malam</label>
                        <input type="text" id="harga_kamar_view" class="value-item" readonly value="Rp-">
                    </div>

                    <div class="list-information">
                        <label class="form-label">Durasi Menginap</label>
                        <input type="text" id="durasi_view" class="value-item" readonly value="0 Malam">
                    </div>

                    <div class="list-information">
                        <label class="form-label">Subtotal</label>
                        <input type="text" id="subtotal_view" class="value-item" readonly value="Rp-">
                    </div>

                    <div class="list-information">
                        <label class="form-label">Pajak (10%)</label>
                        <input type="text" id="pajak_view" class="value-item" readonly value="Rp-">
                    </div>

                    <hr>

                    <div class="list-information">
                        <label class="form-label fw-bold">Total Pembayaran</label>
                        <input type="text" id="total_pembayaran_view" class="value-item fw-bold text-success" readonly value="Rp-">
                    </div>

                    {{-- Input Hidden untuk menyimpan nilai total ke database --}}
                    <input type="hidden" name="total_harga" id="total_harga" 
                        value="{{ old('total_harga', $reservasi->total_pembayaran) }}">
                </div>
            </div>
        </form>
    </div>

    {{-- Script JavaScript untuk Perhitungan Harga Otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Definisi Elemen
            const elKamar = document.getElementById('id_kamar');
            const elCheckIn = document.getElementById('tanggal_checkin');
            const elCheckOut = document.getElementById('tanggal_checkout');
            
            // Elemen Display
            const viewHarga = document.getElementById('harga_kamar_view');
            const viewDurasi = document.getElementById('durasi_view');
            const viewSubtotal = document.getElementById('subtotal_view');
            const viewPajak = document.getElementById('pajak_view');
            const viewTotal = document.getElementById('total_pembayaran_view');
            const inputTotal = document.getElementById('total_harga');

            const pajakRate = 0.10; // Pajak 10%

            // 2. Fungsi Format Rupiah
            function formatRupiah(angka) {
                if (!angka || isNaN(angka)) return 'Rp0';
                return 'Rp' + new Intl.NumberFormat('id-ID').format(angka);
            }

            // 3. Logic Utama Perhitungan
            function hitungTotal() {
                // Ambil harga dari atribut data-harga di <option> yang dipilih
                const selectedOption = elKamar.options[elKamar.selectedIndex];
                const hargaPerMalam = parseInt(selectedOption?.getAttribute('data-harga')) || 0;

                // Hitung selisih hari (Durasi)
                let durasi = 0;
                if (elCheckIn.value && elCheckOut.value) {
                    const d1 = new Date(elCheckIn.value);
                    const d2 = new Date(elCheckOut.value);
                    const diffTime = d2 - d1; 
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    durasi = diffDays > 0 ? diffDays : 0;
                }

                // Kalkulasi
                const subtotal = hargaPerMalam * durasi;
                const pajak = subtotal * pajakRate;
                const total = subtotal + pajak;

                // Update Tampilan
                viewHarga.value = formatRupiah(hargaPerMalam);
                viewDurasi.value = durasi + " Malam";
                viewSubtotal.value = formatRupiah(subtotal);
                viewPajak.value = formatRupiah(pajak);
                viewTotal.value = formatRupiah(total);
                
                // Update Nilai Hidden Input
                inputTotal.value = total;
            }

            // 4. Pasang Event Listener
            elKamar.addEventListener('change', hitungTotal);
            elCheckIn.addEventListener('change', hitungTotal);
            elCheckOut.addEventListener('change', hitungTotal);

            // 5. Jalankan sekali saat load agar data lama terhitung
            hitungTotal();
        });
    </script>
@endsection