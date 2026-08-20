@if ($paginator->hasPages())
    @if (!$paginator->onFirstPage())
        <a href="{{ $paginator->previousPageUrl() }}" class="a-page-btn">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
        </a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="padding:0 .4rem;color:var(--a-muted)">…</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="a-page-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="a-page-btn">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="a-page-btn">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    @endif
@endif
