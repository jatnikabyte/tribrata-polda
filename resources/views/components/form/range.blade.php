@props([
    'name',
    'label' => null,
    'hint' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    'color' => 'primary', // primary, secondary, accent, info, success, warning, error
    'required' => false,
])

@php
    $hasError = $errors->has($name);
    $colorClasses = [
        'primary' => 'range-primary',
        'secondary' => 'range-secondary',
        'accent' => 'range-accent',
        'info' => 'range-info',
        'success' => 'range-success',
        'warning' => 'range-warning',
        'error' => 'range-error',
    ];
    $colorClass = $colorClasses[$color] ?? 'range-primary';
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'form-control w-full']) }}>
    @if ($label)
        <label class="label" for="{{ $name }}">
            <span class="label-text font-medium">{{ $label }} {!! !! $required ? '<span class="text-red-500">*</span>' : '' !!}</span>
        </label>
    @endif

    <input
        type="range"
        id="{{ $name }}"
        name="{{ $name }}"
        class="range {{ $colorClass }} @error($name) range-error @enderror"
        min="{{ $min }}"
        max="{{ $max }}"
        step="{{ $step }}"
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
