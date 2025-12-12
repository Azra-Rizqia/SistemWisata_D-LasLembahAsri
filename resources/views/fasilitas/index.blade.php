<div class="container">
    <h1>Daftar Fasilitas</h1>
    <a href="{{ route('fasilitas.create') }}" class="btn btn-primary mb-3">Tambah Fasilitas</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fasilitas as $item)
                <tr>
                    <td>{{ $item->nama_fasilitas }}</td>
                    <td>{{ $item->harga_fasilitas }}</td>
                    <td>{{ $item->status_fasilitas }}</td>
                    <td>
                        <a href="{{ route('fasilitas.show', $item->id_fasilitas) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('fasilitas.edit', $item->id_fasilitas) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('fasilitas.destroy', $item->id_fasilitas) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>