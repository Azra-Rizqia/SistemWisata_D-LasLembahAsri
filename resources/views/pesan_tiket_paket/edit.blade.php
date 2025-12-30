@extends('layouts.app')

@section('content')


@php
    
    $p = $pesananTiket; 
@endphp


<script>
 
    const hargaPaketList = {
        @foreach ($tiketPaket as $paket)
            '{{ $paket->id }}': {{ $paket->harga }},
        @endforeach
    };

    document.addEventListener('DOMContentLoaded', () => {
        const pajakRate = 0.10; 

        const selectPaket = document.querySelector('[name="id_tiket_paket"]');
        const selectJumlah = document.querySelector('[name="jumlah_pesanan"]');

        const subtotalInput = document.getElementById('subtotal_input');
        const pajakOutput = document.getElementById('pajak_output');
        const totalOutput = document.getElementById('total_output');
        const totalHidden = document.getElementById('total_hidden'); 

        function rupiah(num) {
            return 'Rp' + parseFloat(num).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }
        
        function hitung() {
            const paketId = selectPaket.value;
            const jumlah = parseInt(selectJumlah.value) || 0;

            if (!paketId || jumlah <= 0) {
                subtotalInput.value = rupiah(0);
                pajakOutput.value = rupiah(0);
                totalOutput.value = rupiah(0);
                totalHidden.value = 0;
                return;
            }

            const hargaSatuan = hargaPaketList[paketId] || 0;
            const subtotal = jumlah * hargaSatuan;
            const pajakVal = subtotal * pajakRate;
            const totalVal = subtotal + pajakVal;

            subtotalInput.value = rupiah(subtotal);
            pajakOutput.value = rupiah(pajakVal);
            totalOutput.value = rupiah(totalVal);
            totalHidden.value = totalVal; 
        }

        selectPaket.addEventListener('change', hitung);
        selectJumlah.addEventListener('change', hitung);
        selectJumlah.addEventListener('input', hitung);

        hitung();
    });
</script>


