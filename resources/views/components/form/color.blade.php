@props([
    'name',
    'label' => null,
    'hint' => null,
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

    <input
        type="color"
        id="{{ $name }}"
        name="{{ $name }}"
        class="input input-bordered w-20 h-12 p-1 @error($name) input-error @enderror"
        {{ $attributes->except('class') }}
        {{ $required ? 'required' : '' }}
    >

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
