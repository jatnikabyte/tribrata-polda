@props([
    'route' => null,
    'params' => [],
    'title' => 'Edit',
])

<a href="{{ route($route, $params) }}" wire:navigate class="kt-btn kt-btn-sm kt-btn-icon kt-btn-mono" title="{{ $title }}">
    <i class="iconify lucide--pencil text-lg"></i>
</a>
