@extends('layouts.app')

@section('content')

@error('id_user')
    <small class="text-danger">{{ $message }}</small>
@enderror

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const pajakRate = 0.10; // Pajak 10%

        // 1. Ambil inputan dari layar
        const selectPaket = document.querySelector('[name="id_tiket_paket"]');
        const selectJumlah = document.querySelector('[name="jumlah_tiket"]'); // Tadi sudah kita ubah namanya
        const inputTanggal = document.querySelector('[name="tanggal_pembelian"]');

        // 2. Ambil tempat buat nampilin angka (yang ada tulisan Rp)
        const hargaDisplay = document.getElementById('harga_paket');
        const pajakDisplay = document.getElementById('pajak');
        const totalDisplay = document.getElementById('total');

        // 3. Ambil inputan "rahasia" (Hidden) yang bakal dikirim ke database
        const hargaHidden = document.getElementById('harga_paket_hidden');
        const totalHidden = document.getElementById('total_hidden');

        function hitung() {
            const selectedOption = selectPaket.options[selectPaket.selectedIndex];
            const jumlah = parseInt(selectJumlah.value) || 0;
            const tanggalValue = inputTanggal.value;

            // Jika belum pilih paket atau jumlah, biarkan Rp0
            if (!selectedOption.value || jumlah <= 0 || !tanggalValue) {
                resetAngka();
                return;
            }

            // CEK HARI: Weekday vs Weekend
            const tanggal = new Date(tanggalValue);
            const hari = tanggal.getDay(); // 0 = Minggu, 6 = Sabtu
            const isWeekend = (hari === 6 || hari === 0);

            // AMBIL HARGA dari data- yang sudah ada di <option>
            const hargaWeekday = parseInt(selectedOption.getAttribute('data-weekday')) || 0;
            const hargaWeekend = parseInt(selectedOption.getAttribute('data-weekend')) || 0;

            // Pilih harga yang sesuai hari
            const hargaSatuan = isWeekend ? hargaWeekend : hargaWeekday;

            // HITUNG TOTALNYA
            const subtotal = jumlah * hargaSatuan;
            const pajakVal = subtotal * pajakRate;
            const totalVal = subtotal + pajakVal;

            // TAMPILKAN DI LAYAR (Biar admin senang lihat ada Rp-nya)
            hargaDisplay.value = formatKeRupiah(subtotal);
            pajakDisplay.value = formatKeRupiah(pajakVal);
            totalDisplay.value = formatKeRupiah(totalVal);

            // MASUKKAN KE HIDDEN INPUT (Ini yang bakal masuk ke database kamu)
            hargaHidden.value = subtotal; // Akan masuk ke kolom 'harga_pesanan'
            totalHidden.value = totalVal; 
        }

        function formatKeRupiah(angka) {
            return 'Rp' + angka.toLocaleString('id-ID');
        }

        function resetAngka() {
            hargaDisplay.value = 'Rp0';
            pajakDisplay.value = 'Rp0';
            totalDisplay.value = 'Rp0';
            hargaHidden.value = 0;
            totalHidden.value = 0;
        }

        // Pantau perubahan: Kalau admin klik/ngetik, langsung hitung ulang
        selectPaket.addEventListener('change', hitung);
        selectJumlah.addEventListener('change', hitung);
        selectJumlah.addEventListener('input', hitung);
        inputTanggal.addEventListener('change', hitung);

        hitung(); // Jalankan sekali saat awal buka halaman
    });
</script>


