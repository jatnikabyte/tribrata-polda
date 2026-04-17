@props([
    'href' => null,
    'icon' => null,
])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'kt-btn kt-btn-ghost']) }}>
        @if ($icon)
            <i class="iconify {{ $icon }} text-lg"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => 'kt-btn kt-btn-ghost']) }}>
        @if ($icon)
            <i class="iconify {{ $icon }} text-lg"></i>
        @endif
        {{ $slot }}
    </button>
@endif
