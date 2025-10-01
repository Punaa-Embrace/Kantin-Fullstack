@extends('layouts.app')

@section('title', 'Manajemen Stand')
@section('header', 'Manajemen Stand')

@section('content')
    <div class="container mx-auto">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Daftar Stand</h2>
                <a href="{{ route('admin.tenants.create') }}"
                    class="inline-block px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">Tambah
                    Stand</a>
            </div>
            
            @include('partials._session-messages')

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Stand</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pengelola</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gedung</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        @forelse ($tenants as $tenant)
                            <tr>
                                <td class="px-6 py-4">
                                    <img class="h-12 w-20 object-cover rounded-md"
                                        src="{{ $tenant->getFirstMediaUrl('photo') ?: asset('images/no-img.jpg') }}"
                                        alt="{{ $tenant->name }}">
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $tenant->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $tenant->manager->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $tenant->building->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tenant->is_open ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $tenant->is_open ? 'Buka' : 'Tutup' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <a href="{{ route('admin.tenants.edit', $tenant) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                    <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Yakin ingin menghapus stand ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data stand.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $tenants->links() }}</div>
        </div>
    </div>
@endsection
