<div class="space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
        <div class="mt-1">
            <x-input type="text" name="name" id="name" :value="old('name', $category->name ?? '')" required />
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="pt-4 border-t border-gray-300">
        <x-file-input
            name="photo"
            label="Foto Kategori"
            :existing="isset($category) ? $category->getFirstMediaUrl('category_photo') : ''"
        />
        @error('photo')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>