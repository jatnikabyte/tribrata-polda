@props(['name', 'label' => null, 'placeholder' => 'Enter phone number', 'hint' => null, 'icon' => null, 'required' => false])

@php
    $hasError = $errors->has($name);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'form-control w-full']) }}>
    @if ($label)
        <label class="label" for="{{ $name }}">
            <span class="label-text font-medium">{{ $label }} {!! !!$required ? '<span class="text-red-500">*</span>' : '' !!}</span>
        </label>
    @endif

    <label class="input input-bordered flex items-center gap-2 @error($name) input-error @enderror">
        @if ($icon)
            <span class="text-base-content/50">{{ $icon }}</span>
        @endif
        <input type="tel" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" class="kt-input @if ($icon) ps-10 @endif @error($name) kt-input-error @enderror" {{ $attributes->except('class') }}>
    </label>


    @if ($hint && !$hasError)
        <p class="mt-1.5 text-sm text-default-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
