@props([
    'on' => false,
    'label' => '',
    'color' => 'primary', // primary, success, warning, danger, info
])

@php
    $colorClasses = [
        'primary' => 'kt-switch-primary',
        'success' => 'kt-switch-success',
        'warning' => 'kt-switch-warning',
        'danger' => 'kt-switch-danger',
        'info' => 'kt-switch-info',
    ];
    $colorClass = $colorClasses[$color] ?? 'kt-switch-primary';
@endphp
<div class="text-center">
    <input class="kt-switch {{ $colorClass }}"" type="checkbox" id="switch" {{ $attributes->except('class') }} @checked($on) /><label class="kt-label" for="switch">{{ $label }}</label>
</div>
