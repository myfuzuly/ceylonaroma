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
        <span class="section-label" style="color:var(--gold-2)">{{ $blog_post->category }}</span>
        @endif
        <h1>{{ $blog_post->title }}</h1>
        <p class="blog-meta">{{ $blog_post->published_at?->format('d M Y') }}</p>
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
                <p style="font-size:1.125rem;color:var(--canopy);font-weight:500;margin-bottom:1.5rem">{{ $blog_post->excerpt }}</p>
                @endif
                {!! nl2br(e($blog_post->content)) !!}
            </div>

            <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid var(--border);display:flex;gap:1rem;flex-wrap:wrap">
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
                <div style="padding:.75rem 0;border-bottom:1px solid var(--border)">
                    <div style="font-size:.7rem;color:var(--gold);font-weight:600;text-transform:uppercase;letter-spacing:.08em;margin-bottom:.3rem">{{ $r->category }}</div>
                    <a href="{{ route('blog.show', $r->slug) }}" style="font-size:.875rem;font-weight:600;color:var(--canopy);line-height:1.4">{{ $r->title }}</a>
                    <div style="font-size:.75rem;color:var(--muted);margin-top:.25rem">{{ $r->published_at?->format('d M Y') }}</div>
                </div>
                @endforeach
            </div>
            @endif
            <div style="background:var(--canopy);border-radius:12px;padding:1.5rem;text-align:center">
                <h4 style="color:var(--gold-2);font-family:var(--font-serif);font-size:1.125rem;margin-bottom:.75rem">Ready to Import?</h4>
                <p style="color:rgba(255,255,255,.75);font-size:.875rem;margin-bottom:1rem">Get premium Ceylon products exported worldwide.</p>
                <a href="{{ route('contact') }}" class="btn btn-gold" style="width:100%;justify-content:center">Contact Us</a>
            </div>
        </aside>
    </div>
</section>

@endsection
