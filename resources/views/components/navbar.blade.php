<nav class="container">
    <div class="d-flex justify-content-between align-items-center w-100">
        <a href="{{ route('dashboard') ? route('dashboard') : '#' }}" class="text-decoration-none">
            <img src="{{ asset('images/logo-dlas.png') }}" alt="D'Las Logo" height="50">
        </a>

        <div class="d-none d-lg-flex align-items-center" style="gap: 32px;">
            <x-navbar-linked route="dashboard.index" label="Dashboard" active="dashboard" />
            <x-navbar-linked route="tiketsatuan.index" label="Tiket Satuan" />
            <x-navbar-linked route="tiket_paket.index" label="Tiket Paket" />
            <x-navbar-linked route="wahana.index" label="Wahana" />
            <x-navbar-linked route="penginapan.index" label="Penginapan" />
            <x-navbar-linked route="reservasi_fasilitas.index" label="Fasilitas" />
            <x-navbar-linked route="sewa_kios.index" label="Sewa Kios" /> 
            <x-navbar-linked route="pengunjung.index" label="Pengunjung" />
            <x-navbar-linked route="konten.penginapan.index" label="Kelola Konten" />
        </div>

        <div class="d-none d-lg-block">
            <form>
                @csrf
                <button type="submit"
                    class="btn-logout"
                    onmouseout="this.style.borderColor='#E5E7EB'; this.style.backgroundColor='#ffffff';">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M11.25 20.25C11.25 20.4489 11.171 20.6397 11.0303 20.7803C10.8897 20.921 10.6989 21 10.5 21H4.5C4.30109 21 4.11032 20.921 3.96967 20.7803C3.82902 20.6397 3.75 20.4489 3.75 20.25V3.75C3.75 3.55109 3.82902 3.36032 3.96967 3.21967C4.11032 3.07902 4.30109 3 4.5 3H10.5C10.6989 3 10.8897 3.07902 11.0303 3.21967C11.171 3.36032 11.25 3.55109 11.25 3.75C11.25 3.94891 11.171 4.13968 11.0303 4.28033C10.8897 4.42098 10.6989 4.5 10.5 4.5H5.25V19.5H10.5C10.6989 19.5 10.8897 19.579 11.0303 19.7197C11.171 19.8603 11.25 20.0511 11.25 20.25ZM21.5306 11.4694L17.7806 7.71937C17.6399 7.57864 17.449 7.49958 17.25 7.49958C17.051 7.49958 16.8601 7.57864 16.7194 7.71937C16.5786 7.86011 16.4996 8.05098 16.4996 8.25C16.4996 8.44902 16.5786 8.63989 16.7194 8.78063L19.1897 11.25H10.5C10.3011 11.25 10.1103 11.329 9.96967 11.4697C9.82902 11.6103 9.75 11.8011 9.75 12C9.75 12.1989 9.82902 12.3897 9.96967 12.5303C10.1103 12.671 10.3011 12.75 10.5 12.75H19.1897L16.7194 15.2194C16.5786 15.3601 16.4996 15.551 16.4996 15.75C16.4996 15.949 16.5786 16.1399 16.7194 16.2806C16.8601 16.4214 17.051 16.5004 17.25 16.5004C17.449 16.5004 17.6399 16.4214 17.7806 16.2806L21.5306 12.5306C21.6004 12.461 21.6557 12.3783 21.6934 12.2872C21.7312 12.1962 21.7506 12.0986 21.7506 12C21.7506 11.9014 21.7312 11.8038 21.6934 11.7128C21.6557 11.6217 21.6004 11.539 21.5306 11.4694Z" fill="#FF383C" />
                    </svg>
                </button>
            </form>
        </div>

        <button class="btn d-lg-none border-0 p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
    </div>
</nav>

<!-- Responsive -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold font-T1-SemiBold" id="mobileMenuLabel">Menu Navigasi</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body d-flex flex-column gap-3 p-4">
        <x-navbar-linked route="dashboard" label="Dashboard" active="dashboard" />
            <x-navbar-linked route="tiket.satuan" label="Tiket Satuan" />
            <x-navbar-linked route="tiket.paket" label="Tiket Paket" />
            <x-navbar-linked route="penginapan.index" label="Penginapan" />
            <x-navbar-linked route="fasilitas.index" label="Fasilitas" />
            <x-navbar-linked route="sewa.kios" label="Sewa Kios" />
            <x-navbar-linked route="pengunjung.index" label="Pengunjung" />
            <x-navbar-linked route="kelola.konten" label="Kelola Konten" />
        <hr>

        <form action="{{ Route::has('logout') ? route('logout') : '#' }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</div>