@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('pesan-tiket.update', $pesanTiketSatuan) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- HEADER + ACTION --}}
        <div class="head-page-breadcrumb">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pesan-tiket.index') }}">Tiket Satuan</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Tiket</li>
                </ol>
            </nav>

            <button type="submit" class="btn btn-primary">
                Simpan Perubahan
            </button>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- CONTENT --}}
        <div class="section-detail">
            <div class="subsection-main">

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Nama Pemesan</label>
                        <input type="text" name="nama_pemesan" class="form-control"
                            value="{{ old('nama_pemesan', $pesanTiketSatuan->nama_pemesan) }}"
                            style="border-radius:32px" required>
                    </div>

                    <div class="input-item">
                        <label class="form-label">Nama Tiket</label>
                        <input type="text" name="nama_tiket" class="form-control"
                            value="{{ old('nama_tiket', $pesanTiketSatuan->nama_tiket) }}"
                            style="border-radius:32px" required>
                    </div>
                </div>

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Tanggal Pembelian</label>
                        <input type="date" name="tanggal_pembelian" class="form-control"
                            value="{{ old('tanggal_pembelian', $pesanTiketSatuan->tanggal_pembelian) }}"
                            style="border-radius:32px" required>
                    </div>

                    <div class="input-item">
                        <label class="form-label">Jumlah Tiket</label>
                        <input type="number" name="jumlah_tiket" class="form-control" min="1"
                            value="{{ old('jumlah_tiket', $pesanTiketSatuan->jumlah_tiket) }}"
                            style="border-radius:32px" required>
                    </div>
                </div>

                <div class="kolom-input">
                    <div class="input-item">
                        <label class="form-label">Harga Satuan</label>
                        <input type="number" name="harga_satuan" class="form-control" min="0"
                            value="{{ old('harga_satuan', $pesanTiketSatuan->harga_satuan) }}"
                            style="border-radius:32px" required>
                    </div>

                    <div class="input-item">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran" class="form-select"
                            style="border-radius:32px" required>
                            <option value="pending"
                                {{ old('status_pembayaran', $pesanTiketSatuan->status_pembayaran) == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="selesai"
                                {{ old('status_pembayaran', $pesanTiketSatuan->status_pembayaran) == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </div>
                </div>

            </div>

            {{-- INFO PANEL --}}
            <div class="subsection-info">
                <div class="list-information">
                    <label class="form-label">Total Pembayaran</label>
                    <input type="text"
                        class="value-item fw-bold text-success"
                        value="Rp{{ number_format($pesanTiketSatuan->total_pembayaran, 0, ',', '.') }}"
                        readonly>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
