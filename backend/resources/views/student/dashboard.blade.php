@extends('layouts.app')

@section('title', 'Dashboard Civitas')

@section('header', 'Hello, ' . auth()->user()->name . '!')

@section('content')
    <div class="container mx-auto">
        <div>
            <!-- Banner Section -->
            <section class="mb-8">
                <x-student.banner />
            </section>

            <!-- Categories Section -->
            <section class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-zinc-800">Kategori</h2>
                    <a href="{{ route('student.menus.index') }}" class="text-yellow-500 font-medium hover:underline">Lihat Semua</a>
                </div>

                <div class="flex items-center gap-4 overflow-x-auto pb-4 no-scrollbar">
                    @foreach ($categories as $category)
                        <x-student.category-item :category="$category" :href="route('student.menus.index', [
                            'category' => $category->slug,
                            'search' => request('search'),
                        ])" :active="request('category') == $category->slug" />
                    @endforeach
                </div>
            </section>

            <!-- Famous Menu Section -->
            <section class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-zinc-800">Menu Terkenal</h2>
                    <a href="{{ route('student.menus.index') }}" class="text-yellow-500 font-medium hover:underline">Lihat Semua</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach ($famousMenuItems as $item)
                        <x-student.menu-item-card :menu-item="$item" />
                    @endforeach
                </div>
            </section>

            <!-- Recommendations Section -->
            <section>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-zinc-800">Rekomendasi Untuk Kamu</h2>
                    <a href="{{ route('student.menus.index') }}" class="text-yellow-500 font-medium hover:underline">Lihat Semua</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach ($recommendedMenuItems as $item)
                        <x-student.menu-item-card :menu-item="$item" />
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection
