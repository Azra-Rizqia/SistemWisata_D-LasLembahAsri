<h1>Data Pengunjung</h1>

@foreach ($pengunjung as $item)
    <p>{{ $item->nama_user }} - {{ $item->email_user }}</p>
@endforeach
