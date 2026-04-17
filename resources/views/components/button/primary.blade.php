@props([
    'icon' => null,
])

<button {{ $attributes->merge(['class' => 'kt-btn kt-btn-primary']) }}>
    @if ($icon)
        <i class="iconify {{ $icon }} text-lg"></i>
    @endif
    {{ $slot }}
</button>
