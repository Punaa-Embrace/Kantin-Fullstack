@props(['menuItem'])

@php
    $itemForCart = [
        'id' => $menuItem->id,
        'name' => $menuItem->name,
        'price' => (float) $menuItem->price,
        'image' => $menuItem->getFirstMediaUrl('menu_item_photo') ?: asset('images/no-img.jpg'),
        'tenant_id' => $menuItem->tenant_id,
        'tenant_name' => $menuItem->tenant->name,
        'building_name' => $menuItem->tenant->building->name ?? 'N/A',
    ];
@endphp

<div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden group"
    x-data="{ quantity: $store.cart.getItemQuantity({{ $menuItem->id }}) }" x-init="$watch('$store.cart.items', () => {
        quantity = $store.cart.getItemQuantity({{ $menuItem->id }})
    })">
    {{-- Item Image --}}
    <div class="relative">
        <a href="#">
            <img class="w-full h-44 object-cover"
                src="{{ $menuItem->getFirstMediaUrl('menu_item_photo') ?: asset('images/no-img.jpg') }}"
                alt="{{ $menuItem->name }}">
        </a>
    </div>

    {{-- Item Details & Actions --}}
    <div class="p-4 flex flex-col flex-grow">
        {{-- Rating Stars --}}
        <div class="flex items-center gap-1">
            @for ($i = 0; $i < 5; $i++)
                <x-heroicon-s-star class="w-4 h-4 text-yellow-400" />
            @endfor
        </div>

        <div class="flex-grow mt-2">
            <a href="#"
                class="text-base font-bold text-zinc-800 hover:text-green-600 leading-tight block">{{ $menuItem->name }}</a>
        </div>


        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
            <div>
                <p class="text-lg font-bold text-zinc-800">
                    <span class="text-yellow-500">Rp.</span> {{ number_format($menuItem->price, 0, ',', '.') }}
                </p>
            </div>

            <div class="w-full sm:w-auto">
                <!-- Show "Add" button if item is NOT in cart -->
                <template x-if="quantity === 0">
                    <button @click="$store.cart.add({{ Js::from($itemForCart) }})"
                        class="w-full sm:w-11 h-9 bg-green-600 text-white rounded-lg flex items-center justify-center hover:bg-green-700 transition-colors">
                        <x-heroicon-o-plus class="w-5 h-5" />
                    </button>
                </template>

                <!-- Show quantity selector if item IS in cart -->
                <template x-if="quantity > 0">
                    <div x-cloak
                        class="w-full sm:w-auto flex items-center justify-center bg-green-600 rounded-lg text-white font-bold h-9">
                        <button @click="$store.cart.updateQuantity({{ $menuItem->id }}, -1)"
                            class="flex-1 sm:flex-none sm:w-10 h-full flex items-center justify-center hover:bg-green-700 rounded-l-lg transition-colors text-lg">
                            <span>-</span>
                        </button>
                        <span
                            class="flex-1 sm:flex-none sm:w-9 h-full flex items-center justify-center text-sm bg-lemon"
                            x-text="quantity"></span>
                        <button @click="$store.cart.updateQuantity({{ $menuItem->id }}, 1)"
                            class="flex-1 sm:flex-none sm:w-10 h-full flex items-center justify-center hover:bg-green-700 rounded-r-lg transition-colors text-lg">
                            <span>+</span>
                        </button>
                    </div>
                </template>
            </div>

        </div>

        <p class="text-center text-sm text-black mt-2 font-semibold">
            <a class="text-green-600"
            href="{{ route('student.tenants.show', $menuItem->tenant) }}"
            >{{ $menuItem->tenant->name }}</a> •
            {{ $menuItem->tenant->building->name ?? 'N/A' }}</p>
    </div>
</div>
