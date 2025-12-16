<div class="mb-4">

    <div class="d-flex justify-content-between align-items-center border-bottom pb-2">

        {{-- Sub Menu --}}
        <div class="d-flex gap-4">
            <x-navbar-linked route="penginapan.index" label="Penginapan" />
            <x-navbar-linked route="fasilitas.index" label="Fasilitas" />
            <x-navbar-linked route="wahana.index" label="Tiket Wahana Satuan" active="wahana" />
            <x-navbar-linked route="tiket.paket" label="Tiket Paket" />
            <x-navbar-linked route="sewa_kios.index" label="Sewa Kios" />
        </div>

        {{-- Action Button --}}
        <a href="{{ route('wahana.create') }}"
           class="btn btn-success rounded-pill px-4">
            Tambah Tiket Satuan
        </a>

    </div>
</div>
