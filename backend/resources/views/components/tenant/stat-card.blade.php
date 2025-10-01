@props(['title', 'value', 'change', 'icon'])

<div class="bg-white p-6 rounded-2xl shadow-sm flex items-start gap-4">
    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-green-100">
        {{ $icon }}
    </div>
    <div class="flex-grow">
        <p class="text-sm text-gray-500">{{ $title }}</p>
        <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>

        @if(isset($change))
        <div class="mt-1 flex items-center text-xs">
            @if ($change >= 0)
                <span class="text-green-600 flex items-center">
                    <x-heroicon-s-arrow-up class="w-4 h-4"/>
                    {{ number_format(abs($change), 1) }}%
                </span>
            @else
                <span class="text-red-600 flex items-center">
                    <x-heroicon-s-arrow-down class="w-4 h-4" />
                    {{ number_format(abs($change), 1) }}%
                </span>
            @endif
            <span class="text-gray-500 ml-1"> (30 hari)</span>
        </div>
        @endif
    </div>
</div>

