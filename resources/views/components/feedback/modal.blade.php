@props([
    'id' => 'confirm-modal',
    'title',
    'description' => null,
    'type' => 'error', // error, warning, info, success
])

@php
    $styles = [
        'error' => [
            'icon_class' => 'text-red-500 bg-red-100',
            'icon' => 'lucide--alert-triangle',
        ],
        'warning' => [
            'icon_class' => 'text-yellow-500 bg-yellow-100',
            'icon' => 'lucide--alert-circle',
        ],
        'info' => [
            'icon_class' => 'text-blue-500 bg-blue-100',
            'icon' => 'lucide--info',
        ],
        'success' => [
            'icon_class' => 'text-green-500 bg-green-100',
            'icon' => 'lucide--check-circle',
        ],
    ];
    $s = $styles[$type] ?? $styles['error'];
@endphp

<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" {{ $attributes->whereStartsWith('wire:click') }}>
    <div class="bg-card rounded-xl shadow-xl max-w-md w-full p-6 border border-border">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-full {{ $s['icon_class'] }} flex items-center justify-center shrink-0">
                <i class="iconify {{ $s['icon'] }} text-2xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-lg text-default-800">{{ $title }}</h3>
                @if ($description)
                    <p class="mt-2 text-sm text-default-600">{{ $description }}</p>
                @endif
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-3">
            {{ $slot }}
        </div>
    </div>
</div>
