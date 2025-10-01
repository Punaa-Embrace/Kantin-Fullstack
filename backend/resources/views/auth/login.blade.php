@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800">Masuk</h2>
    <p class="mt-2 text-gray-600">Silakan isi formulir ini untuk masuk.</p>
    
    <!-- Session Status Messages -->
    @if (session('status'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            {{ session('status') }}
        </div>
    @endif
     @if (session('error'))
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
            <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                       class="w-full px-3 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
            <div class="mt-1">
                <input id="password" name="password" type="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="text-sm">
                <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500">
                    Lupa kata sandi?
                </a>
            </div>
        </div>

        <div>
            <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Masuk
            </button>
        </div>
    </form>
    
    <p class="mt-6 text-center text-sm text-gray-600">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500">
            Daftar di sini
        </a>
    </p>
@endsection