@props(['breadcrumbs' => []])

<div {{ $attributes->merge(['class' => 'flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6']) }}>
    <ol class="kt-breadcrumb">
        <li class="kt-breadcrumb-item">
            <a wire:navigate href="{{ route('dashboard') }}" class="kt-breadcrumb-link"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house" aria-hidden="true">
                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                    <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                </svg></a>
        </li>
        @foreach ($breadcrumbs as $index => $breadcrumb)
            <li class="kt-breadcrumb-separator">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right" aria-hidden="true">
                    <path d="m9 18 6-6-6-6"></path>
                </svg>
            </li>
            <li class="kt-breadcrumb-item">
                @if ($breadcrumb['is_last'] ?? false)
                    <span class="kt-breadcrumb-page">{{ $breadcrumb['label'] }}</span>
                @else
                    <a href="{{ $breadcrumb['url'] }}" wire:navigate class="kt-breadcrumb-link">{{ $breadcrumb['label'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>

    @if (isset($actions))
        <div class="flex items">
            {{ $actions }}
        </div>
    @endif
</div>
