@extends('layouts.app')

@section('content')

<!-- Chart.js CDN (TIDAK perlu install npm) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="konten-container" style="padding: 20px;">

    <!-- Header & Filter -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="font-size: 24px; font-weight: bold; color: #333;">Dashboard Ringkasan</h2>

        <form action="{{ route('dashboard.index') }}" method="GET" style="display: flex; gap: 10px;">
            <select name="bulan" class="input-field" style="padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                <option value="">-- Semua Bulan --</option>
                @foreach(range(1, 12) as $m)
                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                </option>
                @endforeach
            </select>
            <select name="tahun" class="input-field" style="padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                @foreach(range(date('Y'), 2023) as $y)
                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <button type="submit" class="button-primary" style="padding: 8px 15px;">Filter</button>
        </form>
    </div>

    <!-- Statistik Utama (Top Cards) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <!-- Card Pendapatan -->
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 5px solid #4CAF50;">
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;">Total Pendapatan</p>
            <h3 style="font-size: 24px; font-weight: bold; color: #333;">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
        </div>

        <!-- Card Tiket Terjual -->
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 5px solid #2196F3;">
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;">Total Tiket Terjual</p>
            <h3 style="font-size: 24px; font-weight: bold; color: #333;">{{ number_format($totalTiketTerjual ?? 0) }} <span style="font-size: 14px; font-weight: normal;">Tiket</span></h3>
        </div>

        <!-- Card Pengunjung -->
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 5px solid #FF9800;">
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;">Jumlah Pengunjung</p>
            <h3 style="font-size: 24px; font-weight: bold; color: #333;">{{ number_format($jumlahPengunjung ?? 0) }} <span style="font-size: 14px; font-weight: normal;">Orang</span></h3>
        </div>
    </div>

    <!-- Charts Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px; margin-bottom: 40px;">
        <!-- Grafik Penjualan -->
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom: 15px; font-weight: bold;">Grafik Pendapatan ({{ request('tahun', date('Y')) }})</h4>
            <canvas id="salesChart"></canvas>
        </div>

        <!-- Grafik Pengunjung -->
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom: 15px; font-weight: bold;">Grafik Pengunjung ({{ request('tahun', date('Y')) }})</h4>
            <canvas id="visitorChart"></canvas>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="fw-semibold mb-0">Transaksi Terakhir</h6>
                <small class="text-muted">Berbagai transaksi terakhir yang terjadi</small>
            </div>
            <input type="text" class="form-control w-25" placeholder="Cari transaksi">
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted">
                        <th>Nomor Transaksi</th>
                        <th>Nama Pengunjung</th>
                        <th>Jenis Transaksi</th>
                        <th>Total Tagihan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($recentTransactions ?? [] as $t)
                    <tr>
                        <td>#{{ $t->kode }}</td>
                        <td>{{ $t->nama }}</td>
                        <td>{{ $t->jenis }}</td>
                        <td>Rp {{ number_format($t->total,0,',','.') }}</td>
                        <td>
                            <span class="badge {{ $t->status == 'Selesai' ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-secondary' }}">
                                {{ $t->status }}
                            </span>
                        </td>
                        <td>{{ $t->tanggal }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ========================= -->
<!-- DATA DARI CONTROLLER -->
<!-- ========================= -->
<script type="application/json" id="chart-data">
    {
        labels: @json($months),
        pendapatan: @json($dataPendapatanChart),
        pengunjung: @json($dataPengunjungChart)
    }
</script>

<!-- ========================= -->
<!-- CHART INITIALIZATION -->
<!-- ========================= -->
<script>
    document.addEventListener("DOMContentLoaded", () => {

        const chartData = JSON.parse(
            document.getElementById("chart-data").textContent
        );

        const ctx = document.getElementById("salesChart").getContext("2d");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: chartData.labels,
                datasets: [{
                        label: "Pendapatan",
                        data: chartData.revenue,
                        borderColor: "#4CAF50",
                        backgroundColor: "rgba(76,175,80,0.1)",
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: "Jumlah Order",
                        data: chartData.orders,
                        borderColor: "#2196F3",
                        backgroundColor: "rgba(33,150,243,0.1)",
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    });
</script>


@endsection