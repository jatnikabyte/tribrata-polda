<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            {{-- Mobile page info --}}
            <div class="flex justify-between flex-1 sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span class="btn btn-outline disabled"><</span>
                    @else
                        <button wire:click="previousPage" class="btn btn-outline"><</button>
                    @endif
                </span>

                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button wire:click="nextPage" class="btn btn-outline">></button>
                    @else
                        <span class="btn btn-outline disabled">></span>
                    @endif
                </span>
            </div>

            {{-- Desktop pagination --}}
            <div class="hidden sm:flex sm:items-center sm:justify-between w-full">
                {{-- Page info --}}
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-400">
                        Showing
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        results
                    </p>
                </div>

                {{-- Slider pagination --}}
                <div>
                    <nav class="flex items-center gap-1">
                        {{-- Previous button --}}
                        @if ($paginator->onFirstPage())
                            <span class="px-3 py-1 text-gray-500 bg-gray-100 dark:bg-gray-800 dark:text-gray-400 rounded cursor-not-allowed">&laquo;</span>
                        @else
                            <button wire:click="previousPage" class="px-3 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">&laquo;</button>
                        @endif

                        {{-- Slider pages --}}
                        @php
                            $current = $paginator->currentPage();
                            $last = $paginator->lastPage();
                            $slider = [];
                            $delta = 2;

                            // Always show first page
                            $slider[] = 1;

                            // Calculate range around current
                            $rangeStart = max(2, $current - $delta);
                            $rangeEnd = min($last - 1, $current + $delta);

                            // Add ellipsis after first page if needed
                            if ($rangeStart > 2) {
                                $slider[] = '...';
                            }

                            // Add range pages
                            for ($i = $rangeStart; $i <= $rangeEnd; $i++) {
                                $slider[] = $i;
                            }

                            // Add ellipsis before last page if needed
                            if ($rangeEnd < $last - 1) {
                                $slider[] = '...';
                            }

                            // Always show last page (if more than 1 page)
                            if ($last > 1) {
                                $slider[] = $last;
                            }
                        @endphp

                        @foreach ($slider as $page)
                            @if ($page === '...')
                                <span class="px-3 py-1 text-gray-500 dark:text-gray-400">...</span>
                            @elseif ($page === $current)
                                <span class="px-3 py-1 bg-blue-600 text-white rounded">{{ $page }}</span>
                            @else
                                <button wire:click="gotoPage({{ $page }})" class="px-3 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">
                                    {{ $page }}
                                </button>
                            @endif
                        @endforeach

                        {{-- Next button --}}
                        @if ($paginator->hasMorePages())
                            <button wire:click="nextPage" class="px-3 py-1 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700">&raquo;</button>
                        @else
                            <span class="px-3 py-1 text-gray-500 bg-gray-100 dark:bg-gray-800 dark:text-gray-400 rounded cursor-not-allowed">&raquo;</span>
                        @endif
                    </nav>
                </div>
            </div>
        </nav>
    @endif
</div>
