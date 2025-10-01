@extends('layouts.app')

@section('title', 'Daftar Menu')
@section('header', 'Hello, ' . auth()->user()->name . '!')

@section('content')
    <div class="container mx-auto">
        {{-- Category Filter --}}
        <section class="mb-10">
            <h2 class="text-2xl font-bold text-zinc-800 mb-4">Kategori</h2>
            <div class="flex items-center gap-3 overflow-x-auto p-4 no-scrollbar">
                {{-- "All" Category Button --}}
                <a href="{{ route('student.menus.index', ['search' => request('search')]) }}"
                    class="flex flex-col items-center justify-center p-3 bg-white rounded-xl transition-all duration-200 shadow-sm hover:shadow-lg flex-shrink-0 w-32 h-32
                      {{ !request('category') || request('category') == 'all' ? 'ring-2 ring-green-600' : 'ring-1 ring-gray-200' }}">
                    <span class="text-4xl">🍽️</span>
                    <span
                        class="mt-2 font-semibold text-sm {{ !request('category') || request('category') == 'all' ? 'text-green-700' : 'text-gray-700' }}">Semua</span>
                </a>

                {{-- Buttons for each category --}}
                @foreach ($categories as $category)
                    <x-student.category-item :category="$category" :href="route('student.menus.index', [
                        'category' => $category->slug,
                        'search' => request('search'),
                    ])" :active="request('category') == $category->slug" />
                @endforeach

            </div>
        </section>

        {{-- Menu Items Grid --}}
        <section>
            <h2 class="text-2xl font-bold text-zinc-800 mb-6">
                @if (request('category') && request('category') !== 'all')
                    Menampilkan Menu Kategori: <span
                        class="text-green-700">{{ $categories->firstWhere('slug', request('category'))->name ?? '' }}</span>
                @else
                    Semua Menu
                @endif
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @forelse ($menuItems as $item)
                    <x-student.menu-item-card :menu-item="$item" />
                @empty
                    <div class="col-span-full bg-white text-center py-16 rounded-lg shadow-sm">
                        <p class="text-gray-500 text-lg">Oops! Tidak ada menu yang cocok dengan pencarian Anda.</p>
                        <a href="{{ route('student.menus.index') }}"
                            class="mt-4 inline-block text-green-600 font-semibold hover:underline">Hapus semua filter</a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination Links --}}
            <div class="mt-10">
                {{ $menuItems->links() }}
            </div>
        </section>
    </div>
@endsection
