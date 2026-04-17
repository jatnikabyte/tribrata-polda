@props([
    'name',
    'label' => null,
    'options' => [],
    'hint' => null,
    'required' => false,
])

@php
    $hasError = $errors->has($name);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'form-control']) }}>
    @if ($label)
        <label class="label">
            <span class="label-text font-medium">{{ $label }} {!! !! $required ? '<span class="text-red-500">*</span>' : '' !!}</span>
        </label>
    @endif

    <div class="space-y-2">
        @foreach ($options as $value => $text)
            <label class="label cursor-pointer gap-3">
                <input
                    type="radio"
                    id="{{ $name }}_{{ $value }}"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    class="radio @error($name) radio-error @enderror"
                    @if (old($name) ?? $value === $value) checked @endif
                    {{ $attributes->except('class') }}
                    {{ $required ? 'required' : '' }}
                >
                <span class="label-text @error($name) text-error @enderror">
                    {{ $text }}
                </span>
            </label>
        @endforeach
    </div>

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
