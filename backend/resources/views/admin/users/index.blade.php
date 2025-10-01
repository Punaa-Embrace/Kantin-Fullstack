@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('header', 'Manajemen Pengguna')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Daftar Pengguna</h2>
                    <p class="text-sm text-gray-500">Menampilkan: <span
                            class="font-semibold">{{ \App\Models\User::getRoleOptions()[$selectedRole] ?? 'Semua' }}</span>
                    </p>
                </div>

                <div class="flex items-center gap-4 w-full sm:w-auto">
                    {{-- Role Filter Form --}}
                    <form action="{{ route('admin.users.index') }}" method="GET" x-data="{
                        submitForm(event) {
                            event.target.closest('form').submit();
                        }
                    }"
                        class="flex-grow sm:flex-grow-0">
                        <x-select name="role" :options="$roleOptions" :selected="$selectedRole" @change="submitForm" />
                    </form>

                    <a href="{{ route('admin.users.create') }}"
                        class="inline-block flex-shrink-0 px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Tambah Pengelola
                    </a>
                </div>
            </div>

            @include('partials._session-messages')

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Telepon</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span @class([
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                        'bg-red-100 text-red-800' => $user->role === 'admin',
                                        'bg-blue-100 text-blue-800' => $user->role === 'tenant_manager',
                                        'bg-green-100 text-green-800' => $user->role === 'student',
                                    ])>
                                        {{ $user->role_string }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->phone ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data
                                    pengguna yang cocok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
