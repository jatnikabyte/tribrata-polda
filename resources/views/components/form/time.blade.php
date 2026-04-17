@props([
    'name',
    'label' => null,
    'hint' => null,
    'icon' => null,
    'required' => false,
])

@php
    $hasError = $errors->has($name);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'form-control w-full']) }}>
       @if ($label)
        <label class="label" for="{{ $name }}">
            <span class="label-text font-medium">{{ $label }} {!! !! $required ? '<span class="text-red-500">*</span>' : '' !!}</span>
        </label>
    @endif

    <label class="input input-bordered flex items-center gap-2 @error($name) input-error @enderror">
        @if ($icon)
            <span class="text-base-content/50">{{ $icon }}</span>
        @endif
        <input
            type="time"
            id="{{ $name }}"
            name="{{ $name }}"
            class="grow"
            {{ $attributes->except('class') }}
            {{ $required ? 'required' : '' }}
        >
    </label>

    @if ($hint && !$hasError)
        <label class="label">
            <span class="label-text-alt text-base-content/60">{{ $hint }}</span>
        </label>
    @endif

    @error($name)
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
