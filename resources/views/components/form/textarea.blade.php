@props(['name', 'label' => null, 'placeholder' => '', 'rows' => 3, 'hint' => null, 'required' => false])

@php
    $hasError = $errors->has($name);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'w-full']) }}>
    @if ($label)
        <label class="block text-sm font-medium text-default-700 mb-1.5" for="{{ $name }}">
            {{ $label }} {!! !!$required ? '<span class="text-red-500">*</span>' : '' !!}
        </label>
    @endif

    <div>
        <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" class="kt-textarea @error($name) kt-textarea-error @enderror" {{ $attributes->except('class') }} {{ $required ? 'required' : '' }}>{{ old($name) ?? ($value ?? '') }}</textarea>
    </div>

    @if ($hint && !$hasError)
        <p class="mt-1.5 text-sm text-default-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
