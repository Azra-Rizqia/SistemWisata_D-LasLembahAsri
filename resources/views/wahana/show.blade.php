@extends('layouts.app')

@section('content')

<div class="px-6 sm:px-8 lg:px-12 pt-6">
    <div class="flex justify-between items-center mb-6">
        
        <div>
            <p class="text-sm text-gray-500 mb-1">
                Konten Website / 
                <span class="font-semibold text-gray-700">Detail Data Wahana Satuan</span>
            </p>
            <h1 class="text-xl font-bold text-gray-900">Detail Data Wahana Satuan</h1>
        </div>

        <div class="flex space-x-3">
            <a href="{{ route('wahana.edit', $wahana->id) }}" class="bg-green-700 hover:bg-green-800 text-white font-medium py-3 px-6 rounded-lg shadow-md flex items-center transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-7-7l-1-1m0 0l-5 5m5-5l5 5"></path></svg>
                Edit
            </a>

            <form action="{{ route('wahana.destroy', $wahana->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus wahana ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-lg shadow-md flex items-center transition duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<div class="px-6 sm:px-8 lg:px-12 pb-10">
    <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            
            <div>
                <span class="block text-sm font-semibold text-gray-700 mb-2">Id_Wahana</span>
                <p class="text-lg font-bold text-gray-900">{{ $wahana->id }}</p>
            </div>

            <div>
                <span class="block text-sm font-semibold text-gray-700 mb-2">Nama Wahana</span>
                <p class="text-lg font-bold text-gray-900">{{ $wahana->nama }}</p>
            </div>

            <div>
                <span class="block text-sm font-semibold text-gray-700 mb-2">Harga</span>
                <p class="text-lg font-bold text-gray-900">Rp{{ number_format($wahana->harga, 0, ',', '.') }}</p>
            </div>

            <div>
                <span class="block text-sm font-semibold text-gray-700 mb-2">Status</span>
                <p class="text-lg font-bold {{ $wahana->status == 'Tersedia' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $wahana->status }}
                </p>
            </div>
            
            @if(isset($wahana->pengelola))
            <div class="col-span-1">
                <span class="block text-sm font-semibold text-gray-700 mb-2">Pengelola Wahana</span>
                <p class="text-lg font-bold text-gray-900">{{ $wahana->pengelola }}</p>
            </div>
            @endif

        </div>
        <div class="mb-8">
            <span class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat</span>
            <p class="text-gray-800 leading-relaxed">{{ $wahana->deskripsi_singkat }}</p>
        </div>

        <div class="mb-8">
            <span class="block text-sm font-semibold text-gray-700 mb-2">Tentang Wahana</span>
            <p class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $wahana->tentang_wahana }}</p>
        </div>

        <div class="mb-8">
            <span class="block text-sm font-semibold text-gray-700 mb-2">Kumpulan Foto</span>
            
            <div class="flex items-center space-x-4 overflow-x-auto pb-2">
                @if($wahana->gambar)
                    @php 
                        // Asumsi $wahana->gambar berisi path gambar (atau array path)
                        $photos = is_array($wahana->gambar) ? $wahana->gambar : json_decode($wahana->gambar, true) ?? ['URL_GAMBAR_1'];
                    @endphp

                    @foreach($photos as $photoPath)
                    <div class="relative w-40 h-40 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                        <img src="{{ asset('storage/' . $photoPath) }}" alt="Foto Wahana" class="object-cover w-full h-full">
                    </div>
                    @endforeach
                @else
                    <p class="text-gray-500 italic">Tidak ada foto yang tersedia.</p>
                @endif
            </div>
        </div>
        
    </div>
</div>

@endsection