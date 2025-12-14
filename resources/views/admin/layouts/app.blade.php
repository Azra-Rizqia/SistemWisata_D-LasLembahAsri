<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin DLAS</title>
    <link rel="stylesheet" href="{{ asset('css/tiket_paket.css') }}">
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div class="logo">DLAS</div>
        <ul class="menu">
            <li>Dashboard</li>
            <li>Tiket Satuan</li>
            <li class="active">Tiket Paket</li>
            <li>Penginapan</li>
            <li>Fasilitas</li>
            <li>Sewa Kios</li>
            <li>Pengunjung</li>
        </ul>
    </nav>

    {{-- CONTENT --}}
    <main class="container">
        @yield('content')
    </main>

</body>
</html>
