@if ($paginator->hasPages())
<nav class="pag-nav" role="navigation" aria-label="Paginação">
    <div class="pag-info">
        Exibindo <strong>{{ $paginator->firstItem() }}</strong>–<strong>{{ $paginator->lastItem() }}</strong>
        de <strong>{{ $paginator->total() }}</strong> registros
    </div>
    <div class="pag-links">
        @if ($paginator->onFirstPage())
            <span class="pag-btn disabled" aria-disabled="true"><i class="ti ti-chevron-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pag-btn" rel="prev" aria-label="Anterior"><i class="ti ti-chevron-left"></i></a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="pag-btn dots">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="pag-btn current" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pag-btn" rel="next" aria-label="Próxima"><i class="ti ti-chevron-right"></i></a>
        @else
            <span class="pag-btn disabled" aria-disabled="true"><i class="ti ti-chevron-right"></i></span>
        @endif
    </div>
</nav>
@endif
