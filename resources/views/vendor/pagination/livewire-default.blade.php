@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="flex justify-center text-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li aria-label="@lang('pagination.previous')">
                    <span class="px-4 py-3 text-gray-500 block border border-r-0 border-gray-300 rounded-l" aria-hidden="true">&larr;</span>
                </li>
            @else
                <li>
                    <button type="button" class="px-4 py-3 block text-blue-900 border border-r-0 border-gray-300 rounded-l hover:text-white hover:bg-blue-900 focus:outline-none focus:shadow-outline" aria-label="@lang('pagination.previous')" wire:click="previousPage">
                        &larr;
                    </button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li aria-disabled="true">
                        <span class="px-4 py-3 block text-gray-500 border border-r-0 border-gray-300">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page">
                                <span class="px-4 py-3 block text-white bg-blue-900 border border-r-0 border-gray-300">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <button type="button" class="px-4 py-3 block text-blue-900 border border-r-0 border-gray-300 hover:text-white hover:bg-blue-900 focus:outline-none focus:shadow-outline" wire:click="gotoPage({{ $page }})">
                                {{ $page }}
                                </button>

                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button type="button" class="px-4 py-3 block text-blue-900 border border-r-0 border-gray-300 rounded-l hover:text-white hover:bg-blue-900 focus:outline-none focus:shadow-outline" aria-label="@lang('pagination.next')" wire:click="nextPage">
                        &rarr;
                    </button>
                </li>
            @else
                <li aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="px-4 py-3 block text-gray-500 border border-gray-300 rounded-r" aria-hidden="true">&rarr;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
