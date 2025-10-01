<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Menu</label>
            <x-input type="text" name="name" id="name" :value="old('name', $menuItem->name ?? '')" required />
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
            <x-input type="number" name="price" id="price" :value="old('price', $menuItem->price ?? '')" min="0" step="100"
                required />
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="description" id="description" rows="3"
            placeholder="Deskripsi singkat tentang menu ini"
            class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm">{{ old('description', $menuItem->description ?? '') }}</textarea>
    </div>

   <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="categories" class="block text-sm font-medium text-gray-700">Kategori (bisa tambah baru)</label>
            <div class="mt-1">
                <x-tagify-input name="categories" :whitelist="$allCategories" :value="$selectedCategories ?? '[]'" />
            </div>
            @error('categories')<p class="text-red-500 text-xs mt-1">Kolom kategori wajib diisi.</p>@enderror
        </div>
        <div>
            <label for="is_available" class="block text-sm font-medium text-gray-700">Ketersediaan</label>
            <x-select name="is_available" :options="['1' => 'Tersedia', '0' => 'Habis']" :selected="old('is_available', $menuItem->is_available ?? '1')" />
            @error('is_available')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="pt-4 border-t border-gray-300">
        <x-file-input name="photo" label="Foto Menu" :existing="isset($menuItem) ? $menuItem->getFirstMediaUrl('menu_item_photo') : ''" />
        @error('photo')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
