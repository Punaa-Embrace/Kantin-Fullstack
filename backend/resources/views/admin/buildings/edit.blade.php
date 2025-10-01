@extends('layouts.app')

@section('title', 'Edit Gedung')
@section('header', 'Edit Gedung: ' . $building->name)

@section('content')
    <div class="container mx-auto">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Formulir Edit Gedung</h2>

            <form action="{{ route('admin.buildings.update', $building) }}" method="POST" class="space-y-6"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Gedung</label>
                    <div class="mt-1">
                        <x-input type="text" name="name" id="name" value="{{ old('name', $building->name) }}"
                            required />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <x-file-input name="image" label="Gambar Gedung" :existing="$building->getFirstMediaUrl('building_images')" />
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-300">
                    <a href="{{ route('admin.buildings.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endsection
