@props([
    'name',
    'options' => [],
    'selected' => [],
])

@php
    // Ensure $selected is a collection for easier checking
    $selected = collect($selected);
@endphp

<div {{ $attributes->class('max-h-48 overflow-y-auto rounded-md border border-gray-300 bg-white p-4') }}>
    <div class="space-y-3">
        @forelse ($options as $value => $label)
            <div class="relative flex items-start">
                <div class="flex h-6 items-center">
                    <input
                        id="{{ $name }}-{{ $value }}"
                        name="{{ $name }}[]" {{-- The [] is crucial --}}
                        type="checkbox"
                        value="{{ $value }}"
                        @if($selected->contains($value)) checked @endif
                        class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-600"
                    >
                </div>
                <div class="ml-3 text-sm leading-6">
                    <label for="{{ $name }}-{{ $value }}" class="font-medium text-gray-900">{{ $label }}</label>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">Tidak ada pilihan tersedia.</p>
        @endforelse
    </div>
</div>