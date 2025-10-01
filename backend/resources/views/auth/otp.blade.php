@extends('layouts.auth')
@section('title', 'Verifikasi OTP')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800">Verifikasi OTP</h2>
    <p class="mt-2 text-gray-600">
        Kami telah mengirimkan kode 6 digit ke nomor WhatsApp Anda yang terdaftar.
    </p>

    @if (session('status'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form class="mt-8 space-y-6" action="{{ route('otp.verify') }}" method="POST">
        @csrf
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700">Kode OTP</label>
            <div class="mt-1">
                <input id="code" name="code" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="6" required
                       class="w-full px-3 py-2 border @error('code') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm text-center text-2xl tracking-[1em] focus:outline-none focus:ring-green-500 focus:border-green-500">
                @error('code')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Verifikasi
            </button>
        </div>
    </form>

    <div x-data="{ countdown: 60, canResend: false }"
         x-init="
            let timer = setInterval(() => {
                countdown--;
                if (countdown <= 0) {
                    clearInterval(timer);
                    canResend = true;
                }
            }, 1000);
         "
         class="mt-6 text-center text-sm text-gray-600"
    >
        <p x-show="!canResend">
            Tidak menerima kode? Kirim ulang dalam <strong x-text="countdown"></strong> detik.
        </p>

        <form x-show="canResend" action="{{ route('otp.resend') }}" method="POST" style="display: none;">
            @csrf
            <button type="submit" class="font-medium text-green-600 hover:text-green-500 hover:underline">
                Kirim Ulang Kode OTP
            </button>
        </form>
    </div>
@endsection
