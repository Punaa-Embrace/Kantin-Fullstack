@extends('layouts.auth')
@section('title', 'Lupa Kata Sandi')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800">Lupa Kata Sandi</h2>
    <p class="mt-2 text-gray-600">Masukkan nomor WhatsApp Anda, kami akan mengirimkan kode OTP untuk reset kata sandi.</p>

    <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
        @csrf
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
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Kirim Kode OTP
            </button>
        </div>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Ingat kata sandi Anda?
        <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">
            Kembali ke halaman Masuk
        </a>
    </p>
@endsection
