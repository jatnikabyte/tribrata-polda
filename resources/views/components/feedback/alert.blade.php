@props([
    'type' => 'success', // success, error, warning, info
    'dismissible' => false,
])

@php
    $types = [
        'success' => 'bg-green-50 border-green-200 text-green-800',
        'error' => 'bg-red-50 border-red-200 text-red-800',
        'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
        'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    ];
    $typeClass = $types[$type] ?? 'bg-green-50 border-green-200 text-green-800';

    $iconColors = [
        'success' => 'text-green-500',
        'error' => 'text-red-500',
        'warning' => 'text-yellow-500',
        'info' => 'text-blue-500',
    ];
    $iconColor = $iconColors[$type] ?? 'text-green-500';

    $icons = [
        'success' => 'lucide--check-circle',
        'error' => 'lucide--x-circle',
        'warning' => 'lucide--alert-triangle',
        'info' => 'lucide--info',
    ];
@endphp

<div role="alert" {{ $attributes->merge(['class' => "flex items-center gap-3 p-4 rounded-lg border $typeClass"]) }}>
    <i class="iconify {{ $icons[$type] ?? 'lucide--check-circle' }} text-xl {{ $iconColor }}"></i>
    <span class="text-sm font-medium">{{ $slot }}</span>
    @if ($dismissible)
        <button type="button" class="ml-auto -mr-1 p-1 hover:opacity-70" onclick="this.parentElement.remove()">
            <i class="iconify lucide--x text-lg"></i>
        </button>
    @endif
</div>
