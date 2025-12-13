<!DOCTYPE html>
<html>
<head>
    <title>Admin - Tiket Paket</title>
</head>
<body>

<h1>Daftar Tiket Paket</h1>

<table border="1" cellpadding="8">
    <tr>
        <th>No</th>
        <th>Nama Paket</th>
        <th>Harga Weekday</th>
        <th>Harga Weekend</th>
        <th>Status</th>
    </tr>

    @foreach ($tiketPaket as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama_tiket_paket }}</td>
        <td>{{ $item->harga_tiket_weekday }}</td>
        <td>{{ $item->harga_tiket_weekend }}</td>
        <td>{{ $item->status_tiket }}</td>
    </tr>
    @endforeach

</table>

</body>
</html>
