@extends('layouts.minimal')

@section('title', 'Akun Belum Ditugaskan')

@section('content')
<div class="flex items-center justify-center h-full">
    <div class="text-center bg-white p-12 rounded-lg shadow-md max-w-2xl">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100">
            <x-heroicon-o-clock class="h-8 w-8 text-yellow-500" />
        </div>
        <h2 class="mt-6 text-2xl font-bold text-gray-900">Akun Anda Sedang Ditinjau</h2>
        <p class="mt-2 text-md text-gray-600">
            Halo, {{ auth()->user()->name }}. Akun Anda sudah terdaftar dan aktif.
        </p>
        <p class="mt-1 text-md text-gray-600">
            Saat ini, Anda hanya perlu menunggu Admin untuk mendaftarkan Anda ke stand kantin yang sesuai.
        </p>
        <div class="mt-8">
            <p class="text-sm text-gray-500">
                Silakan hubungi Admin jika Anda memiliki pertanyaan lebih lanjut.
            </p>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="mt-4 font-semibold text-green-600 hover:text-green-800">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
