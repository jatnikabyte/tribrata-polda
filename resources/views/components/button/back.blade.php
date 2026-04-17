@props([
    'href' => '#',
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 text-sm text-default-600 hover:text-primary transition-colors']) }}>
    <i class="iconify lucide--arrow-left text-base"></i>
    {{ $slot }}
</a>
