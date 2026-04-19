@extends('layouts.app')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="konten-container" style="padding: 20px;">

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
            <button type="submit" class="button-primary" style="padding: 8px 15px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Filter</button>
        </form>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 5px solid #4CAF50;">
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;">Total Pendapatan</p>
            <h3 style="font-size: 24px; font-weight: bold; color: #333;">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
        </div>

        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 5px solid #2196F3;">
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;">Total Tiket Terjual</p>
            <h3 style="font-size: 24px; font-weight: bold; color: #333;">{{ number_format($totalTiketTerjual ?? 0) }} <span style="font-size: 14px; font-weight: normal;">Tiket</span></h3>
        </div>

        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-left: 5px solid #FF9800;">
            <p style="color: #666; font-size: 14px; margin-bottom: 5px;">Jumlah Pengunjung</p>
            <h3 style="font-size: 24px; font-weight: bold; color: #333;">{{ number_format($jumlahPengunjung ?? 0) }} <span style="font-size: 14px; font-weight: normal;">Orang</span></h3>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px; margin-bottom: 40px;">
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom: 15px; font-weight: bold;">Grafik Pendapatan ({{ request('tahun', date('Y')) }})</h4>
            <div style="height: 300px;">
                <canvas id="pendapatanChart"></canvas>
            </div>
        </div>

        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="margin-bottom: 15px; font-weight: bold;">Grafik Pengunjung ({{ request('tahun', date('Y')) }})</h4>
            <div style="height: 300px;">
                <canvas id="pengunjungChart"></canvas>
            </div>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-top: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <h6 style="font-weight: 600; margin-bottom: 5px; color: #333;">Transaksi Terakhir</h6>
                <small style="color: #6c757d;">Berbagai transaksi terakhir yang terjadi</small>
            </div>
            <input type="text" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; width: 25%;" placeholder="Cari transaksi">
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="color: #6c757d; border-bottom: 1px solid #dee2e6;">
                        <th style="padding: 12px; text-align: left; font-weight: 500;">Nomor Transaksi</th>
                        <th style="padding: 12px; text-align: left; font-weight: 500;">Nama Pengunjung</th>
                        <th style="padding: 12px; text-align: left; font-weight: 500;">Jenis Transaksi</th>
                        <th style="padding: 12px; text-align: left; font-weight: 500;">Total Tagihan</th>
                        <th style="padding: 12px; text-align: left; font-weight: 500;">Status</th>
                        <th style="padding: 12px; text-align: left; font-weight: 500;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($recentTransactions ?? [] as $t)
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 12px;">
                            {{ $t->kode ?? $t->nomor_reservasi ?? $t->nomor_pesanan ?? $t->nomor_sewa ?? $t->id ?? 'N/A' }}
                        </td>
                        <td style="padding: 12px;">
                            {{ $t->nama ?? $t->nama_pemesan ?? $t->nama_penyewa ?? $t->name ?? 'Tamu' }}
                        </td>
                        <td style="padding: 12px;">
                            {{ $t->jenis ?? $t->kategori ?? 'Tidak diketahui' }}
                        </td>
                        <td style="padding: 12px;">
                            Rp {{ number_format($t->total ?? 0, 0, ',', '.') }}
                        </td>
                        <td style="padding: 12px;">
                            @php
                                $status = $t->status ?? 'Proses';
                                $badgeClass = 'bg-secondary bg-opacity-10 text-secondary';
                                
                                if ($status == 'Selesai') {
                                    $badgeClass = 'bg-success bg-opacity-10 text-success';
                                } elseif ($status == 'Dibatalkan') {
                                    $badgeClass = 'bg-danger bg-opacity-10 text-danger';
                                }
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            @if(isset($t->tanggal) || isset($t->created_at))
                                {{ \Carbon\Carbon::parse($t->tanggal ?? $t->created_at)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center; color: #6c757d;">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script type="application/json" id="chart-data">
@php
    $defaultMonths = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
    $defaultData = array_fill(0, 12, 0);
    
    $chartData = [
        'labels' => $months ?? $defaultMonths,
        'pendapatan' => $dataPendapatanChart ?? $defaultData,
        'pengunjung' => $dataPengunjungChart ?? $defaultData
    ];
@endphp
{!! json_encode($chartData) !!}
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("Initializing charts...");
        
        const chartDataElement = document.getElementById("chart-data");
        if (!chartDataElement) {
            console.error("Chart data element not found");
            return;
        }
        
        let chartData;
        try {
            chartData = JSON.parse(chartDataElement.textContent);
            console.log("Chart data loaded successfully:", chartData);
        } catch (error) {
            console.error("Error parsing chart data:", error);
            return;
        }
        
        const months = chartData.labels || ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
        const pendapatanData = chartData.pendapatan || Array(12).fill(0);
        const pengunjungData = chartData.pengunjung || Array(12).fill(0);
        
        console.log("Months:", months);
        console.log("Pendapatan data:", pendapatanData);
        console.log("Pengunjung data:", pengunjungData);
        
        const pendapatanCanvas = document.getElementById("pendapatanChart");
        if (pendapatanCanvas) {
            console.log("Creating pendapatan chart...");
            const pendapatanCtx = pendapatanCanvas.getContext("2d");
            
            pendapatanCanvas.width = pendapatanCanvas.parentElement.offsetWidth;
            pendapatanCanvas.height = 300;
            
            new Chart(pendapatanCtx, {
                type: "line",
                data: {
                    labels: months,
                    datasets: [{
                        label: "Pendapatan",
                        data: pendapatanData,
                        borderColor: "#4CAF50",
                        backgroundColor: "rgba(76, 175, 80, 0.1)",
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
            console.log("Pendapatan chart created successfully");
        } else {
            console.error("Pendapatan chart canvas not found");
        }
        
        const pengunjungCanvas = document.getElementById("pengunjungChart");
        if (pengunjungCanvas) {
            console.log("Creating pengunjung chart...");
            const pengunjungCtx = pengunjungCanvas.getContext("2d");
            
            pengunjungCanvas.width = pengunjungCanvas.parentElement.offsetWidth;
            pengunjungCanvas.height = 300;
            
            new Chart(pengunjungCtx, {
                type: "bar",
                data: {
                    labels: months,
                    datasets: [{
                        label: "Jumlah Pengunjung",
                        data: pengunjungData,
                        backgroundColor: "rgba(33, 150, 243, 0.7)",
                        borderColor: "#2196F3",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
            console.log("Pengunjung chart created successfully");
        } else {
            console.error("Pengunjung chart canvas not found");
        }
    });
</script>

<style>
    .konten-container {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    }
    
    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .bg-success {
        background-color: #d1e7dd !important;
    }
    
    .text-success {
        color: #0f5132 !important;
    }
    
    .bg-secondary {
        background-color: #e2e3e5 !important;
    }
    
    .text-secondary {
        color: #41464b !important;
    }
    
    .bg-danger {
        background-color: #f8d7da !important;
    }
    
    .text-danger {
        color: #842029 !important;
    }
    
    .bg-opacity-10 {
        opacity: 0.9;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .konten-container {
            padding: 10px;
        }
        
        div[style*="display: flex; justify-content: space-between"] {
            flex-direction: column;
            gap: 15px;
        }
        
        form[style*="display: flex; gap: 10px;"] {
            flex-direction: column;
            width: 100%;
        }
        
        .input-field, .button-primary {
            width: 100%;
        }
        
        div[style*="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr))"] {
            grid-template-columns: 1fr !important;
        }
        
        input[style*="width: 25%"] {
            width: 100% !important;
            margin-top: 10px;
        }
    }
</style>

@endsection