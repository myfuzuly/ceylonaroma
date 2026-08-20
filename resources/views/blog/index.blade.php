@extends('layouts.app')

@section('title', 'Knowledge Centre')

@section('content')

<div class="blog-hero">
    <div class="container">
        <h1>Knowledge Centre</h1>
        <p>Export guides, product insights and industry news from Ceylon Aroma.</p>
    </div>
</div>

<section class="blog-layout">
    <div class="container">
        <div class="blog-main-grid">
            @foreach($posts as $i => $post)
            <article class="blog-card {{ $i === 0 ? 'blog-featured' : '' }}">
                <a href="{{ route('blog.show', $post->slug) }}">
                    <div class="blog-img">
                        @if($post->image)
                            <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" loading="lazy">
                        @else
                            @php
                            $blogPlaceholders = [
                                '/images/blog-spices.webp',
                                '/images/blog-tea.jpg',
                                '/images/blog-coffee.webp',
                                '/images/blog-cinnamon.jpg',
                                '/images/blog-clove.jpg',
                            ];
                            $ph = $blogPlaceholders[$loop->index % count($blogPlaceholders)];
                            @endphp
                            <img src="{{ $ph }}" alt="{{ $post->title }}" loading="lazy" class="blog-placeholder-img">
                        @endif
                        @if($post->category)<span class="blog-cat">{{ $post->category }}</span>@endif
                    </div>
                </a>
                <div class="blog-body">
                    <div class="blog-meta">{{ $post->published_at?->format('d M Y') }}</div>
                    <h3 class="blog-title">
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
            <div style="text-align:center;padding:4rem;grid-column:1/-1;color:var(--muted)">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="1.2" style="margin-bottom:1rem;opacity:.5"><path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/></svg>
                <h3 style="color:var(--canopy)">No articles yet</h3>
                <p>Check back soon for export guides and product insights.</p>
            </div>
            @endif
        </div>

        @if($posts->hasPages())
        <div class="pagination-wrap" style="margin-top:3rem">
            {{ $posts->links('partials.pagination') }}
        </div>
        @endif

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
            <div style="background:var(--canopy);border-radius:12px;padding:1.5rem;text-align:center">
                <h4 style="color:var(--gold-2);font-family:var(--font-serif);font-size:1.125rem;margin-bottom:.75rem">Ready to Export?</h4>
                <p style="color:rgba(255,255,255,.75);font-size:.875rem;margin-bottom:1rem">Get a quote for premium Ceylon products delivered worldwide.</p>
                <a href="{{ route('contact') }}" class="btn btn-gold" style="width:100%;justify-content:center">Get a Quote</a>
            </div>
        </aside>
    </div>
</section>

@endsection
