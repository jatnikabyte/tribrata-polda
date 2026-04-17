@props([
    'dismissible' => true,
])

@php
    $iconMap = [
        'success' => 'lucide--check-circle',
        'error' => 'lucide--alert-circle',
        'info' => 'lucide--info',
        'warning' => 'lucide--alert-triangle',
    ];

    $colorMap = [
        'success' => 'green',
        'error' => 'red',
        'info' => 'blue',
        'warning' => 'yellow',
    ];
@endphp

@php
    $messageTypes = ['success', 'error', 'info', 'warning'];
    foreach ($messageTypes as $type) {
        if (session($type)) {
            $icon = $iconMap[$type];
            $color = $colorMap[$type];
            $message = session($type);
            break;
        }
    }
@endphp

@if (isset($message))
    <div x-data="{ show: true }" class="mb-6 p-4 rounded-lg border border-{{ $color }}-200 bg-{{ $color }}-50">
        <div class="flex items-center gap-3 text-{{ $color }}-800">
            <i class="iconify {{ $icon }} text-xl flex-shrink-0"></i>
            <span class="flex-1">{{ $message }}</span>
            
            @if ($dismissible)
                <button @click="show = false" class="flex-shrink-0 text-{{ $color }}-600 hover:text-{{ $color }}-800 transition-colors">
                    <i class="iconify lucide--x"></i>
                </button>
            @endif
        </div>
    </div>
@endif
