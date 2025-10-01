@extends('layouts.app')

@section('title', 'Pengaturan Profil')
@section('header', 'Pengaturan Profil')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">

    <!-- Profile Information Form -->
    <section class="bg-white p-6 sm:p-8 rounded-lg shadow-md">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Informasi Profil
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Perbarui informasi profil dan alamat email akun Anda.
            </p>
        </header>

        @if (session('status') === 'Profil berhasil diperbarui.')
            <div class="mt-4 bg-green-100/80 border border-green-400 text-green-700 px-4 py-3 rounded-md" role="alert">
                {{ session('status') }}
            </div>
        @endif
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Profile Photo -->
            <div>
                <x-file-input name="photo" label="Foto Profil" :existing="$user->getFirstMediaUrl('profile_photo')" />
                @error('photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <div class="mt-1">
                    <x-input type="text" name="name" id="name" :value="old('name', $user->name)" required autofocus />
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-1">
                    <x-input type="email" name="email" id="email" :value="old('email', $user->email)" required />
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                <div class="mt-1 relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 z-10">
                        <span class="text-gray-500 text-sm">+62</span>
                    </div>
                    <x-input type="tel" name="phone" id="phone" :value="old('phone', $user->phone)" required class="pl-12" placeholder="81234567890" />
                </div>
                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="flex items-center gap-4">
                <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </section>

    <!-- Update Password Form -->
    <section class="bg-white p-6 sm:p-8 rounded-lg shadow-md">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Ubah Kata Sandi
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
            </p>
        </header>
        
        @if (session('status') === 'Kata sandi berhasil diperbarui.')
            <div class="mt-4 bg-green-100/80 border border-green-400 text-green-700 px-4 py-3 rounded-md" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <!-- Current Password -->
            <div>
                <label for="update_password_current_password" class="block text-sm font-medium text-gray-700">Kata Sandi Saat Ini</label>
                <x-input type="password" name="current_password" id="update_password_current_password" required />
                @error('current_password', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="update_password_password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                <x-input type="password" name="password" id="update_password_password" required />
                @error('password', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                <x-input type="password" name="password_confirmation" id="update_password_password_confirmation" required />
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </section>
</div>
@endsection