@extends('layouts.app')

@section('title', 'Knowledge Center')
@section('meta_description', 'Export guides, import regulations, product sourcing insights and Ceylon spice industry news from Ceylon Aroma — Sri Lanka\'s B2B export specialists.')

@section('content')

<div class="blog-hero">
    <div class="container">
        <span class="section-label export-hero-label">Knowledge Center</span>
        <h1>Export Insights &amp; Industry News</h1>
        <p>Export guides, product insights and industry news from Ceylon Aroma.</p>
    </div>
</div>

<section class="blog-layout">
    <div class="container">

        {{-- Main content column (filter pills + grid + pagination) --}}
        <div class="blog-content-area">

            {{-- Category filter pills --}}
            @if($categories->count())
            <nav class="blog-filter-pills" aria-label="Filter articles by category">
                <a href="{{ route('blog.index') }}" class="bfp {{ !request('category') ? 'bfp--active' : '' }}">All Articles</a>
                @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat]) }}" class="bfp {{ request('category') === $cat ? 'bfp--active' : '' }}">{{ $cat }}</a>
                @endforeach
            </nav>
            @endif

            <div class="blog-main-grid">
                @foreach($posts as $i => $post)
                <article class="blog-card {{ $i === 0 ? 'blog-featured' : '' }}" aria-labelledby="bc-title-{{ $post->id }}">
                    <a href="{{ route('blog.show', $post->slug) }}">
                        <div class="blog-img">
                            @if($post->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($post->image, ['http', '/']) ? $post->image : asset('storage/'.$post->image) }}" alt="{{ $post->title }}" loading="{{ $i === 0 ? 'eager' : 'lazy' }}" decoding="async">
                            @else
                                @php
                                $blogPlaceholders = [
                                    '/images/blog-spices.webp',
                                    '/images/blog-row.webp',
                                    '/images/blog-coffee.webp',
                                    '/images/product-cinnamon.webp',
                                    '/images/product-clove.webp',
                                ];
                                $ph = $blogPlaceholders[$loop->index % count($blogPlaceholders)];
                                @endphp
                                <img src="{{ $ph }}" alt="{{ $post->title }}" loading="lazy" decoding="async" class="blog-placeholder-img">
                            @endif
                            @if($post->category)<span class="blog-cat">{{ $post->category }}</span>@endif
                        </div>
                    </a>
                    <div class="blog-body">
                        <div class="blog-meta"><time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('d M Y') }}</time></div>
                        <h3 class="blog-title" id="bc-title-{{ $post->id }}">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="blog-excerpt">{{ $post->excerpt }}</p>
                    </div>
                    <div class="blog-foot">
                        <a href="{{ route('blog.show', $post->slug) }}" class="read-more">
                            Read More
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </article>
                @endforeach

                @if($posts->isEmpty())
                <div class="blog-empty-state">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="1.2" style="margin-bottom:1rem;opacity:.5" aria-hidden="true"><path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/></svg>
                    <h3>No articles yet</h3>
                    <p>Check back soon for export guides and product insights.</p>
                </div>
                @endif
            </div>

            @if($posts->hasPages())
            <div class="pagination-wrap" style="margin-top:2rem">
                {{ $posts->links('partials.pagination') }}
            </div>
            @endif

        </div>{{-- /.blog-content-area --}}

        {{-- Sidebar --}}
        <aside class="blog-sidebar">
            <div class="sidebar-card">
                <h4>Categories</h4>
                <div class="blog-cats-list">
                    <a href="{{ route('blog.index') }}" class="{{ !request('category') ? 'active' : '' }}">All Articles</a>
                    @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat]) }}" class="{{ request('category') === $cat ? 'active' : '' }}">{{ $cat }}</a>
                    @endforeach
                </div>
            </div>
            <div class="blog-sidebar-cta">
                <h4 class="blog-sidebar-cta-title">Ready to Export?</h4>
                <p class="blog-sidebar-cta-text">Get a quote for premium Ceylon products delivered worldwide.</p>
                <a href="{{ route('contact') }}" class="btn btn-gold">Get a Quote</a>
            </div>
        </aside>

    </div>
</section>

@endsection
