@props([
    'href' => '#',
    'variant' => 'primary', // primary, secondary, accent, neutral, ghost
    'size' => 'md', // xs, sm, md, lg
])

@php
    $variants = [
        'primary' => 'kt-btn-primary',
        'secondary' => 'kt-btn-secondary',
        'accent' => 'kt-btn-accent',
        'neutral' => 'kt-btn-neutral',
        'ghost' => 'kt-btn-ghost',
    ];

    $sizes = [
        'xs' => 'kt-btn-xs',
        'sm' => 'kt-btn-sm',
        'md' => '',
        'lg' => 'kt-btn-lg',
    ];

    $variantClass = $variants[$variant] ?? 'kt-btn-primary';
    $sizeClass = $sizes[$size] ?? '';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "kt-btn $variantClass $sizeClass"]) }}>
    {{ $slot }}
</a>
