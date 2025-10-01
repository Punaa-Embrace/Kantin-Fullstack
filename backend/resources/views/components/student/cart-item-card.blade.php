<div class="bg-white rounded-xl shadow-sm p-4 flex flex-col sm:flex-row items-start gap-4">
    <!-- Item Image -->
    <img :src="item.image" :alt="item.name" class="w-full sm:w-28 h-28 object-cover rounded-lg flex-shrink-0">

    <!-- Item Details -->
    <div class="flex flex-col flex-grow">
        <h3 class="text-sm font-bold text-zinc-800" x-text="item.name"></h3>
        <p class="text-sm mb-1">
            <span class="text-zinc-800" x-text="`Rp. ${new Intl.NumberFormat('id-ID').format(item.price)}`"></span>
        </p>
        <p class="text-sm text-gray-500 mb-1">
            <span class="font-semibold text-green-700" x-text="item.tenant_name"></span> •
            <span x-text="item.building_name"></span>
        </p>

        <!-- Quantity Selector -->
        <div class="flex items-center mb-2">
            <button @click="$store.cart.updateQuantity(item.id, -1)"
                class="bg-lemon w-7 h-7 text-sm font-bold text-white hover:bg-lemon-100 rounded-l-md flex items-center justify-center">
                -
            </button>
            <input type="text" x-model.number="item.quantity" @change="$store.cart.updateQuantity(item.id, 0)"
                class="bg-lemon text-white w-8 h-7 text-sm text-center border-0 ring-0 focus:ring-0 focus:outline-none" />
            <button @click="$store.cart.updateQuantity(item.id, 1)"
                class="bg-lemon-100 w-7 h-7 text-sm font-bold text-white hover:bg-lemon-200 rounded-r-md flex items-center justify-center">
                +
            </button>
        </div>

        <!-- Notes Input with Trash Button -->
        <div class="flex items-center gap-2 w-full">
            <div class="relative flex-grow">
                {{-- MODIFIED: Bind value and listen for input to update the store --}}
                <x-input type="text"
                    name="notes"
                    placeholder="Contoh: Jangan pakai saus"
                    class="bg-yellow-400 text-black placeholder:text-black w-full ring-1 text-sm h-7 px-2 py-1 pr-8"
                    x-bind:value="item.notes"
                    @input.debounce.500ms="$store.cart.updateNotes(item.id, $event.target.value)"
                />
                <span class="bg-black rounded w-5 h-5 absolute top-1/2 right-2 transform -translate-y-1/2 flex items-center justify-center pointer-events-none">
                    <x-heroicon-o-pencil class="h-3 w-3 text-yellow-400" />
                </span>
            </div>
            <!-- Trash Button -->
            <button @click="$store.cart.remove(item.id)"
                class="text-gray-400 hover:text-red-500 transition-colors flex-shrink-0">
                <x-heroicon-o-trash class="w-6 h-6" />
            </button>
        </div>
    </div>
</div>
