@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-gray-600">
            Showing
            <span class="font-semibold text-gray-900">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-semibold text-gray-900">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span>
            results
        </p>

        <div class="inline-flex items-center overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="inline-flex h-11 min-w-11 items-center justify-center border-r border-gray-200 bg-gray-50 px-3 text-gray-300">
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 0 1 0 1.414L9.414 10l3.293 3.293a1 1 0 0 1-1.414 1.414l-4-4a1 1 0 0 1 0-1.414l4-4a1 1 0 0 1 1.414 0Z" clip-rule="evenodd" />
                    </svg>
                </span>
            @else
                <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" aria-label="{{ __('pagination.previous') }}" class="inline-flex h-11 min-w-11 items-center justify-center border-r border-gray-200 bg-white px-3 text-gray-500 transition hover:bg-indigo-50 hover:text-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 disabled:cursor-not-allowed disabled:opacity-60">
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 0 1 0 1.414L9.414 10l3.293 3.293a1 1 0 0 1-1.414 1.414l-4-4a1 1 0 0 1 0-1.414l4-4a1 1 0 0 1 1.414 0Z" clip-rule="evenodd" />
                    </svg>
                </button>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span aria-disabled="true" class="inline-flex h-11 min-w-11 items-center justify-center border-r border-gray-200 bg-white px-3 text-sm font-semibold text-gray-400">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}" aria-current="page" class="inline-flex h-11 min-w-11 items-center justify-center border-r border-indigo-200 bg-indigo-50 px-3 text-sm font-semibold text-indigo-700">
                                {{ $page }}
                            </span>
                        @else
                            <button type="button" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" aria-label="{{ __('Go to page :page', ['page' => $page]) }}" class="inline-flex h-11 min-w-11 items-center justify-center border-r border-gray-200 bg-white px-3 text-sm font-semibold text-gray-600 transition hover:bg-indigo-50 hover:text-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 disabled:cursor-not-allowed disabled:opacity-60">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" aria-label="{{ __('pagination.next') }}" class="inline-flex h-11 min-w-11 items-center justify-center bg-white px-3 text-gray-500 transition hover:bg-indigo-50 hover:text-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100 disabled:cursor-not-allowed disabled:opacity-60">
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0Z" clip-rule="evenodd" />
                    </svg>
                </button>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" class="inline-flex h-11 min-w-11 items-center justify-center bg-gray-50 px-3 text-gray-300">
                    <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 0 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0Z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
