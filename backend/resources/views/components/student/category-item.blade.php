@props([
    'category',
    'href' => '#', 
    'active' => false 
])

@php
    $baseClasses = 'block group text-center p-3 bg-white rounded-xl transition-all duration-200 hover:shadow-lg flex-shrink-0 w-32 h-32 flex flex-col items-center justify-center';
    
    $activeClasses = $active ? 'ring-2 ring-green-600' : '';

    $textClasses = $active ? 'text-green-700' : 'text-gray-700';
@endphp

<a href="{{ $href }}" {{ $attributes->class([$baseClasses, $activeClasses]) }}>
    <img class="h-14 w-14 object-contain" 
         src="{{ $category->getFirstMediaUrl('category_photo') ?: asset('images/no-img.jpg') }}" 
         alt="{{ $category->name }}">
    <span class="mt-2 font-semibold text-sm {{ $textClasses }}">
        {{ $category->name }}
    </span>
</a>