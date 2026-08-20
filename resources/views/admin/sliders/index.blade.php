@extends('layouts.admin')
@section('title', 'Hero Slider')
@section('breadcrumb') <span>Hero Slider</span> @endsection

@section('content')
<div class="page-title">
    Hero Slider
    <a href="{{ route('admin.sliders.create') }}" class="a-btn a-btn-primary">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Slide
    </a>
</div>

@if($sliders->isEmpty())
<div style="text-align:center;padding:4rem 2rem;color:var(--a-muted)">
    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 1rem;display:block;opacity:.35"><rect x="3" y="3" width="18" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><circle cx="8" cy="9" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
    <p style="margin-bottom:1rem">No slides yet. Add your first hero image.</p>
    <a href="{{ route('admin.sliders.create') }}" class="a-btn a-btn-primary">+ Add First Slide</a>
</div>
@else

<div style="margin-bottom:1rem;font-size:.78rem;color:var(--a-muted)">
    {{ $sliders->count() }} slide{{ $sliders->count() !== 1 ? 's' : '' }} — ordered by Sort Order ascending.
    Active slides appear in the homepage hero.
</div>

<div class="slider-admin-grid" id="sliderGrid">
    @foreach($sliders as $slide)
    <div class="slide-card" data-id="{{ $slide->id }}">
        {{-- Thumbnail --}}
        <div class="slide-thumb-wrap">
            <img src="{{ asset('storage/'.$slide->image) }}" alt="{{ $slide->title ?? 'Slide' }}" class="slide-thumb">
            <div class="slide-overlay-badges">
                <span class="slide-order-pill">#{{ $slide->sort_order }}</span>
                <span class="slide-status-pill {{ $slide->status ? 'active' : 'inactive' }}">
                    <span class="dot" style="width:5px;height:5px;border-radius:50%;display:inline-block;background:currentColor;margin-right:.3rem"></span>
                    {{ $slide->status ? 'Live' : 'Hidden' }}
                </span>
            </div>
            @if($slide->link)
            <div class="slide-link-badge" title="{{ $slide->link }}">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                Has link
            </div>
            @endif
        </div>

        {{-- Meta --}}
        <div class="slide-meta">
            <div class="slide-meta-title">{{ $slide->title ?: '—' }}</div>
            @if($slide->subtitle)
            <div class="slide-meta-sub">{{ Str::limit($slide->subtitle, 60) }}</div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="slide-actions">
            <a href="{{ route('admin.sliders.edit', $slide) }}" class="a-btn a-btn-ghost a-btn-sm" style="flex:1;justify-content:center">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.sliders.destroy', $slide) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="a-btn-icon" style="color:var(--a-red);background:rgba(248,113,113,.08);border-radius:6px;width:30px;height:30px" data-confirm="Delete this slide?">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<style>
.slider-admin-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.25rem}
.slide-card{background:var(--a-surface);border:1px solid var(--a-border);border-radius:12px;overflow:hidden;transition:box-shadow .2s,transform .2s;display:flex;flex-direction:column}
.slide-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.18);transform:translateY(-2px)}
.slide-thumb-wrap{position:relative;aspect-ratio:16/9;overflow:hidden;background:var(--a-bg)}
.slide-thumb{width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s ease}
.slide-card:hover .slide-thumb{transform:scale(1.04)}
.slide-overlay-badges{position:absolute;top:.6rem;left:.6rem;right:.6rem;display:flex;justify-content:space-between;align-items:center;gap:.4rem}
.slide-order-pill{background:rgba(0,0,0,.55);color:#fff;font-size:.65rem;font-weight:700;padding:.2rem .55rem;border-radius:20px;backdrop-filter:blur(4px)}
.slide-status-pill{font-size:.65rem;font-weight:700;padding:.2rem .55rem;border-radius:20px;backdrop-filter:blur(4px);display:flex;align-items:center}
.slide-status-pill.active{background:rgba(52,211,153,.2);color:#34D399;border:1px solid rgba(52,211,153,.3)}
.slide-status-pill.inactive{background:rgba(156,163,175,.15);color:#9CA3AF;border:1px solid rgba(156,163,175,.2)}
.slide-link-badge{position:absolute;bottom:.6rem;right:.6rem;background:rgba(198,134,42,.85);color:#fff;font-size:.6rem;font-weight:700;padding:.2rem .5rem;border-radius:20px;display:flex;align-items:center;gap:.3rem;backdrop-filter:blur(4px)}
.slide-meta{padding:.85rem 1rem .5rem;flex:1}
.slide-meta-title{font-size:.82rem;font-weight:700;color:var(--a-text);margin-bottom:.2rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.slide-meta-sub{font-size:.72rem;color:var(--a-muted);line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.slide-actions{padding:.6rem 1rem .85rem;display:flex;align-items:center;gap:.5rem}
</style>
@endif
@endsection
