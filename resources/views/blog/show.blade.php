@extends('layouts.app')

@section('title', $blog_post->title)
@section('meta_description', $blog_post->excerpt ?: 'Read ' . $blog_post->title . ' — export insights and product guides from Ceylon Aroma, Sri Lanka.')
@section('og_type', 'article')

@push('schema')
@php
$postImg = $blog_post->image ? asset('storage/'.$blog_post->image) : 'https://ceylonaroma.com/images/blog-spices.webp';
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ addslashes($blog_post->title) }}",
  "description": "{{ addslashes($blog_post->excerpt ?: $blog_post->title) }}",
  "image": "{{ $postImg }}",
  "datePublished": "{{ $blog_post->published_at?->toIso8601String() }}",
  "dateModified": "{{ $blog_post->updated_at?->toIso8601String() }}",
  "author": { "@type": "Organization", "name": "Ceylon Aroma", "url": "https://ceylonaroma.com" },
  "publisher": {
    "@type": "Organization",
    "name": "Ceylon Aroma",
    "logo": { "@type": "ImageObject", "url": "https://ceylonaroma.com/images/logo.png" }
  },
  "mainEntityOfPage": { "@type": "WebPage", "@id": "https://ceylonaroma.com/blog/{{ $blog_post->slug }}" }
}
</script>
@endpush

@section('content')

<div class="blog-post-hero">
    <div class="container">
        @if($blog_post->category)
        <span class="section-label blog-cat-label-gold">{{ $blog_post->category }}</span>
        @endif
        <h1>{{ $blog_post->title }}</h1>
        <p class="blog-meta"><time datetime="{{ $blog_post->published_at?->toDateString() }}">{{ $blog_post->published_at?->format('d M Y') }}</time></p>
    </div>
</div>

<section class="blog-post-layout">
    <div class="container">
        <article>
            @if($blog_post->image)
            <div class="blog-post-img">
                <img src="{{ asset('storage/'.$blog_post->image) }}" alt="{{ $blog_post->title }}">
            </div>
            @else
            <div class="blog-post-img-placeholder"></div>
            @endif

            <div class="blog-content">
                @if($blog_post->excerpt)
                <p class="blog-post-excerpt">{{ $blog_post->excerpt }}</p>
                @endif
                {!! nl2br(e($blog_post->content)) !!}
            </div>

            <div class="blog-post-foot">
                <a href="{{ route('blog.index') }}" class="btn btn-outline btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    Back to Articles
                </a>
                <a href="{{ route('contact') }}" class="btn btn-primary btn-sm">Get Export Quote</a>
            </div>
        </article>

        {{-- Blog sidebar --}}
        <aside class="blog-sidebar">
            @if($related->count())
            <div class="sidebar-card">
                <h4>Related Articles</h4>
                @foreach($related as $r)
                <div class="blog-related-item">
                    <div class="blog-related-cat">{{ $r->category }}</div>
                    <a href="{{ route('blog.show', $r->slug) }}" class="blog-related-title">{{ $r->title }}</a>
                    <div class="blog-related-date"><time datetime="{{ $r->published_at?->toDateString() }}">{{ $r->published_at?->format('d M Y') }}</time></div>
                </div>
                @endforeach
            </div>
            @endif
            <div class="blog-sidebar-cta">
                <h4 class="blog-sidebar-cta-title">Ready to Import?</h4>
                <p class="blog-sidebar-cta-text">Get premium Ceylon products exported worldwide.</p>
                <a href="{{ route('contact') }}" class="btn btn-gold">Contact Us</a>
            </div>
        </aside>
    </div>
</section>

@endsection
