@extends('layouts.app')
@section('title', 'Manajemen Menu')
@section('header', 'Manajemen Menu')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Menu</h2>
        <a href="{{ route('tenant.menu-items.create') }}" class="inline-block px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">Tambah Menu</a>
    </div>
    
    @include('partials._session-messages')
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300">
                @forelse ($menuItems as $item)
                    <tr>
                        <td class="px-4 py-3"><img class="h-12 w-16 object-cover rounded-md" src="{{ $item->getFirstMediaUrl('menu_item_photo') ?: asset('images/no-img.jpg') }}" alt="{{ $item->name }}"></td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $item->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            @foreach($item->categories as $category)
                                <span class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs font-semibold text-gray-700 mr-1 mb-1">{{ $category->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-sm"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $item->is_available ? 'Tersedia' : 'Habis' }}</span></td>
                        <td class="px-4 py-3 text-right text-sm font-medium">
                            <a href="{{ route('tenant.menu-items.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                            <form action="{{ route('tenant.menu-items.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:text-red-900">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada menu yang ditambahkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $menuItems->links() }}</div>
</div>
@endsection