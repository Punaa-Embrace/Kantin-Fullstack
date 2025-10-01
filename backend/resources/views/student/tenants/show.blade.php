@extends('layouts.app')

@section('title', $tenant->name)
@section('header', 'Hello, ' . auth()->user()->name . '!')

@section('content')
    <div class="container mx-auto">
        {{-- Header Section --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-800">
                Selamat Datang Di Stand <span class="text-green-700">{{ $tenant->name }}</span>
            </h1>
        </div>

        {{-- Tenant "Banner" --}}
        <div class="mb-10">
            <img class="w-full max-w-sm h-48 object-cover rounded-lg"
                src="{{ $tenant->getFirstMediaUrl('photo') ?: 'https://placehold.co/320x208/e2e8f0/64748b?text=Stand' }}"
                alt="{{ $tenant->name }}">
        </div>

        {{-- Menu List Section --}}
        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-zinc-800">Daftar Menu</h2>
                {{-- Optional: Add category filters here later --}}
            </div>
            {{-- Pagination Links --}}
            <div class="mt-8 mb-8">
                {{ $menuItems->links() }}
            </div>
        
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($menuItems as $item)
                    <x-student.menu-item-card :menu-item="$item" />
                @empty
                    <div class="col-span-full bg-white text-center py-10 rounded-lg shadow-sm">
                        <p class="text-gray-500">Oops! Stand ini belum memiliki menu yang tersedia.</p>
                    </div>
                @endforelse
            </div>


        </section>
    </div>
@endsection
