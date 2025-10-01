@props(['building'])

<a href="#" class="block group">
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden transform transition-transform hover:-translate-y-2 duration-300">
        {{-- Building Image --}}
        <div class="relative">
            <img class="w-full h-52 object-cover"
                src="{{ $building->getFirstMediaUrl('building_images') ?: asset('images/no-img.jpg') }}"
                alt="{{ $building->name }}">
        </div>

        {{-- Building Info --}}
        <div class="p-6 text-center">
            <h3 class="text-xl font-bold text-gray-800">{{ $building->name }}</h3>
            <p class="text-sm text-gray-600 mt-2">
                {{ count($building->tenants) }} Stand tersedia
            </p>
        </div>
    </div>
</a>
