@extends('layouts.app')

@section ('content')
    <div class="container">
        <h1 class="mb-4">Daftar Penginapan</h1>

        <a href="{{ route('penginapan.store') }}" class="btn btn-primary mb-3">Tambah Penginapan</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penginapan as $item)
                    <tr>
                        <td>{{ $item->nama_penginapan }}</td>
                        <td>{{ $item->harga_penginapan }}</td>
                        <td>{{ $item->status_penginapan }}</td>
                        <td>
                            <a href="{{ route('penginapan.show', $item->id_penginapan) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('penginapan.edit', $item->id_penginapan) }}"
                                class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('penginapan.destroy', $item->id_penginapan) }}" method="POST"
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
    </div>
@endsection