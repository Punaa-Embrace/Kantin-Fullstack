@props(['tenant'])

<a href="{{ route('student.tenants.show', $tenant->slug) }}" class="block group">
    <div
        class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden">
        {{-- Tenant's Logo/Image --}}
        <div class="relative">
            <img class="w-full h-52 object-cover"
                src="{{ $tenant->getFirstMediaUrl('photo') ?: asset('images/no-img.jpg') }}"
                alt="{{ $tenant->name }}">
            {{-- Placeholder for future 'open/closed' status or rating --}}
            <div
                class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm text-sm font-semibold px-3 py-1 rounded-full">
                @if ($tenant->is_open)
                    <span class="text-green-600">Buka</span>
                @else
                    <span class="text-red-600">Tutup</span>
                @endif
            </div>
        </div>

        {{-- Tenant's Info --}}
        <div class="p-4">
            <div class="flex items-center gap-2">
                <p class="text-md font-bold text-green-700 group-hover:underline">{{ $tenant->name }}</p>
                <span class="text-gray-400">•</span>

                <p class="text-md font-medium text-gray-800">
                    @if ($tenant->building->name == 'Gedung Utama')
                        {{ 'GU' }}
                    @elseif ($tenant->building->name == 'Gedung RTF')
                        {{ 'RTF' }}
                    @else
                        {{ $tenant->building->name }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</a>
