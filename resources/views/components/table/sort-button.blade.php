@props([
    'column' => null,
    'label' => null,
    'sortBy' => null,
    'sortDirection' => null,
])

<th scope="col" class="px-6 py-3 text-start text-sm font-medium text-default-500">
    <button wire:click="sort('{{ $column }}')" class="flex items-center gap-2 hover:text-primary transition-colors">
        {{ $label }}
        @if ($sortBy === $column)
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up text-primary {{ $sortDirection === 'desc' ? 'rotate-180' : '' }} transition-transform">
                <path d="m18 15-6-6-6 6"></path>
            </svg>
        @endif
    </button>
</th>
