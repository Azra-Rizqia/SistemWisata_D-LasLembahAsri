@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('reservasi_penginapan.store') }}" method="POST">
            @csrf

            <div class="head-page-breadcrumb">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('reservasi_penginapan.index') }}">Reservasi Penginapan</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Reservasi</li>
                    </ol>
                </nav>
                <button type="submit" class="btn btn-primary">
                    Simpan Reservasi
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
                            <label class="form-label">Nama Pemesan</label>
                            <select name="id_user" class="form-select" style="border-radius : 32px" required>
                                <option value="">Pilih User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                                        {{-- Menyesuaikan dengan kolom di tabel users (nama_user atau name) --}}
                                        {{ $user->nama_user ?? $user->name }} ({{ $user->email_user ?? $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="input-item">
                            <label class="form-label">Jumlah Tamu</label>
                            <input type="number" name="jumlah_tamu" class="form-control" placeholder="1" min="1"
                                value="{{ old('jumlah_tamu', 1) }}" style="border-radius : 32px" required>
                        </div>
                    </div>

                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Tanggal Check-In</label>
                            <input type="date" name="tanggal_checkin" id="tanggal_masuk" class="form-control"
                                value="{{ old('tanggal_masuk') }}" style="border-radius : 32px" required>
                        </div>
                        <div class="input-item">
                            <label class="form-label">Tanggal Check-Out</label>
                            <input type="date" name="tanggal_checkout" id="tanggal_keluar" class="form-control"
                                value="{{ old('tanggal_keluar') }}" style="border-radius : 32px" required>
                        </div>
                    </div>

                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Tipe Penginapan</label>
                            <select name="id_kamar" id="id_kamar" class="form-select" style="border-radius : 32px" required>
                                <option value="" data-harga="0">Pilih Penginapan</option>
                                @foreach ($kamar as $item)
                                    {{-- PENTING: data-harga diambil dari harga_weekday --}}
                                    <option value="{{ $item->id }}" 
                                            data-harga="{{ $item->harga_weekday }}" 
                                            {{ old('id_kamar') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_penginapan }} - Rp{{ number_format($item->harga_weekday, 0, ',', '.') }}/malam
                                    </option>
                                @endforeach
                            </select>
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
                </div>

                <div class="subsection-info">
                    <div class="input-item">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran_reservasi" class="form-select" style="border-radius : 32px" required>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Tunai">Tunai</option>
                        </select>
                    </div>

                    <div class="list-information">
                        <label class="form-label">Harga per Malam</label>
                        <input type="text" id="harga_kamar_view" class="value-item" readonly value="Rp0">
                    </div>

                    <div class="list-information">
                        <label class="form-label">Durasi</label>
                        <input type="text" id="durasi_view" class="value-item" readonly value="0 Malam">
                    </div>

                    <div class="list-information">
                        <label class="form-label">Subtotal</label>
                        <input type="text" id="subtotal_view" class="value-item" readonly value="Rp0">
                    </div>

                    <div class="list-information">
                        <label class="form-label">Pajak (10%)</label>
                        <input type="text" id="pajak_view" class="value-item" readonly value="Rp0">
                    </div>

                    <hr>

                    <div class="list-information">
                        <label class="form-label fw-bold">Total Pembayaran</label>
                        <input type="text" id="total_pembayaran_view" class="value-item fw-bold text-success" readonly value="Rp0">
                    </div>

                    <input type="hidden" name="total_harga" id="total_harga" value="{{ old('total_harga', 0) }}">
                </div>
            </div>
        </form>
    </div>

    {{-- Script Perhitungan Otomatis --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const elKamar = document.getElementById('id_kamar');
            const elCheckIn = document.getElementById('tanggal_masuk');
            const elCheckOut = document.getElementById('tanggal_keluar');
            
            const viewHarga = document.getElementById('harga_kamar_view');
            const viewDurasi = document.getElementById('durasi_view');
            const viewSubtotal = document.getElementById('subtotal_view');
            const viewPajak = document.getElementById('pajak_view');
            const viewTotal = document.getElementById('total_pembayaran_view');
            const inputTotal = document.getElementById('total_harga');

            const pajakRate = 0.10; 

            function formatRupiah(angka) {
                return 'Rp' + new Intl.NumberFormat('id-ID').format(angka);
            }

            function hitungTotal() {
                const selectedOption = elKamar.options[elKamar.selectedIndex];
                const hargaPerMalam = parseInt(selectedOption.getAttribute('data-harga')) || 0;

                let durasi = 0;
                if (elCheckIn.value && elCheckOut.value) {
                    const d1 = new Date(elCheckIn.value);
                    const d2 = new Date(elCheckOut.value);
                    const diffTime = d2 - d1; 
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    durasi = diffDays > 0 ? diffDays : 0;
                }

                const subtotal = hargaPerMalam * durasi;
                const pajak = subtotal * pajakRate;
                const total = subtotal + pajak;

                viewHarga.value = formatRupiah(hargaPerMalam);
                viewDurasi.value = durasi + " Malam";
                viewSubtotal.value = formatRupiah(subtotal);
                viewPajak.value = formatRupiah(pajak);
                viewTotal.value = formatRupiah(total);
                
                inputTotal.value = total;
            }

            elKamar.addEventListener('change', hitungTotal);
            elCheckIn.addEventListener('change', hitungTotal);
            elCheckOut.addEventListener('change', hitungTotal);
            hitungTotal();
        });
    </script>
@endsection