@props(['name', 'id' => null, 'label' => 'Upload File', 'existing' => null])

<div x-data="{
    previewUrl: '{{ $existing }}',
    handleFileChange(event) {
        const file = event.target.files[0];
        if (file) {
            this.previewUrl = URL.createObjectURL(file);
        }
    }
}">
    <label for="{{ $id ?? $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <div class="mt-2 flex items-center space-x-6">
        <!-- Image Preview -->
        <div class="shrink-0">
            <template x-if="previewUrl">
                <img class="h-20 w-32 object-cover rounded-md" :src="previewUrl" alt="Current image">
            </template>
            <template x-if="!previewUrl">
                <img class="h-20 w-32 object-cover rounded-md" src="{{ asset('images/no-img.jpg') }}" alt="Placeholder">
            </template>
        </div>
        <!-- File Input Button -->
        <div>
            <input @change="handleFileChange" type="file" name="{{ $name }}" id="{{ $id ?? $name }}"
                {{ $attributes->class('hidden') }}>
            <button type="button" @click="$refs.fileInput.click()"
                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Pilih
                Gambar
            </button>
            <p class="mt-1 text-xs text-gray-500">PNG, JPG, WEBP hingga 2MB.</p>
        </div>
        <input type="file" x-ref="fileInput" name="{{ $name }}" id="{{ $id ?? $name }}" class="hidden"
            @change="handleFileChange">
    </div>
</div>
