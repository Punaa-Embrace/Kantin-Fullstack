@extends('layouts.auth')
@section('title', 'Atur Kata Sandi Baru')

@section('content')
    <h2 class="text-3xl font-bold text-gray-800">Atur Kata Sandi Baru</h2>
    <p class="mt-2 text-gray-600">Silakan masukkan kata sandi baru Anda di bawah ini.</p>

    <form class="mt-8 space-y-6" action="{{ route('password.reset.update') }}" method="POST">
        @csrf
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
            <input id="password" name="password" type="password" required class="w-full mt-1 px-3 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Simpan Kata Sandi
            </button>
        </div>
    </form>
@endsection