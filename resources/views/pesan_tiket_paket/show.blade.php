@extends('layouts.app')

@section('content')
<div class="container">

    <div class="head-page-breadcrumb">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('pesan_tiket_paket.index') }}">Daftar Pesanan</a>
                </li>
                <li class="breadcrumb-item active">Detail Transaksi Paket</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('pesan_tiket_paket.index') }}" 
               class="btn btn-secondary mb-3 d-flex align-items-center">
                Kembali
            </a>
            
            {{-- Tombol Bayar Muncul Hanya Jika Status Proses --}}
            @if($pesananTiket->status === 'Proses' && $pesananTiket->snap_token)
                <button id="pay-button" class="btn btn-primary mb-3 d-flex align-items-center">
                    <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                </button>
            @endif
        </div>
    </div>

    <div class="content-detail-page">

        {{-- Main Info --}}
        <div class="section-main-information-detail-page">

            <div class="item-main-information">
                <div class="info-item-information">
                    <p class="font-h7">{{ $pesananTiket->tiketPaket->nama_tiket_paket ?? 'Paket Tidak Ditemukan' }}</p>
                    <p class="font-T3-Regular">
                        Rp{{ number_format($pesananTiket->harga_pesanan, 0, ',', '.') }}
                    </p>
                </div>

                <p class="font-T4-Regular">Status Pembayaran</p>
                {{-- Memperbaiki badge agar tidak transparan --}}
                <span class="badge-pill font-T4-Regular 
                    {{ $pesananTiket->status === 'Selesai' ? 'badge-success' : ($pesananTiket->status === 'Proses' ? 'badge-warning' : 'badge-danger') }}"
                    style="{{ $pesananTiket->status === 'Proses' ? 'color: #856404; background-color: #fff3cd;' : '' }}">
                    {{ ucfirst($pesananTiket->status) }}
                </span>
            </div>

            <div class="item-main-information">
                <div class="info-item-information">
                    <p class="font-h7">{{ $pesananTiket->user->nama_user ?? 'User Tidak Ditemukan' }}</p>
                    <p class="font-T4-Regular">ID Transaksi: {{ $pesananTiket->kode_pesan_tiket }}</p>
                </div>
            </div>

        </div>

        {{-- Detail --}}
        <div class="d-flex justify-items-stretch gap-5 section-information-detail-page">
            <div class="kolom-input">

                <div class="info-item-information">
                    <p class="font-T4-Regular">Tanggal Pembelian</p>
                    <p class="font-T1-SemiBold">
                        {{ \Carbon\Carbon::parse($pesananTiket->tanggal_pembelian)
                            ->locale('id')
                            ->translatedFormat('d F Y') }}
                    </p>
                </div>

                <div class="info-item-information">
                    <p class="font-T4-Regular">Jumlah Tiket</p>
                    <p class="font-T1-SemiBold">
                        {{ $pesananTiket->jumlah_tiket }} Tiket
                    </p>
                </div>

                <div class="info-item-information">
                    <p class="font-T4-Regular">Total Pembayaran</p>
                    <p class="font-T1-SemiBold text-success">
                        Rp{{ number_format($pesananTiket->harga_pesanan * $pesananTiket->jumlah_tiket, 0, ',', '.') }}
                    </p>
                </div>

                <div class="info-item-information">
                    <p class="font-T4-Regular">QR Tiket</p>
                    <div class="mt-2">
                        {{-- QR Hanya muncul jika sudah Selesai/Bayar --}}
                        @if($pesananTiket->status === 'Selesai' && $pesananTiket->qr_tiket)
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ $pesananTiket->qr_tiket }}" alt="QR Code">
                        @else
                            <p class="font-T1-SemiBold text-muted italic">QR akan muncul setelah pembayaran sukses</p>
                        @endif
                    </div>
                </div>

                <div class="info-item-information">
                    <p class="font-T4-Regular">Catatan/Deskripsi</p>
                    <p class="font-T1-SemiBold">
                        {{ $pesananTiket->deskripsi_tiket ?? '-' }}
                    </p>
                </div>
                
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT MIDTRANS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    if(payButton){
        payButton.onclick = function(){
            window.snap.pay('{{ $pesananTiket->snap_token }}', {
                onSuccess: function(result){
                    alert("Pembayaran Berhasil!");
                    location.reload();
                },
                onPending: function(result){
                    alert("Menunggu Pembayaran...");
                },
                onError: function(result){
                    alert("Pembayaran Gagal!");
                }
            });
        };
    }
</script>
@endsection