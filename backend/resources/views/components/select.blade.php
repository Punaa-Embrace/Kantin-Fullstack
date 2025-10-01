@props([
    'name',
    'id' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Pilih salah satu...',
])

@php
    // These classes are designed to match the x-input component, with extra right-padding for the dropdown arrow.
    $baseClasses = 'block w-full rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 bg-white ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6';
@endphp

<select
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    {{ $attributes->class($baseClasses) }}
>
    {{-- The default, non-selectable placeholder option --}}
    <option value="" disabled {{ is_null($selected) || $selected === '' ? 'selected' : '' }}>
        {{ $placeholder }}
    </option>

    {{-- Loop through the provided options --}}
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>