<div class="container">
    <form action="{{ route('pesan_tiket_paket.update', $p->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="head-page-breadcrumb" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pesan_tiket_paket.index') }}">Tiket Paket</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Pembelian</li>
                </ol>
            </nav>
            <button type="submit" class="btn btn-success" style="background-color: #4CAF50; border: none; padding: 10px 20px; border-radius: 8px;">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </div>

        {{-- Main Container (Meniru Card Putih) --}}
        <div class="section-detail" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; gap: 30px;">

            <div class="subsection-main" style="flex: 2;">
                <h4 style="margin-bottom: 20px;">Informasi Paket & Pemesan</h4>

                <div class="kolom-input" style="display: flex; gap: 20px; margin-bottom: 15px;">
                    <div class="input-item" style="flex: 1;">
                        <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Nama Paket</label>
                        <select name="id_tiket_paket" class="form-select" style="border-radius : 8px; padding: 10px;" required>
                            <option value="">-- Pilih Paket --</option>

                            @foreach ($tiketPaket as $paket)
                                <option value="{{ $paket->id }}" 
                                    {{ $paket->id == old('id_tiket_paket', $p->id_tiket_paket) ? 'selected' : '' }}>
                                    {{ $paket->nama_paket }} (Rp{{ number_format($paket->harga, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-item" style="flex: 1;">
                        <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Jumlah Pesanan</label>
                        <input type="number" name="jumlah_pesanan" class="form-control"
                            value="{{ old('jumlah_pesanan', $p->jumlah_pesanan) }}" min="1" style="border-radius : 8px; padding: 10px;" required>
                    </div>
                </div>

                <div class="kolom-input" style="display: flex; gap: 20px; margin-bottom: 15px;">
                    <div class="input-item" style="flex: 1;">
                        <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Nama Pemesan</label>
                        <select name="id_user" class="form-select" style="border-radius : 8px; padding: 10px;" required>
                            <option value="">-- Pilih User --</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ $user->id == old('id_user', $p->id_user) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-item" style="flex: 1;">
                        <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Tanggal Pembelian</label>
                        {{-- Format tanggal/waktu untuk input datetime-local --}}
                        <input type="datetime-local" name="tanggal_pembelian" class="form-control"
                            value="{{ old('tanggal_pembelian', Carbon\Carbon::parse($p->created_at)->format('Y-m-d\TH:i')) }}" style="border-radius : 8px; padding: 10px;" required>
                    </div>
                </div>

                <div class="input-item" style="margin-bottom: 15px;">
                    <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Status Pesanan</label>
                    <select name="status_pesanan" class="form-select" style="border-radius : 8px; padding: 10px;">
                        <option value="Proses" {{ old('status_pesanan', $p->status_pesanan) == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ old('status_pesanan', $p->status_pesanan) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ old('status_pesanan', $p->status_pesanan) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

            </div>

            {{-- Kolom Info Pembayaran (di sebelah kanan) --}}
            <div class="subsection-info" style="flex: 1; border-left: 1px solid #eee; padding-left: 30px;">
                <h4 style="margin-bottom: 20px;">Rincian Pembayaran</h4>
                
                <div class="input-item" style="margin-bottom: 25px;">
                    <label class="form-label" style="font-weight: 500; margin-bottom: 5px;">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="form-select" style="border-radius : 8px; padding: 10px;" required>
                        <option value="Tunai" {{ old('metode_pembayaran', $p->metode_pembayaran) == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="Debit" {{ old('metode_pembayaran', $p->metode_pembayaran) == 'Debit' ? 'selected' : '' }}>Debit</option>
                        <option value="QRIS" {{ old('metode_pembayaran', $p->metode_pembayaran) == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        <option value="Transfer Bank" {{ old('metode_pembayaran', $p->metode_pembayaran) == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                    </select>
                </div>

                <div class="list-information" style="display: flex; justify-content: space-between; padding: 10px 0; border-top: 1px solid #eee;">
                    <label class="form-label" style="font-weight: 500; margin: 0;">Subtotal Paket</label>
                    {{-- Ini akan diisi oleh JS, diupdate saat paket/jumlah berubah --}}
                    <input type="text" id="subtotal_input" class="value-item" style="border: none; width: fit-content; text-align: right; font-weight: 600;" readonly>
                    {{-- Nilai Subtotal (tanpa pajak) juga perlu dikirim jika database memerlukannya --}}
                    <input type="hidden" name="harga_paket_subtotal" value="{{ $p->jumlah_pesanan * ($p->tiketPaket->harga ?? 0) }}"> 
                </div>

                <div class="list-information" style="display: flex; justify-content: space-between; padding: 10px 0; border-top: 1px solid #eee;">
                    <label class="form-label" style="font-weight: 500; margin: 0;">Pajak (10%)</label>
                    {{-- Ini akan diisi oleh JS --}}
                    <input type="text" id="pajak_output" class="value-item" style="border: none; width: fit-content; text-align: right; font-weight: 600;" readonly>
                </div>

                <div class="list-information" style="display: flex; justify-content: space-between; padding: 15px 0; border-top: 2px solid #333;">
                    <label class="form-label fw-bold" style="font-weight: 700; margin: 0; font-size: 1.1em;">TOTAL PEMBAYARAN</label>
                    {{-- Ini akan diisi oleh JS --}}
                    <input type="text" id="total_output" class="value-item fw-bold" style="border: none; width: fit-content; text-align: right; font-weight: 700; color: #4CAF50; font-size: 1.1em;" readonly>
                    
                    {{-- Input Hidden untuk mengirim TOTAL nilai numerik ke Controller --}}
                    <input type="hidden" name="total_pembayaran" id="total_hidden" value="{{ $p->total_pembayaran }}">
                </div>
            </div>
        </div>
    </form>
</div>
@endsection