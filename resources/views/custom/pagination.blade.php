@if ($paginator->hasPages())
    <div class="flex items-center space-x-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 border border-gray-300 rounded-l-md bg-gray-100 text-gray-400 cursor-not-allowed">
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-3 py-1 border border-gray-300 rounded-l-md hover:bg-[#F91D7C]/10">
                Previous
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 border-t border-b border-gray-300">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 border-t border-b border-gray-300 bg-[#F91D7C] text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 border-t border-b border-gray-300 hover:bg-[#F91D7C]/10">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="px-3 py-1 border border-gray-300 rounded-r-md hover:bg-[#F91D7C]/10">
                Next
            </a>
        @else
            <span class="px-3 py-1 border border-gray-300 rounded-r-md bg-gray-100 text-gray-400 cursor-not-allowed">
                Next
            </span>
        @endif
    </div>
@endif