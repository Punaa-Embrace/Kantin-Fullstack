@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('header', 'Edit Pengguna: ' . $user->name)

@section('content')
    <div class="container mx-auto">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Formulir Edit Pengguna</h2>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <div class="mt-1">
                        <x-input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                            required />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <div class="mt-1">
                        <x-input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            required />
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
                        <x-input type="tel" name="phone" id="phone" :value="old('phone', $user->phone)" required class="pl-12" />
                    </div>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <span @class([
                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                        'bg-red-100 text-red-800' => $user->role === 'admin',
                        'bg-blue-100 text-blue-800' => $user->role === 'tenant_manager',
                        'bg-green-100 text-green-800' => $user->role === 'student',
                    ])>
                        {{ $user->role_string }}
                    </span>
                    </td>
                    <p class="text-xs text-gray-500 mt-2">Role tidak dapat diubah setelah akun dibuat.</p>
                </div>

                <div class="border-t border-gray-300 pt-6">
                    <p class="text-sm text-gray-500 mb-4">Ubah Password (kosongkan jika tidak ingin mengubah)</p>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <div class="mt-1">
                            <x-input type="password" name="password" id="password" placeholder="••••••••" />
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                            Password Baru</label>
                        <div class="mt-1">
                            <x-input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="••••••••" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.users.index', ['role' => $user->role]) }}"
                        class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endsection
