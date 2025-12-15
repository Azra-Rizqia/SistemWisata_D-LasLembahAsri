@extends('layouts.app') 
{{-- Asumsi Anda menggunakan layout yang sudah ada, atau menggunakan struktur HTML penuh --}}

@section('content')

{{-- Variabel data Pesanan Tiket Paket --}}
@php
    // Ganti variabel dummy ini dengan variabel yang Anda kirim dari controller
    $p = $pesananTiket; 
    
    // Data Dummy jika $pesananTiket belum terisi atau Anda belum mengirimnya dari Controller
    if (empty($p)) {
        $p = (object)[
            'id' => 8291,
            'user' => (object)['name' => 'Kristin Watson', 'phone' => '0892017291'],
            'tiket_paket' => (object)['nama_paket' => 'Paket Hemat A', 'harga' => 20000],
            'status_pesanan' => 'Proses',
            'jumlah_pesanan' => 1,
            'total_pembayaran' => 20000,
            'metode_pembayaran' => 'Bank Negara Indonesia',
            'created_at' => Carbon\Carbon::parse('2025-08-18 08:21'),
            'qr_code_url' => 'path/to/qr_code_image.png' // Jika ada
        ];
    }

    // Penyesuaian Status untuk Class CSS
    $statusClass = strtolower(str_replace(' ', '', $p->status_pesanan ?? 'proses'));
@endphp

<style>
    /* Styling Dasar untuk Show Page (Jika Anda tidak menggunakan CSS eksternal) */
    .detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px;
    }
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .detail-header .actions a {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        margin-left: 10px;
        transition: background-color 0.3s;
    }
    .detail-header .actions .btn-edit {
        background-color: white;
        color: #666;
        border: 1px solid #e0e0e0;
    }
    .detail-header .actions .btn-hapus {
        background-color: #F44336;
        color: white;
    }
    .detail-header .actions .btn-hapus:hover {
        background-color: #D32F2F;
    }
    .detail-card-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .card-info {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .card-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }
    .item-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .detail-label {
        font-size: 0.9em;
        color: #999;
        margin-bottom: 5px;
        display: block;
    }
    .detail-value {
        font-size: 1.1em;
        font-weight: 600;
        color: #333;
    }
    .item-block h4 {
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }
    .detail-profile {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .profile-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
    .profile-name {
        font-weight: 600;
        font-size: 1.1em;
    }
    .profile-phone {
        font-size: 0.9em;
        color: #666;
    }
    .detail-header .breadcrumb a {
        color: #4CAF50;
        text-decoration: none;
    }
    .detail-header .breadcrumb span {
        color: #999;
    }
    .detail-header .breadcrumb {
        font-size: 0.9em;
        margin-bottom: 15px;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9em;
        display: inline-block;
    }
    .badge-status.proses { background-color: #E3F2FD; color: #2196F3; }
    .badge-status.selesai { background-color: #E8F5E9; color: #4CAF50; }
    .badge-status.dibatalkan { background-color: #FFEBEE; color: #F44336; }

    /* Media queries untuk responsif jika diperlukan */
    @media (max-width: 768px) {
        .card-grid, .item-grid {
            grid-template-columns: 1fr;
        }
        .detail-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .detail-header .actions {
            margin-top: 15px;
        }
    }
</style>

<div class="detail-container">
    <div class="detail-header">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('pesan_tiket_paket.index') }}">Tiket Paket</a>
                <span>/ Detail Pembelian Tiket Paket</span>
            </div>
            {{-- Bagian Judul Utama (Di sini kita tiru tata letak Paket Hemat A di bagian atas) --}}
            <div style="display: flex; align-items: center; gap: 20px;">
                <img src="path/to/paket_icon.png" alt="Paket Icon" style="width: 50px; height: 50px;">
                <div>
                    <h2 style="margin: 0; font-size: 1.5em;">{{ $p->tiket_paket->nama_paket ?? 'N/A' }}</h2>
                    <p style="color: #4CAF50; font-weight: 600;">Rp{{ number_format($p->tiket_paket->harga ?? 0, 0, ',', '.') }}</p>
                </div>
                
            </div>
        </div>
        <div class="actions">
            <a href="{{ route('pesan_tiket_paket.edit', $p->id) }}" class="btn-edit">
                Edit
            </a>
            <a href="#" class="btn-hapus">
                Hapus
            </a>
        </div>
    </div>
    
    <div class="detail-card-section">

        {{-- Section 1: Ringkasan Pemesan dan Status --}}
        <div class="card-info" style="display: flex; justify-content: space-between;">
            {{-- Status dan Info Paket --}}
            <div style="width: 40%">
                <span class="detail-label">Status Pembelian</span>
                <span class="badge-status {{ $statusClass }}">{{ $p->status_pesanan ?? 'Proses' }}</span>
            </div>

            {{-- Info Pemesan --}}
            <div style="width: 50%; display: flex; align-items: center; justify-content: flex-end;">
                <div class="detail-profile">
                    <img src="path/to/profile_pic.png" alt="Profile" class="profile-img">
                    <div>
                        <div class="profile-name">{{ $p->user->name ?? 'N/A' }}</div>
                        <div class="profile-phone">{{ $p->user->phone ?? 'N/A' }}</div>
                    </div>
                </div>
                <a href="mailto:{{ $p->user->email ?? '' }}" style="margin-left: 20px; color: #999;"><i class="fas fa-envelope"></i></a>
                <a href="tel:{{ $p->user->phone ?? '' }}" style="margin-left: 10px; color: #999;"><i class="fas fa-phone"></i></a>
            </div>
        </div>

        {{-- Section 2: Detail Transaksi --}}
        <div class="card-info">
            <div class="item-grid">
                <div>
                    <span class="detail-label">Nomor Pembelian</span>
                    <div class="detail-value">{{ $p->id }}</div>
                </div>
                <div>
                    <span class="detail-label">Jumlah Pembelian</span>
                    <div class="detail-value">{{ $p->jumlah_pesanan }}</div>
                </div>
                <div>
                    <span class="detail-label">Metode Pembayaran</span>
                    <div class="detail-value">{{ $p->metode_pembayaran ?? '-' }}</div>
                </div>
                <div>
                    <span class="detail-label">Tanggal Pemesanan</span>
                    <div class="detail-value">{{ $p->created_at->format('d F Y H:i') }}</div>
                </div>
                <div style="grid-column: 2 / 3;">
                    <span class="detail-label">Total Pembayaran</span>
                    <div class="detail-value" style="font-size: 1.3em; color: #333;">
                        Rp{{ number_format($p->total_pembayaran ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: QR Code (Jika ada) --}}
        <div class="card-info">
            <h4>QR Tiket Paket</h4>
            <div style="display: flex; align-items: center; gap: 30px;">
                <img src="{{ $p->qr_code_url ?? 'path/to/default_qr.png' }}" alt="QR Code" style="width: 150px; height: 150px; border: 1px solid #eee;">
                <button style="background-color: #eee; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; color: #333; font-weight: 500;">
                    <i class="fas fa-download"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>

@endsection