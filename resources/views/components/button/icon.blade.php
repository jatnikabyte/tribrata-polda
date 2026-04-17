@props([
    'type' => 'button',
    'color' => 'ghost', // ghost, primary, secondary, accent, danger
    'size' => 'sm', // xs, sm, md
    'title' => null,
])

@php
    $colors = [
        'ghost' => 'kt-btn-ghost',
        'primary' => 'kt-btn-primary kt-btn-outline',
        'secondary' => 'kt-btn-secondary kt-btn-outline',
        'accent' => 'kt-btn-accent kt-btn-outline',
        'danger' => 'kt-btn-ghost hover:kt-btn-danger',
    ];

    $sizes = [
        'xs' => 'kt-btn-xs',
        'sm' => 'kt-btn-sm',
        'md' => '',
    ];

    $colorClass = $colors[$color] ?? 'kt-btn-ghost';
    $sizeClass = $sizes[$size] ?? 'kt-btn-sm';
@endphp

<button type="{{ $type }}" @if ($title) title="{{ $title }}" @endif {{ $attributes->merge(['class' => "kt-btn kt-btn-icon $colorClass $sizeClass"]) }}>
    {{ $slot }}
</button>
