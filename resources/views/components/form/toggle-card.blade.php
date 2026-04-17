@props([
    'on' => false,
    'label' => 'Status',
    'description' => '',
    'color' => 'primary',
    'wireAction' => null,
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
    $toggleId = 'toggle-' . uniqid();
@endphp

<div class="flex items-center justify-between p-4 rounded-lg border border-border bg-default-50/50">
    <div>
        <p class="font-medium text-default-800">{{ $label }}</p>
        @if ($description)
            <p class="text-sm text-default-500">{{ $description }}</p>
        @endif
    </div>
    <div class="text-center">
        <input
            class="kt-switch {{ $colorClass }}"
            type="checkbox"
            id="{{ $toggleId }}"
            @checked($on)
            @if($wireAction) wire:click="{{ $wireAction }}" @endif
        />
        <label class="kt-label" for="{{ $toggleId }}"></label>
    </div>
</div>