<div class="container">
    <form action="{{ route('pesan_tiket_paket.store') }}" method="POST">
        <div class="head-page-breadcrumb" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pesan_tiket_paket.index') }}">Tiket Paket</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Pembelian</li>
                </ol>
            </nav>
            <button type="submit" class="btn btn-success" style="background-color: #4CAF50; border: none; padding: 10px 20px; border-radius: 8px;">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>

        {{-- Main Container (Meniru Card Putih) --}}
        <div class="section-detail" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; gap: 30px;">

            <div class="subsection-main" style="flex: 2;">
                @csrf
                <h4 style="margin-bottom: 20px;">Informasi Pembelian</h4>

                <div class="kolom-input" style="display: flex; gap: 20px; margin-bottom: 15px;">
                    <div class="input-item" style="flex: 1;">
                        <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Nama Paket</label>

                        <select name="id_tiket_paket" class="form-select" style="border-radius : 8px; padding: 10px;" required>
                            <option value="">-- Pilih Paket --</option>

                            @foreach ($tiketPaket as $paket)
                                <option 
                                    value="{{ $paket->id }}"
                                    data-weekday="{{ $paket->harga_tiket_weekday }}"
                                    data-weekend="{{ $paket->harga_tiket_weekend }}"
                                >
                                    {{ $paket->nama_tiket_paket }}
                                    (Weekday: Rp{{ number_format($paket->harga_tiket_weekday,0,',','.') }},
                                    Weekend: Rp{{ number_format($paket->harga_tiket_weekend,0,',','.') }})
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="input-item" style="flex: 1;">
                        <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Jumlah Pesanan</label>
                        <input type="number" name="jumlah_tiket" class="form-control"
                            value="{{ old('jumlah_tiket', 1) }}" min="1" style="border-radius : 8px; padding: 10px;" required>
                    </div>
                </div>

                <div class="kolom-input" style="display: flex; gap: 20px; margin-bottom: 15px;">
                    <div class="input-item" style="flex: 1;">
                        <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Nama Pemesan</label>
                        <select name="id_user" class="form-control" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->nama_user }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-item" style="flex: 1;">
                        <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Tanggal Pembelian</label>
                        <input type="datetime-local" name="tanggal_pembelian" class="form-control"
                            value="{{ old('tanggal_pembelian', now()->format('Y-m-d\TH:i')) }}" style="border-radius : 8px; padding: 10px;" required>
                    </div>
                </div>

                <div class="input-item" style="margin-bottom: 15px;">
                    <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Status Pesanan</label>
                    <select name="status_pesanan" class="form-select" style="border-radius : 8px; padding: 10px;">
                        <option value="Proses" {{ old('status_pesanan') == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ old('status_pesanan') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ old('status_pesanan') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

            </div>

            {{-- Kolom Info Pembayaran (di sebelah kanan) --}}
            <div class="subsection-info" style="flex: 1; border-left: 1px solid #eee; padding-left: 30px;">
                <h4 style="margin-bottom: 20px;">Rincian Pembayaran</h4>
                
                <div class="input-item" style="margin-bottom: 25px;">
                    <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="form-select" style="border-radius : 8px; padding: 10px;" required>
                        <option value="Tunai" {{ old('metode_pembayaran') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="Debit" {{ old('metode_pembayaran') == 'Debit' ? 'selected' : '' }}>Debit</option>
                        <option value="QRIS" {{ old('metode_pembayaran') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        <option value="Transfer Bank" {{ old('metode_pembayaran') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                    </select>
                </div>

                <div class="list-information" style="display: flex; justify-content: space-between; padding: 10px 0; border-top: 1px solid #eee;">
                    <label class="form-label" style="font-weight: 500; margin: 0;">Subtotal Paket</label>
                    <input type="text" id="harga_paket" class="value-item" style="border: none; width: fit-content; text-align: right; font-weight: 600;" readonly value="Rp0">
                    <input type="hidden" name="harga_pesanan" id="harga_paket_hidden">
                </div>

                <div class="list-information" style="display: flex; justify-content: space-between; padding: 10px 0; border-top: 1px solid #eee;">
                    <label class="form-label" style="font-weight: 500; margin: 0;">Pajak (10%)</label>
                    <input type="text" id="pajak" class="value-item" style="border: none; width: fit-content; text-align: right; font-weight: 600;" readonly value="Rp0">
                </div>

                <div class="list-information" style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px solid #333;">
                    <label class="form-label fw-bold" style="font-weight: 700; margin: 0; font-size: 1.1em;">TOTAL PEMBAYARAN</label>
                    <input type="text" id="total" class="value-item fw-bold" style="border: none; width: fit-content; text-align: right; font-weight: 700; color: #4CAF50; font-size: 1.1em;" readonly value="Rp0">
                    <input type="hidden" name="total_pembayaran" id="total_hidden">
                </div>
            </div>
        </div>
    </form>
</div>
@endsection