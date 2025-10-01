@extends('layouts.app')

@section('title', 'Daftar Stand Kantin')
@section('header', 'Hello, ' . auth()->user()->name . '!')

@section('content')
    <div class="container mx-auto" x-data="{ selectedBuilding: 'all' }">
        {{-- Header Section --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-800">Ingin Pesan Makanan di Stand Mana?</h1>
            <p class="text-gray-600 mt-1">Pilih gedung untuk melihat stand yang tersedia.</p>
        </div>

        {{-- Building Filter Buttons --}}
        <div class="flex items-start gap-4 overflow-x-auto pb-4 mb-8 no-scrollbar">
            {{-- Buttons for each building --}}
            @foreach ($buildings as $building)
                <div @click="selectedBuilding = '{{ $building->id }}'" class="cursor-pointer group text-center flex-shrink-0 w-64">
                    <img class="w-full aspect-[3/2] object-cover rounded-xl mb-3 shadow-md group-hover:shadow-lg transition-all"
                         :class="{'ring-2 ring-offset-2 ring-green-600': selectedBuilding == '{{ $building->id }}'}"
                         src="{{ $building->getFirstMediaUrl('building_images') ?: asset('images/no-img.jpg') }}"
                         alt="{{ $building->name }}">
                    <div :class="{
                            'bg-green-600 text-white': selectedBuilding == '{{ $building->id }}',
                            'bg-white text-black group-hover:bg-gray-100': selectedBuilding != '{{ $building->id }}'
                        }"
                        class="px-5 py-2 rounded-xl font-semibold text-sm whitespace-nowrap transition-colors duration-200 shadow-sm">
                        {{ $building->name }}
                    </div>
                </div>
            @endforeach
        </div>


        {{-- Tenant List --}}
        <div class="space-y-10">
            @foreach ($buildings as $building)
                {{-- Each building section is wrapped in an Alpine.js conditional render --}}
                <section x-show="selectedBuilding === 'all' || selectedBuilding == '{{ $building->id }}'" x-transition>
                    <h2 class="text-2xl font-bold text-zinc-800 mb-4 border-b-2 border-green-200 pb-2">
                        {{ $building->name }}
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($building->tenants as $tenant)
                            <x-student.tenant-card :tenant="$tenant" />
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    </div>
@endsection
