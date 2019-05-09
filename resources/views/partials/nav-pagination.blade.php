<nav id="nav-pagination">
    @if ($pagination_items->hasMorePages())
        @if (!$pagination_items->onFirstPage())
            @if ($pagination_items->lastPage() > 2)
                <a class="pagination-first" href="{{ $pagination_items->url(1) }}">&lt;&lt; Første side</a>
            @endif
            <a class="pagination-previous" href="{{ $pagination_items->previousPageUrl() }}">&lt; Forrige side</a>
        @endif
        <a class="pagination-next" href="{{ $pagination_items->nextPageUrl() }}">Neste side &gt;</a>
        @if ($pagination_items->lastPage() > 2)
            <a class="pagination-last" href="{{ $pagination_items->url($pagination_items->lastPage()) }}">Siste side &gt;&gt;</a>
        @endif
    @elseif (!$pagination_items->onFirstPage() && $pagination_items->currentPage() == $pagination_items->lastPage())
        @if ($pagination_items->lastPage() > 2)
            <a class="pagination-first" href="{{ $pagination_items->url(1) }}">&lt;&lt; Første side</a>
        @endif
        <a class="pagination-previous" href="{{ $pagination_items->previousPageUrl() }}">&lt; Forrige side</a>
    @endif
</nav>
