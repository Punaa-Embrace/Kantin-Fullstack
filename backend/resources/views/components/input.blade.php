@props([
    'type' => 'text',
    'name',
    'id' => null,
    'value' => '',
])

@php
    $hasIcon = !empty($icon);

    $baseClasses = 'block w-full rounded-xl border-0 py-2.5 text-gray-900 bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6';

    $paddingClass = $hasIcon ? 'pl-10' : 'px-3';
    $classes = $attributes->get('class', '');
@endphp

<div class="relative rounded-lg">
    @if ($hasIcon)
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            {{ $icon }}
        </div>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        value="{{ $value }}"
        {{ $attributes->class([$classes, $baseClasses, $paddingClass]) }}
    >
</div>