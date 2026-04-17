@props([
    'label' => 'Cancel',
    'href' => null,
    'size' => 'md',
    'icon' => null,
])

@php
    $sizes = [
        'xs' => 'kt-btn-xs',
        'sm' => 'kt-btn-sm',
        'md' => '',
        'lg' => 'kt-btn-lg',
    ];
    $sizeClass = $sizes[$size] ?? '';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "kt-btn kt-btn-ghost $sizeClass"]) }}>
        @if ($icon)
            <span class="mr-2">{{ $icon }}</span>
        @endif
        {{ $label }}
    </a>
@else
    <button type="button" {{ $attributes->merge(['class' => "kt-btn kt-btn-ghost $sizeClass"]) }}>
        @if ($icon)
            <span class="mr-2">{{ $icon }}</span>
        @endif
        {{ $label }}
    </button>
@endif
