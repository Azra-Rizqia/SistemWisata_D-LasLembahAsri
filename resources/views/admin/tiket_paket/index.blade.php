@extends('admin.layouts.app')

@section('content')

<div class="header">
    <div>
        <h2>Pembelian Tiket Paketan</h2>
        <p>Kelola pembelian tiket dari pengunjung</p>
    </div>
    <button class="btn-primary">+ Tambah Pembelian</button>
</div>

{{-- CARD INFO --}}
<div class="cards">
    <div class="card">
        <p>Pendapatan Tiket Paket</p>
        <h3>Rp220.872.000</h3>
    </div>
    <div class="card">
        <p>Total Tiket Terjual</p>
        <h3>720</h3>
    </div>
</div>

{{-- TABLE --}}
<div class="table-box">
    <div class="table-header">
        <h3>Transaksi Terakhir</h3>
        <input type="text" placeholder="Cari transaksi">
    </div>

    <table>
        <thead>
            <tr>
                <th>No Reservasi</th>
                <th>Nama Pemesan</th>
                <th>Nama Paket</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>8291</td>
                <td>Kristin Watson</td>
                <td>Paket Hemat A</td>
                <td>2</td>
                <td>Rp40.000</td>
                <td><span class="badge proses">Proses</span></td>
                <td>18 Agustus 08:21</td>
                <td>✏️ 👁️ 🗑️</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
