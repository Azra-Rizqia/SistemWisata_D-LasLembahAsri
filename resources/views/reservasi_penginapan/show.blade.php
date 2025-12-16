@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Header & Breadcrumb --}}
        <div class="head-page-breadcrumb d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('reservasi_penginapan.index') }}">Reservasi Penginapan</a>
                    </li>
                    <li class="breadcrumb-item active">Detail Reservasi</li>
                </ol>
            </nav>

            {{-- Action Buttons --}}
            <div class="d-flex gap-2">
                <a href="{{ route('reservasi_penginapan.edit', $reservasi->id) }}" 
                   class="btn btn-outline-primary d-flex align-items-center gap-2" 
                   style="border-radius: 32px; padding: 10px 24px;">
                    <i class="ph ph-pencil-line"></i> Edit
                </a>
                
                <button type="button" class="btn btn-danger d-flex align-items-center gap-2" 
                        data-bs-toggle="modal" data-bs-target="#delete-{{ $reservasi->id }}"
                        style="border-radius: 32px; padding: 10px 24px;">
                    <i class="ph ph-trash"></i> Hapus
                </button>
            </div>
        </div>

        {{-- Modal Delete Component --}}
        <x-modal-delete id="delete-{{ $reservasi->id }}"
            action="{{ route('reservasi_penginapan.destroy', $reservasi->id) }}"
            title="Hapus Reservasi?"
            message="Data yang dihapus tidak dapat dikembalikan." />

        <div class="section-detail">
            <div class="row">
                
                {{-- Kolom Kiri: Informasi Utama --}}
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                        <h5 class="font-T3-SemiBold mb-4">Informasi Reservasi</h5>
                        
                        <div class="row g-4">
                            {{-- Nomor Reservasi --}}
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Nomor ID Reservasi</label>
                                <p class="font-T4-Medium text-primary mb-0">{{ $reservasi->nomor_reservasi }}</p>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Status</label>
                                <div>
                                    <span class="badge-pill px-3 py-2 font-T5-Medium
                                        {{ $reservasi->status_reservasi === 'Selesai' ? 'badge-success' : 
                                          ($reservasi->status_reservasi === 'Proses' ? 'badge-process' : 'badge-canceled') }}">
                                        {{ $reservasi->status_reservasi }}
                                    </span>
                                </div>
                            </div>

                            <hr class="my-2 opacity-50">

                            {{-- Nama Pemesan --}}
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Nama Pemesan</label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded-circle p-2">
                                        <i class="ph ph-user text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="font-T4-Medium mb-0">{{ $reservasi->user->nama_user ?? $reservasi->user->name ?? '-' }}</p>
                                        <small class="text-muted">{{ $reservasi->user->email_user ?? $reservasi->user->email ?? '-' }}</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Penginapan --}}
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Penginapan Dipilih</label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded-circle p-2">
                                        <i class="ph ph-house text-primary"></i>
                                    </div>
                                    <div>
                                        <p class="font-T4-Medium mb-0">{{ $reservasi->penginapan->nama_penginapan ?? 'Penginapan Dihapus' }}</p>
                                        {{-- Ambil info jumlah tamu dari catatan --}}
                                        <small class="text-muted">
                                            {{ $reservasi->catatan_user_reservasi ?? '1 Tamu' }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-2 opacity-50">

                            {{-- Tanggal Check-In --}}
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Check-In</label>
                                <p class="font-T4-Medium mb-0">
                                    {{ \Carbon\Carbon::parse($reservasi->tanggal_masuk)->translatedFormat('l, d F Y') }}
                                </p>
                            </div>

                            {{-- Tanggal Check-Out --}}
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Check-Out</label>
                                <p class="font-T4-Medium mb-0">
                                    {{ \Carbon\Carbon::parse($reservasi->tanggal_keluar)->translatedFormat('l, d F Y') }}
                                </p>
                            </div>

                            {{-- Durasi --}}
                            <div class="col-12">
                                <div class="alert alert-light border d-flex align-items-center gap-2 mb-0">
                                    <i class="ph ph-clock text-muted"></i>
                                    @php
                                        $in = \Carbon\Carbon::parse($reservasi->tanggal_masuk);
                                        $out = \Carbon\Carbon::parse($reservasi->tanggal_keluar);
                                        $durasi = $in->diffInDays($out);
                                    @endphp
                                    <span class="text-dark">Total Durasi Menginap: <strong>{{ $durasi }} Malam</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Rincian Pembayaran --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 16px;">
                        <h5 class="font-T3-SemiBold mb-4">Rincian Pembayaran</h5>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Metode Bayar</span>
                            <span class="font-T5-Medium">{{ $reservasi->metode_pembayaran }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Tanggal Transaksi</span>
                            <span class="font-T5-Medium">{{ \Carbon\Carbon::parse($reservasi->tanggal_pemesanan)->format('d/m/Y') }}</span>
                        </div>

                        <hr>

                        {{-- Perhitungan (Disimulasikan dari Base Harga & Pajak di DB) --}}
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Harga Sewa</span>
                            <span class="font-T5-Regular">Rp{{ number_format($reservasi->base_harga, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Pajak (10%)</span>
                            <span class="font-T5-Regular">Rp{{ number_format($reservasi->pajak, 0, ',', '.') }}</span>
                        </div>

                        <hr style="border-top: 2px dashed #ccc;">

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="font-T4-SemiBold">Total Bayar</span>
                            <span class="font-T3-Bold text-success">Rp{{ number_format($reservasi->total_pembayaran, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection