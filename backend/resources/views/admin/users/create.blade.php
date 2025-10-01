@extends('layouts.app')

@section('title', 'Tambah Pengelola Kantin')
@section('header', 'Tambah Pengelola Kantin Baru')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Formulir Pengelola Kantin</h2>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <div class="mt-1">
                        <x-input type="text" name="name" id="name" value="{{ old('name') }}"
                            placeholder="John Doe" required />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <div class="mt-1">
                        <x-input type="email" name="email" id="email" value="{{ old('email') }}"
                            placeholder="john.doe@example.com" required />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                    <div class="mt-1 relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 z-10">
                            <span class="text-gray-500 text-sm">+62</span>
                        </div>
                        <x-input type="tel" name="phone" id="phone" :value="old('phone')" required class="pl-12"
                            placeholder="81234567890" />
                    </div>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <x-input type="password" name="password" id="password" placeholder="••••••••" required />
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                        Password</label>
                    <div class="mt-1">
                        <x-input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="••••••••" required />
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4 border-t border-gray-300">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
