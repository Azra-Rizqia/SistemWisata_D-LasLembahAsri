@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('sewa_kios.store') }}" method="POST">
            <div class="head-page-breadcrumb">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('sewa_kios.index') }}">Sewa Kios</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah Sewa</li>
                    </ol>
                </nav>
                <button type="submit" class="btn btn-primary">
                    Tambahkan Reservasi
                </button>
            </div>

            <div class="section-detail">
                <div class="subsection-main">

                    @csrf
                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Tenant / Nomor Kios</label>
                            <select name="id_tenant" class="form-select" style="border-radius : 32px" required>
                                <option value="">Pilih kios</option>

                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id }}">
                                        {{ $tenant->lokasi_tenant }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-item">
                            <label class="form-label">Nama Pemesan</label>
                            <select name="id_user" class="form-select" style="border-radius : 32px" required>
                                <option value="">Pilih User</option>

                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->nama_user }} ({{ $user->email_user }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="kolom-input">
                        <div class="input-item">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai_sewa" class="form-control"
                                value="{{ old('tanggal_mulai_sewa') }}" style="border-radius : 32px" required>
                        </div>
                        <div class="input-item">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai_sewa" class="form-control"
                                value="{{ old('tanggal_selesai_sewa') }}" style="border-radius : 32px" required>
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
                        <input type="hidden" name="harga_sewa_tenant" id="harga_sewa_hidden">
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
    </div>

    {{-- SCRIPT HITUNG --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tarifPerMinggu = 10000;
            const pajakRate = 0.10;

            const mulai = document.querySelector('[name="tanggal_mulai_sewa"]');
            const selesai = document.querySelector('[name="tanggal_selesai_sewa"]');

            const harga = document.getElementById('harga_sewa');
            const hargaHidden = document.getElementById('harga_sewa_hidden');
            const pajak = document.getElementById('pajak');
            const total = document.getElementById('total');

            function hitung() {
                if (!mulai.value || !selesai.value) return;

                const start = new Date(mulai.value);
                const end = new Date(selesai.value);

                if (end < start) return;

                const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                const weeks = Math.ceil(days / 7);

                const hargaSewa = weeks * tarifPerMinggu;
                const pajakVal = hargaSewa * pajakRate;
                const totalVal = hargaSewa + pajakVal;

                harga.value = rupiah(hargaSewa);
                hargaHidden.value = hargaSewa;
                pajak.value = rupiah(pajakVal);
                total.value = rupiah(totalVal);
            }

            function rupiah(num) {
                return 'Rp' + num.toLocaleString('id-ID');
            }

            mulai.addEventListener('change', hitung);
            selesai.addEventListener('change', hitung);
        });
    </script>
@endsection
