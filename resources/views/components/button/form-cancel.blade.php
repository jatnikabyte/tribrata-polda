@props([
    'route' => null,
    'label' => 'Batal',
])

<a href="{{ route($route) }}" wire:navigate class="kt-btn kt-btn-ghost">
    {{ $label }}
</a>
