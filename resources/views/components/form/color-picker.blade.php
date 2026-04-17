@props([
    'name',
    'label',
    'placeholder' => 'contoh: #3b82f6',
    'hint' => null,
    'required' => false,
])

@php
    $hasError = $errors->has($name);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'w-full']) }}>
    @if ($label)
        <label class="block text-sm font-medium text-default-700 mb-1.5" for="{{ $name }}">
            {{ $label }} {!! !! $required ? '<span class="text-red-500">*</span>' : '' !!}
        </label>
    @endif

    <div class="flex items-center gap-3">
        <input
            type="color"
            id="{{ $name }}"
            name="{{ $name }}"
            class="w-12 h-10 rounded cursor-pointer @error($name) kt-input-error @enderror"
            {{ $attributes->except('class') }}
            {{ $required ? 'required' : '' }}
        >
        <input
            type="text"
            id="{{ $name }}_text"
            name="{{ $name }}_text"
            placeholder="{{ $placeholder }}"
            class="kt-input flex-1 @error($name) kt-input-error @enderror"
            {{ $attributes->except('class') }}
            {{ $required ? 'required' : '' }}
        >
    </div>

    @if ($hint && !$hasError)
        <p class="mt-1.5 text-sm text-default-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
