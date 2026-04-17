@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('pesan-tiket.store') }}" method="POST">
        @csrf

        {{-- Header + Breadcrumb --}}
        <div class="head-page-breadcrumb">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pesan-tiket.index') }}">Tiket Satuan</a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Tiket</li>
                </ol>
            </nav>
            <button type="submit" class="btn btn-primary">
                Tambahkan Tiket
            </button>
        </div>

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

        <div class="section-detail">

            {{-- Form Utama --}}
            <div class="subsection-main">

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Nama Pemesan</label>
                        <input type="text" name="nama_pemesan" class="form-control"
                            value="{{ old('nama_pemesan') }}"
                            placeholder="Masukkan nama pemesan"
                            style="border-radius:32px" required>
                    </div>

                    <div class="input-item">
                        <label class="form-label">Nama Tiket</label>
                        <input type="text" name="nama_tiket" class="form-control"
                            value="{{ old('nama_tiket') }}"
                            placeholder="Contoh: Tiket Wahana Anak"
                            style="border-radius:32px" required>
                    </div>
                </div>

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Tanggal Pembelian</label>
                        <input type="date" name="tanggal_pembelian" class="form-control"
                            value="{{ old('tanggal_pembelian', date('Y-m-d')) }}"
                            style="border-radius:32px" required>
                    </div>

                    <div class="input-item">
                        <label class="form-label">Jumlah Tiket</label>
                        <input type="number" id="jumlah_tiket" name="jumlah_tiket" class="form-control"
                            value="{{ old('jumlah_tiket', 1) }}"
                            min="1" style="border-radius:32px" required>
                    </div>
                </div>

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Harga Satuan</label>
                        <input type="number" id="harga_satuan" name="harga_satuan" class="form-control"
                            value="{{ old('harga_satuan') }}"
                            placeholder="Contoh: 25000"
                            min="0" style="border-radius:32px" required>
                    </div>

                    <div class="input-item">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran" class="form-select"
                            style="border-radius:32px" required>
                            <option value="">Pilih Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="selesai">Dibayar</option>
                            <option value="batal">Dibatalkan</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="subsection-info">
                <div class="list-information">
                    <label class="form-label">Subtotal</label>
                    <input type="text" id="subtotal_view" class="value-item" readonly value="Rp-">
                </div>

                <div class="list-information">
                    <label class="form-label">Jumlah Tiket</label>
                    <input type="text" id="jumlah_view" class="value-item" readonly value="-">
                </div>

                <hr>

                <div class="list-information">
                    <label class="form-label fw-bold">Total Pembayaran</label>
                    <input type="text" id="total_view" class="value-item text-success" readonly value="Rp-">
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Script Hitung Total --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jumlahInput = document.getElementById('jumlah_tiket');
    const hargaInput = document.getElementById('harga_satuan');
    const subtotalView = document.getElementById('subtotal_view');
    const jumlahView = document.getElementById('jumlah_view');
    const totalView = document.getElementById('total_view');

    function formatRupiah(value) {
        if (!value || value <= 0) return 'Rp-';
        return 'Rp' + parseInt(value).toLocaleString('id-ID');
    }

    function updateTotal() {
        const jumlah = parseInt(jumlahInput.value || 0);
        const harga = parseInt(hargaInput.value || 0);
        const total = jumlah * harga;

        jumlahView.value = jumlah || '-';
        subtotalView.value = formatRupiah(harga);
        totalView.value = formatRupiah(total);
    }

    jumlahInput.addEventListener('input', updateTotal);
    hargaInput.addEventListener('input', updateTotal);
    updateTotal();
});
</script>
@endsection
