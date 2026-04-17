@props(['name', 'label' => null, 'value' => '1', 'checked' => false, 'hint' => null, 'required' => false])

@php
    $hasError = $errors->has($name);
    $isChecked = $checked || old($name) == $value;
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'flex items-start gap-3']) }}>
    <input type="checkbox" id="{{ $name }}" name="{{ $name }}" value="{{ $value }}" class="kt-checkbox mt-0.5 @error($name) kt-checkbox-error @enderror" @checked($isChecked) {{ $attributes->except('class') }} {{ $required ? 'required' : '' }}>
    <div class="flex flex-col">
        <label for="{{ $name }}" class="text-sm text-default-700 @error($name) text-red-500 @enderror cursor-pointer">
            {{ $label ?? $slot }} {!! !! $required ? '<span class="text-red-500">*</span>' : '' !!}
        </label>

        @if ($hint && !$hasError)
            <p class="text-sm text-default-500 mt-0.5">{{ $hint }}</p>
        @endif

        @error($name)
            <p class="text-sm text-red-500 mt-0.5">{{ $message }}</p>
        @enderror
    </div>
</div>
