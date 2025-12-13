@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="head-page">
            <div class="headline">
                <h1 class="font-h1">Persewaan Kios</h1>
                <p class="font-T3-Regular">Kelola Reservasi penginapan dari pengunjung</p>
            </div>
            <a href="{{ route('sewa_kios.create') }}" class="btn btn-primary mb-3">Tambah Sewa</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="statistics">
            <div class="card-statistic">
                <div class="icon-card-statistic1">Icon</div>
                <div class="content-statistic">
                    <p class="font-T5-Regular">Pendapatan Penyewaan Kios</p>
                    <p class="font-T1-SemiBold">Rp{{ number_format($totalPendapatan,0,',','.') }}</p>
                </div>
            </div>
            <div class="card-statistic">
                <div class="icon-card-statistic2">Icon</div>
                <div class="content-statistic">
                    <p class="font-T5-Regular">Total Transaksi Sewa</p>
                    <p class="font-T1-SemiBold">{{ $totalData }}</p>
                </div>
            </div>
        </div>

        {{-- <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fasilitas as $item)
                    <tr>
                        <td>{{ $item->nama_fasilitas }}</td>
                        <td>{{ $item->harga_fasilitas }}</td>
                        <td>{{ $item->status_fasilitas }}</td>
                        <td>
                            <a href="{{ route('fasilitas.show', $item->id_fasilitas) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('fasilitas.edit', $item->id_fasilitas) }}"
                                class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('fasilitas.destroy', $item->id_fasilitas) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="dropdown mt-4">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown button
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div> --}}

        <!-- Button trigger modal -->
        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal hsaahahahahahaahha
        </button> --}}

        <!-- Modal -->
        {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
