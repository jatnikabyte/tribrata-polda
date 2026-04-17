@props([
    'type' => 'button',
    'variant' => 'ghost', // ghost, primary, secondary, accent, info, success, warning, danger
    'size' => 'md',
    'loading' => false,
    'loadingTarget' => null,
    'icon' => null,
])

@php
    $variants = [
        'ghost' => 'kt-btn-ghost',
        'primary' => 'kt-btn-primary',
        'secondary' => 'kt-btn-secondary',
        'accent' => 'kt-btn-accent',
        'info' => 'kt-btn-info',
        'success' => 'kt-btn-success',
        'warning' => 'kt-btn-warning',
        'danger' => 'kt-btn-danger',
    ];

    $sizes = [
        'xs' => 'kt-btn-xs',
        'sm' => 'kt-btn-sm',
        'md' => '',
        'lg' => 'kt-btn-lg',
    ];

    $variantClass = $variants[$variant] ?? 'kt-btn-ghost';
    $sizeClass = $sizes[$size] ?? '';
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "kt-btn $variantClass $sizeClass"]) }}>
    @if ($loadingTarget)
        <span class="kt-spinner kt-spinner-sm" wire:loading wire:target="{{ $loadingTarget }}"></span>
    @elseif ($loading)
        <span class="kt-spinner kt-spinner-sm"></span>
    @endif

    <span @if ($loadingTarget) wire:loading.remove wire:target="{{ $loadingTarget }}" @elseif ($loading) class="hidden" @endif>
        @if ($icon)
            <span class="mr-2">{{ $icon }}</span>
        @endif
        {{ $slot }}
    </span>
</button>
