@props(['name', 'label' => null, 'hint' => null, 'accept' => 'image/*', 'currentImage' => null, 'required' => false])

@php
    $hasError = $errors->has($name);

    // Check if file exists before showing preview
    $imageExists = false;
    if ($currentImage) {
        // Handle both full URL and relative path
        $path = $currentImage;
        if (str_contains($path, '/storage/')) {
            $path = Str::after($path, '/storage/');
        } elseif (str_contains($path, asset('storage/'))) {
            $path = Str::after($path, asset('storage/'));
        }
        $imageExists = file_exists(public_path('storage/' . $path));
    }
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'w-full']) }}
    x-data="{
        showNewPreview: false,
        newImageSrc: null,
        previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.newImageSrc = e.target.result;
                    this.showNewPreview = true;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    }">
    @if ($label)
        <label class="block text-sm font-medium text-default-700 mb-1.5" for="{{ $name }}">
            {{ $label }} {!! $required ? '<span class="text-red-500">*</span>' : '' !!}</label>
    @endif

    <input type="file" id="{{ $name }}" name="{{ $name }}" class="kt-input w-full @error($name) kt-input-error @enderror" accept="{{ $accept }}" {{ $attributes->except('class') }} {{ $required ? 'required' : '' }} @change="previewImage($event)">

    {{-- Preview for newly selected image --}}
    <div x-show="showNewPreview" x-cloak class="mt-2">
        <p class="text-sm text-default-600 mb-1">Preview gambar baru:</p>
        <img :src="newImageSrc" alt="Preview" class="w-32 h-32 object-cover rounded-lg border border-default-300">
    </div>

    @if ($hint && !$hasError)
        <p class="mt-1.5 text-sm text-default-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
    @enderror

    @if ($currentImage && $imageExists)
        <div class="mt-2" x-show="!showNewPreview">
            <p class="text-sm text-default-600 mb-1">Gambar saat ini:</p>
            <img src="{{ $currentImage }}" alt="Gambar saat ini" class="w-32 h-32 object-cover rounded-lg">
        </div>
    @elseif ($currentImage)
        <div class="mt-2" x-show="!showNewPreview">
            <div class="w-32 h-32 flex items-center justify-center rounded-lg border border-default-300 bg-default-100">
                <span class="text-sm text-default-500">File tidak ditemukan</span>
            </div>
        </div>
    @endif
</div>