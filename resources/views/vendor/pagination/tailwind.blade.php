@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginación" class="flex flex-wrap items-center justify-center gap-1.5">
        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" class="inline-flex h-10 w-10 cursor-default items-center justify-center rounded-xl text-secondary-300">
                <x-lucide-chevron-left class="h-5 w-5" />
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Anterior"
               class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-secondary-600 ring-1 ring-secondary-200 transition hover:bg-primary-50 hover:text-primary-700 hover:ring-primary-200">
                <x-lucide-chevron-left class="h-5 w-5" />
            </a>
        @endif

        {{-- Números de página --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span aria-disabled="true" class="inline-flex h-10 min-w-[2.5rem] items-center justify-center px-1 text-secondary-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-xl bg-primary-600 px-3 font-semibold text-white shadow-sm">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" aria-label="Ir a la página {{ $page }}"
                           class="inline-flex h-10 min-w-[2.5rem] items-center justify-center rounded-xl px-3 font-medium text-secondary-600 transition hover:bg-primary-50 hover:text-primary-700">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Siguiente"
               class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-secondary-600 ring-1 ring-secondary-200 transition hover:bg-primary-50 hover:text-primary-700 hover:ring-primary-200">
                <x-lucide-chevron-right class="h-5 w-5" />
            </a>
        @else
            <span aria-disabled="true" class="inline-flex h-10 w-10 cursor-default items-center justify-center rounded-xl text-secondary-300">
                <x-lucide-chevron-right class="h-5 w-5" />
            </span>
        @endif
    </nav>
@endif
