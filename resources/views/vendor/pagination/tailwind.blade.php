@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            {{-- Mobile --}}
            <div class="flex justify-between flex-1 sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span class="kt-btn kt-btn-ghost opacity-50 cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"></path></svg>
                        </span>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" class="kt-btn kt-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"></path></svg>
                        </button>
                    @endif
                </span>

                <span class="text-sm text-default-600">
                    {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" class="kt-btn kt-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"></path></svg>
                        </button>
                    @else
                        <span class="kt-btn kt-btn-ghost opacity-50 cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"></path></svg>
                        </span>
                    @endif
                </span>
            </div>

            {{-- Desktop slider pagination --}}
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-default-600">
                        <span class="font-medium text-default-800">{{ $paginator->firstItem() }}</span>
                        - <span class="font-medium text-default-800">{{ $paginator->lastItem() }}</span>
                        dari <span class="font-medium text-default-800">{{ $paginator->total() }}</span>
                    </p>
                </div>

                <div>
                    <ol class="kt-pagination">
                        <li class="kt-pagination-item">
                            @if ($paginator->onFirstPage())
                                <span class="kt-btn kt-btn-ghost opacity-50 cursor-not-allowed" aria-disabled="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"></path></svg>
                                    <span class="hidden sm:inline">Sebelumnya</span>
                                </span>
                            @else
                                <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" class="kt-btn kt-btn-ghost">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-chevron-left"><path d="m15 18-6-6 6-6"></path></svg>
                                    <span class="hidden sm:inline">Sebelumnya</span>
                                </button>
                            @endif
                        </li>

                        {{-- Slider pages: 1,2,3,4,5,...,46,47,48,49,50 --}}
                        @php
                            $current = $paginator->currentPage();
                            $last = $paginator->lastPage();
                            $delta = 2;
                            $slider = [];

                            if ($last <= 7) {
                                // Show all pages if 7 or less
                                $slider = range(1, $last);
                            } else {
                                $slider[] = 1;

                                $rangeStart = max(2, $current - $delta);
                                $rangeEnd = min($last - 1, $current + $delta);

                                if ($rangeStart > 2) {
                                    $slider[] = '...';
                                }

                                for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
                                    $slider[] = $i;
                                }

                                if ($rangeEnd < $last - 1) {
                                    $slider[] = '...';
                                }

                                $slider[] = $last;
                            }
                        @endphp

                        @foreach ($slider as $page)
                            @if ($page === '...')
                                <li class="kt-pagination-ellipsis" aria-disabled="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-ellipsis"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </li>
                            @else
                                <li class="kt-pagination-item" wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                    @if ($page == $current)
                                        <span class="kt-btn kt-btn-icon kt-btn-ghost active" aria-current="page">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" class="kt-btn kt-btn-icon kt-btn-ghost">
                                            {{ $page }}
                                        </button>
                                    @endif
                                </li>
                            @endif
                        @endforeach

                        <li class="kt-pagination-item">
                            @if ($paginator->hasMorePages())
                                <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" class="kt-btn kt-btn-ghost">
                                    <span class="hidden sm:inline">Berikutnya</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"></path></svg>
                                </button>
                            @else
                                <span class="kt-btn kt-btn-ghost opacity-50 cursor-not-allowed" aria-disabled="true">
                                    <span class="hidden sm:inline">Berikutnya</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"></path></svg>
                                </span>
                            @endif
                        </li>
                    </ol>
                </div>
            </div>
        </nav>
    @endif
</div>
