@props([
    'route' => null,
    'params' => [],
    'label' => 'Tambah',
    'entityName' => null,
])

<a href="{{ route($route, $params) }}" wire:navigate class="kt-btn kt-btn-primary">
    <i class="iconify lucide--plus text-lg"></i>
    {{ $label }} {{ $entityName }} Baru
</a>
