@extends('layouts.app')

@section('title', (request('category') ? ucwords(str_replace('-', ' ', request('category'))).' — ' : '') . (request('search') ? '"'.request('search').'" — ' : '') . 'Products' . ($products->currentPage() > 1 ? ' | Page '.$products->currentPage() : ''))

@section('content')

<div class="products-hero">
    <div class="container">
        @php
        $activeCatName = null;
        if(request('category')) {
            foreach($categories as $c) {
                if($c->slug === request('category')) { $activeCatName = $c->name; break; }
                foreach($c->children as $ch) {
                    if($ch->slug === request('category')) { $activeCatName = $ch->name; break 2; }
                }
            }
        }
        @endphp
        <h1>{{ $activeCatName ? $activeCatName : 'Our Products' }}</h1>
        @if(request('search'))
            <p>Showing results for "<strong>{{ request('search') }}</strong>"</p>
        @elseif($activeCatName)
            <p>Premium quality {{ $activeCatName }} sourced direct from Sri Lankan farms.</p>
        @else
            <p>Premium quality natural products sourced direct from Sri Lankan farms and plantations.</p>
        @endif
    </div>
</div>

<section class="products-layout">
    <div class="container">
        <div class="products-content-grid">
            {{-- Sidebar --}}
            <aside class="products-sidebar">
                <div class="sidebar-card">
                    <h4>Search</h4>
                    <form method="GET" action="{{ route('products.index') }}">
                        <div class="search-input-wrap">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products…">
                        </div>
                    </form>
                </div>
                <div class="sidebar-card">
                    <h4>Categories</h4>
                    <div class="sidebar-cats">
                        <a href="{{ route('products.index') }}" class="sidebar-cat {{ !request('category') ? 'active' : '' }}">
                            All Products
                        </a>
                        @foreach($categories as $cat)
                        @php
                            $childSlugs = $cat->children->pluck('slug')->toArray();
                            $parentActive = request('category') === $cat->slug || in_array(request('category'), $childSlugs);
                        @endphp
                        <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                           class="sidebar-cat sidebar-cat-parent {{ $parentActive ? 'active' : '' }}">
                            {{ $cat->name }}
                            @if($cat->children->count())
                            <svg class="sidebar-chevron {{ $parentActive ? 'open' : '' }}" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                            @endif
                        </a>
                        @if($cat->children->count())
                        <div class="sidebar-subcats {{ $parentActive ? 'open' : '' }}">
                            @foreach($cat->children as $sub)
                            <a href="{{ route('products.index', ['category' => $sub->slug]) }}"
                               class="sidebar-cat sidebar-subcat {{ request('category') === $sub->slug ? 'active' : '' }}">
                                {{ $sub->name }}
                            </a>
                            @endforeach
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="sidebar-quote-cta">
                    <p class="sidebar-quote-text">Need a custom quote?</p>
                    <a href="{{ route('contact') }}" class="btn btn-gold sidebar-quote-btn">Get a Quote</a>
                </div>
            </aside>

            {{-- Products --}}
            <div>
                <div class="products-toolbar">
                    <span class="products-count">{{ $products->total() }} products found</span>
                    <div class="product-tabs product-tabs-toolbar">
                        <a href="{{ route('products.index', array_merge(request()->except('tab'), [])) }}" class="tab-btn {{ !request('tab') ? 'active' : '' }}">All</a>
                        <a href="{{ route('products.index', array_merge(request()->all(), ['tab'=>'featured'])) }}" class="tab-btn {{ request('tab')==='featured' ? 'active' : '' }}">Featured</a>
                        <a href="{{ route('products.index', array_merge(request()->all(), ['tab'=>'new'])) }}" class="tab-btn {{ request('tab')==='new' ? 'active' : '' }}">New Arrivals</a>
                        <a href="{{ route('products.index', array_merge(request()->all(), ['tab'=>'export'])) }}" class="tab-btn {{ request('tab')==='export' ? 'active' : '' }}">Export Ready</a>
                    </div>
                </div>

                @if($products->count())
                <div class="products-grid">
                    @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                <div class="pagination-wrap">
                    {{$products->links('partials.pagination')}}
                </div>
                @endif
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                    <h3>No products found</h3>
                    <p>Try a different category or search term.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-outline empty-state-btn">View All Products</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
