@extends('layouts.auth')
@section('title', 'Daftar')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800">Daftar Akun Baru</h2>
    <p class="mt-2 text-gray-600">Buat akun untuk mulai memesan.</p>

    <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input id="name" name="name" type="text" required value="{{ old('name') }}" class="w-full mt-1 px-3 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
            <input id="email" name="email" type="email" required value="{{ old('email') }}" class="w-full mt-1 px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
            <div class="relative mt-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <span class="text-gray-500 sm:text-sm">+62</span>
                </div>
                <input id="phone" name="phone" type="tel" required value="{{ old('phone') }}" placeholder="81234567890" class="w-full pl-12 pr-3 py-2 border @error('phone') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
            </div>
            @error('phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
            <input id="password" name="password" type="password" required class="w-full mt-1 px-3 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
             @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Daftar
            </button>
        </div>
    </form>
    
    <p class="mt-6 text-center text-sm text-gray-600">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">
            Masuk di sini
        </a>
    </p>
@endsection
