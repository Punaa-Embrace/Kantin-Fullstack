@extends('layouts.app')

@section('title', 'Manajemen Stand Saya')
@section('header', 'Profil Stand Anda: ' . $tenant->name)

@section('content')
<div class="container mx-auto">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        
        @include('partials._session-messages')

        <h2 class="text-2xl font-bold mb-6 text-gray-800">Formulir Edit Stand</h2>

        <form action="{{ route('tenant.stand.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Stand</label>
                    <div class="mt-1">
                        <x-input type="text" name="name" id="name" value="{{ old('name', $tenant->name) }}" required />
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <div class="mt-1">
                        <textarea name="description" id="description" rows="4" class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6"
                        placeholder="Deskripsi singkat tentang stand Anda"
                        >{{ old('description', $tenant->description) }}</textarea>
                        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="building_id" class="block text-sm font-medium text-gray-700">Gedung</label>
                        <div class="mt-1">
                            <x-select name="building_id" :options="$buildings" :selected="old('building_id', $tenant->building_id)" placeholder="Pilih Gedung" />
                            @error('building_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="is_open" class="block text-sm font-medium text-gray-700">Status Stand</label>
                        <div class="mt-1">
                            <x-select name="is_open" :options="['1' => 'Buka', '0' => 'Tutup']" :selected="old('is_open', $tenant->is_open)" />
                            @error('is_open')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-300">
                    <div>
                        <x-file-input name="photo" label="Foto Stand" :existing="$tenant->getFirstMediaUrl('photo')" />
                        @error('photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <x-file-input name="qris" label="Gambar QRIS" :existing="$tenant->getFirstMediaUrl('qris')" />
                        @error('qris')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-8 pt-4 border-t border-gray-300">
                <button type="submit" class="w-full md:w-auto px-8 py-2.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection