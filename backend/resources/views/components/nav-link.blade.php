@props(['href' => '#', 'active' => false])

@php
$classes = 'flex items-center px-4 py-2.5 mt-2 text-gray-600 fill-gray-600 transition-colors duration-300 transform rounded-md hover:bg-green-600 hover:text-white';
if ($active) {
    $classes .= ' bg-green-600 text-white fill-white';
}
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if (isset($icon))
        {{ $icon }}
    @endif
    <span class="mx-4 font-medium">{{ $slot }}</span>
</a>