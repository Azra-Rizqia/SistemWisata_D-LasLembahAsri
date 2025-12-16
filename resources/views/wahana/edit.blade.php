@extends('layouts.app')

@section('content')

<div class="px-6 sm:px-8 lg:px-12 pt-6">
    <div class="flex justify-between items-center mb-6">
        
        <div>
            <p class="text-sm text-gray-500 mb-1">
                Konten Website / 
                <span class="font-semibold text-gray-700">Edit Data Wahana Satuan</span>
            </p>
            <h1 class="text-xl font-bold text-gray-900">Edit Data Wahana Satuan</h1>
        </div>

        <div>
            <button type="submit" form="editWahanaForm" class="bg-green-700 hover:bg-green-800 text-white font-medium py-3 px-6 rounded-lg shadow-md transition duration-150">
                Simpan Tiket Wahana Satuan
            </button>
        </div>
    </div>
</div>

<div class="px-6 sm:px-8 lg:px-12 pb-10">
    <form id="editWahanaForm" action="{{ route('wahana.update', $wahana->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-lg border border-gray-100">
        @csrf
        @method('PUT') <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Id_Wahana</label>
            <p class="text-xl font-bold text-gray-900">{{ $wahana->id }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <div>
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">Nama Wahana</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $wahana->nama) }}" required 
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3">
                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">Harga</label>
                <input type="number" name="harga" id="harga" value="{{ old('harga', $wahana->harga) }}" required 
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3">
                @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <select name="status" id="status" required 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3">
                    <option value="Tersedia" {{ old('status', $wahana->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Tidak Tersedia" {{ old('status', $wahana->status) == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>
                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="mb-8">
            <label for="deskripsi_singkat" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat</label>
            <input type="text" name="deskripsi_singkat" id="deskripsi_singkat" value="{{ old('deskripsi_singkat', $wahana->deskripsi_singkat) }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3">
            @error('deskripsi_singkat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-8">
            <label for="tentang_wahana" class="block text-sm font-semibold text-gray-700 mb-2">Tentang Wahana</label>
            <textarea name="tentang_wahana" id="tentang_wahana" rows="6"
                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-3">{{ old('tentang_wahana', $wahana->tentang_wahana) }}</textarea>
            @error('tentang_wahana') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-8">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Kumpulan Foto</label>
            
            <div class="flex items-center space-x-4 overflow-x-auto pb-2">
                
                @if($wahana->gambar)
                    @php 
                        $existingPhotos = json_decode($wahana->gambar, true) ?? [
                            'URL_GAMBAR_1', // Ganti dengan path gambar nyata
                            'URL_GAMBAR_2', 
                            'URL_GAMBAR_3'
                        ];
                    @endphp

                    @foreach($existingPhotos as $photoPath)
                    <div class="relative w-40 h-40 flex-shrink-0 rounded-lg overflow-hidden border border-gray-200 shadow-sm group">
                        <button type="button" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition duration-300 z-10">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        <img src="{{ asset('storage/' . $photoPath) }}" alt="Foto Wahana" class="object-cover w-full h-full">
                    </div>
                    @endforeach
                @endif
                
                <label for="new_gambar" class="w-40 h-40 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-150 flex-shrink-0">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <span class="mt-2 text-sm text-gray-600">Unggah gambar</span>
                    <input type="file" name="gambar[]" id="new_gambar" multiple class="hidden" accept="image/*">
                </label>
            </div>
            @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        
    </form>
</div>

@endsection