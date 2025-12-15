@extends('layouts.app')

@section('content')
    <div class="container">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('sewa_kios.index') }}">Sewa Kios</a>
                </li>
                <li class="breadcrumb-item active">Tambah Sewa</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Sewa Tenant</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('sewa_kios.store') }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tenant / Nomor Kios</label>

                            <select name="id_tenant" class="form-select" required>
                                <option value="">-- Pilih kios --</option>

                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id }}">
                                        {{ $tenant->lokasi_tenant }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pemesan</label>
                            <select name="id_user" class="form-select" required>
                                <option value="">-- Pilih User --</option>

                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->nama_user }} ({{ $user->email_user }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai_sewa" class="form-control"
                                value="{{ old('tanggal_mulai_sewa') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai_sewa" class="form-control"
                                value="{{ old('tanggal_selesai_sewa') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-select" required>
                                <option value="Debit">Debit</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Pembayaran</label>
                            <select name="status_pembayaran_tenant" class="form-select">
                                <option value="Menunggu">Menunggu</option>
                                <option value="Dibayar">Dibayar</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-item">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran_tenant" class="form-select" style="border-radius : 32px">
                            <option value="Menunggu">Menunggu</option>
                            <option value="Dibayar">Dibayar</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>
                <div class="subsection-info">
                    <div class="input-item">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select" style="border-radius : 32px" required>
                            <option value="Debit">Debit</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>
                    <div class="list-information">
                        <label class="form-label">Harga Sewa</label>
                        <input type="text" id="harga_sewa" class="value-item" style="border: none; width: fit-content;"
                            readonly>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('sewa_kios.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                    <div class="list-information">
                        <label class="form-label fw-bold">Total</label>
                        <input type="text" id="total" class="value-item text-success" readonly>
                        <input type="hidden" name="harga_sewa_tenant" id="total_hidden">
                    </div>

                </div>
        </form>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const tarifPerMinggu = 10000;
            const pajakRate = 0.10;

            const mulai = document.querySelector('input[name="tanggal_mulai_sewa"]');
            const selesai = document.querySelector('input[name="tanggal_selesai_sewa"]');

            const harga = document.getElementById('harga_sewa');
            const pajak = document.getElementById('pajak');
            const total = document.getElementById('total');
            const totalHidden = document.getElementById('total_hidden');

            if (!mulai || !selesai) {
                console.error('Input tanggal tidak ditemukan');
                return;
            }

            function hitung() {
                if (!mulai.value || !selesai.value) return;

                const start = new Date(mulai.value);
                const end = new Date(selesai.value);

                if (end < start) return;

                const diffTime = end - start;
                const days = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const weeks = Math.max(1, Math.ceil(days / 7));

                const hargaSewa = weeks * tarifPerMinggu;
                const pajakVal = hargaSewa * pajakRate;
                const totalVal = hargaSewa + pajakVal;

                harga.value = formatRupiah(hargaSewa);
                pajak.value = formatRupiah(pajakVal);
                total.value = formatRupiah(totalVal);
                totalHidden.value = totalVal;
            }

            function formatRupiah(angka) {
                return 'Rp ' + angka.toLocaleString('id-ID');
            }

            mulai.addEventListener('change', hitung);
            selesai.addEventListener('change', hitung);
        });
        </script>

@endsection
