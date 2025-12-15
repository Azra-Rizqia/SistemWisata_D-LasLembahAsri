@extends('layouts.app')

@section('content')
<div class="container">
        <form action="{{ route('sewa_kios.update', $sewa_kio->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="head-page-breadcrumb">
                {{-- Breadcrumb --}}
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('sewa_kios.index') }}">Sewa Kios</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Sewa</li>
                    </ol>
                </nav>
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </div>

            <div class="section-detail">
                <div class="subsection-main">

                    @csrf
                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Tenant / Nomor Kios</label>
                            <select name="id_tenant" class="form-select" style="border-radius : 32px" required>
                                <option value="">-- Pilih kios --</option>

                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id }}"
                                        {{ $tenant->id == $sewa_kio->id_tenant ? 'selected' : '' }}>
                                        {{ $tenant->lokasi_tenant }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-item">
                            <label class="form-label">Nama Pemesan</label>
                            <select name="id_user" class="form-select" style="border-radius : 32px" required>
                                <option value="">-- Pilih User --</option>

                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == $sewa_kio->id_user ? 'selected' : '' }}>
                                        {{ $user->nama_user }} ({{ $user->email_user }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai_sewa" class="form-control" value="{{ $sewa_kio->tanggal_mulai_sewa }}" style="border-radius : 32px" required>
                        </div>
                        <div class="input-item">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai_sewa" class="form-control" value="{{ $sewa_kio->tanggal_selesai_sewa }}" style="border-radius : 32px" required>
                        </div>
                    </div>
                    <div class="input-item">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran_tenant" class="form-select" style="border-radius : 32px">
                            <option value="Menunggu" {{ $sewa_kio->status_pembayaran_tenant == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Dibayar" {{ $sewa_kio->status_pembayaran_tenant == 'Dibayar' ? 'selected' : '' }}>Dibayar</option>
                            <option value="Dibatalkan" {{ $sewa_kio->status_pembayaran_tenant == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                </div>
                <div class="subsection-info">
                    <div class="input-item">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" style="border-radius : 32px" required>
                            <option value="Debit" {{ $sewa_kio->status_pembayaran_tenant == 'Debit' ? 'selected' : '' }}>Debit</option>
                            <option value="QRIS" {{ $sewa_kio->status_pembayaran_tenant == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                        </select>
                    </div>
                    <div class="list-information">
                        <label class="form-label">Harga Sewa</label>
                        <input type="number" id="harga" name="harga_sewa_tenant" class=" value-item" value="{{ $sewa_kio->harga_sewa_tenant }}" readonly>
                    </div>

                    <div class="list-information">
                        <label class="form-label">Pajak (10%)</label>
                        <input type="text" id="pajak" class="value-item" readonly>
                    </div>

                    <div class="list-information">
                        <label class="form-label fw-bold">Total</label>
                        <input type="text" id="total" class="value-item fw-bold text-success" readonly>
                    </div>
                </div>
        </form>
    </div>
    <script>
        function hitung() {
            let harga = parseFloat(document.getElementById('harga').value) || 0;
            let pajak = harga * 0.10;
            let total = harga + pajak;

            document.getElementById('pajak').value = pajak.toLocaleString('id-ID');
            document.getElementById('total').value = total.toLocaleString('id-ID');
        }

        document.getElementById('harga').addEventListener('input', hitung);
        hitung();
    </script>
@endsection
