@php
    $hasIcon = !empty($icon);
    $baseClasses = 'block w-full rounded-xl border-0 py-2.5 text-gray-900 bg-white ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6';
    $paddingClass = $hasIcon ? 'pl-10' : 'px-3';
@endphp

<div 
    x-data="{
        whitelistData: {{ json_encode(json_decode($whitelist)) }}
    }"
    x-init="
        const tagify = new Tagify($refs.input, {
            whitelist: whitelistData,
            originalInputValueFormat: values => JSON.stringify(values),
            dropdown: {
                maxItems: 20,
                classname: 'tags-look',
                enabled: 0,
                closeOnSelect: false
            }
        });
        tagify.DOM.scope.classList.add(...('{{ $baseClasses }} {{ $paddingClass }}'.split(' ')));
    "
    class="relative rounded-lg"
>
    @if ($hasIcon)
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            {{ $icon }}
        </div>
    @endif

    <input 
        x-ref="input"
        type="text"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        value='{{ $value }}'
    >
</div>