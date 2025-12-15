<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/tiket_paket.css') }}">
</head>
<body>

    @include('admin.layouts.navbar')

    <main class="container">
        @yield('content')
    </main>

</body>
</html>
