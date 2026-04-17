@props([
    'items' => [],
])

@php
    // Always add Dashboard as first item if not already present
    $breadcrumbs = collect($items);
    if ($breadcrumbs->isEmpty() || $breadcrumbs->first()['title'] !== 'Dashboard') {
        $breadcrumbs->prepend([
            'title' => 'Dashboard',
            'url' => route('dashboard'),
            'icon' => 'lucide--home',
        ]);
    }
@endphp

<nav class="flex items-center text-sm text-default-600">
    @foreach ($breadcrumbs as $index => $breadcrumb)
        @if (!$loop->first)
            <i class="iconify lucide--chevron-right text-default-400 mx-2"></i>
        @endif

        @if ($breadcrumb['is_last'] ?? false)
            <span class="font-semibold text-default-800">{{ $breadcrumb['title'] }}</span>
        @else
            <a href="{{ $breadcrumb['url'] }}" class="hover:text-primary transition-colors flex items-center gap-2">
                @if (isset($breadcrumb['icon']) && $breadcrumb['icon'])
                    <i class="iconify {{ $breadcrumb['icon'] }} text-default-400"></i>
                @endif
                {{ $breadcrumb['title'] }}
            </a>
        @endif
    @endforeach
</nav>

@pushOnce('breadcrumbs-debug')
    <script>
        console.log('Breadcrumbs items:', @json($breadcrumbs));
    </script>
@endpushOnce
