{{-- This form partial will be included by create.blade.php and edit.blade.php --}}
<div class="space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nama Stand</label>
        <div class="mt-1">
            <x-input type="text" name="name" id="name" value="{{ old('name', $tenant->name ?? '') }}"
                placeholder="Contoh: Kantin Ayam Geprek" required />
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <div class="mt-1">
            <textarea name="description" id="description" rows="4"
                placeholder="Deskripsi singkat tentang stand ini, misalnya menu andalan, jam buka, dll."
                class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6">{{ old('description', $tenant->description ?? '') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700">Pengelola Kantin</label>
            <div class="mt-1">
                <x-select name="user_id" :options="$managers" :selected="old('user_id', $tenant->user_id ?? '')" placeholder="Pilih Pengelola" required />
                @error('user_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div>
            <label for="building_id" class="block text-sm font-medium text-gray-700">Gedung</label>
            <div class="mt-1">
                <x-select name="building_id" :options="$buildings" :selected="old('building_id', $tenant->building_id ?? '')"
                    placeholder="Pilih Gedung" />
                @error('building_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div>
        <label for="is_open" class="block text-sm font-medium text-gray-700">Status Stand</label>
        <div class="mt-1">
            <x-select name="is_open" :options="['1' => 'Buka', '0' => 'Tutup']" :selected="old('is_open', $tenant->is_open ?? '1')" />
            @error('is_open')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-300">
        <div>
            <x-file-input name="photo" label="Foto Stand" :existing="isset($tenant) ? $tenant->getFirstMediaUrl('photo') : ''" />
            @error('photo')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-file-input name="qris" label="Gambar QRIS" :existing="isset($tenant) ? $tenant->getFirstMediaUrl('qris') : ''" />
            @error('qris')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
