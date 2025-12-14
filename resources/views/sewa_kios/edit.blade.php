@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Breadcrumb --}}
    <div class="mb-3">
        <a href="{{ route('sewa_kios.index') }}">Sewa Kios</a> / Edit Sewa
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-semibold">
            Edit Sewa Tenant
        </div>

        <div class="card-body">
            <form action="{{ route('sewa_kios.update', $sewa_kio->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- Tenant --}}
                    <div class="col-md-6">
                        <label class="form-label">Tenant / Nomor Kios</label>
                        <select name="id_tenant" class="form-select" required>
                            <option value="">-- Pilih kios --</option>
                            @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->id }}"
                                    {{ $tenant->id == $sewa_kio->id_tenant ? 'selected' : '' }}>
                                    {{ $tenant->lokasi_tenant }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- User --}}
                    <div class="col-md-6">
                        <label class="form-label">Nama Pemesan</label>
                        <select name="id_user" class="form-select" required>
                            <option value="">-- Pilih User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $user->id == $sewa_kio->id_user ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal --}}
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date"
                               name="tanggal_mulai_sewa"
                               class="form-control"
                               value="{{ $sewa_kio->tanggal_mulai_sewa }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date"
                               name="tanggal_selesai_sewa"
                               class="form-control"
                               value="{{ $sewa_kio->tanggal_selesai_sewa }}"
                               required>
                    </div>

                    {{-- Metode --}}
                    <div class="col-md-6">
                        <label class="form-label">Metode Pembayaran</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $sewa_kio->{'Metode Pembayaran'} }}"
                               disabled>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran_tenant" class="form-select">
                            <option value="Menunggu" {{ $sewa_kio->status_pembayaran_tenant == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Dibayar" {{ $sewa_kio->status_pembayaran_tenant == 'Dibayar' ? 'selected' : '' }}>Dibayar</option>
                            <option value="Dibatalkan" {{ $sewa_kio->status_pembayaran_tenant == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                </div>

                <hr class="my-4">

                {{-- Perhitungan --}}
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Harga Sewa</label>
                        <input type="number"
                               id="harga"
                               name="harga_sewa_tenant"
                               class="form-control"
                               value="{{ $sewa_kio->harga_sewa_tenant }}"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Pajak (10%)</label>
                        <input type="text" id="pajak" class="form-control" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Total</label>
                        <input type="text" id="total" class="form-control" readonly>
                    </div>
                </div>

                {{-- Action --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('sewa_kios.index') }}" class="btn btn-outline-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Script Perhitungan --}}
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
