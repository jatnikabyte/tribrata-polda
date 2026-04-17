@props([
    'title' => null,
])

<div class="kt-card">
    @if ($title)
        <div class="kt-card-header border-b border-border px-6 py-4">
            <h4 class="text-lg font-semibold text-default-800">{{ $title }}</h4>
        </div>
    @endif

    @if (isset($__laravel_slots['header']))
        <div class="kt-card-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-6 py-4 border-b border-border">
            {{ $header }}
        </div>
    @endif

    <div class="p-6 @if (isset($__laravel_slots['header']) || isset($__laravel_slots['footer'])) space-y-6 @else space-y-6 @endif">
        {{ $slot }}
    </div>

    @if (isset($__laravel_slots['footer']))
        <div class="px-6 py-4 border-t border-border bg-default-50/50 flex items-center justify-end gap-3">
            {{ $footer }}
        </div>
    @endif
</div>
