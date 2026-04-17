@props([
    'color' => 'neutral', // primary, secondary, accent, neutral, info, success, warning, danger
])

@php
    $colors = [
        'primary' => 'bg-primary/10 text-primary',
        'secondary' => 'bg-secondary/10 text-secondary',
        'accent' => 'bg-accent/10 text-accent',
        'neutral' => 'bg-default-100 text-default-700',
        'info' => 'bg-blue-100 text-blue-700',
        'success' => 'bg-green-100 text-green-700',
        'warning' => 'bg-yellow-100 text-yellow-700',
        'danger' => 'bg-red-100 text-red-700',
        'error' => 'bg-red-100 text-red-700',
        'ghost' => 'bg-transparent text-default-600',
    ];
    $colorClass = $colors[$color] ?? 'bg-default-100 text-default-700';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium $colorClass"]) }}>
    {{ $slot }}
</span>
