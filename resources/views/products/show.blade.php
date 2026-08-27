@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', $product->short_description ?: 'Buy ' . $product->name . ' — premium quality from Sri Lanka. Wholesale export available worldwide.')

@php
$schemaImg = $product->image ? asset('storage/'.$product->image) : 'https://ceylonaroma.com/images/spice-flatlay.png';
@endphp
@section('og_image', $schemaImg)

@push('schema')
@php
$schemaDesc = addslashes($product->short_description ?: $product->name . ' — premium export quality from Sri Lanka.');
$schemaPrice = $product->price ? number_format($product->price, 2, '.', '') : null;
$schemaAvail = $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "{{ addslashes($product->name) }}",
  "description": "{{ $schemaDesc }}",
  "image": "{{ $schemaImg }}",
  "brand": { "@type": "Brand", "name": "Ceylon Aroma" },
  "offers": {
    "@type": "Offer",
    "priceCurrency": "{{ $product->currency ?: 'USD' }}",
    @if($schemaPrice)
    "price": "{{ $schemaPrice }}",
    @endif
    "availability": "{{ $schemaAvail }}",
    "seller": { "@type": "Organization", "name": "Ceylon Aroma", "url": "https://ceylonaroma.com" }
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home", "item": "https://ceylonaroma.com" },
    { "@type": "ListItem", "position": 2, "name": "Products", "item": "https://ceylonaroma.com/products" }@if($product->category),
    { "@type": "ListItem", "position": 3, "name": "{{ addslashes($product->category->name) }}", "item": "https://ceylonaroma.com/products?category={{ $product->category->slug }}" },
    { "@type": "ListItem", "position": 4, "name": "{{ addslashes($product->name) }}", "item": "https://ceylonaroma.com/products/{{ $product->slug }}" }@else,
    { "@type": "ListItem", "position": 3, "name": "{{ addslashes($product->name) }}", "item": "https://ceylonaroma.com/products/{{ $product->slug }}" }@endif
  ]
}
</script>
@endpush

@section('content')

<div class="product-hero">
    <div class="container">
        <div class="product-detail-grid">

            {{-- Gallery --}}
            <div class="product-gallery">
                <div class="product-gallery-main">
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }} — main product image" class="gallery-main-img" id="gallery-main">
                    @else
                        <div class="detail-img-placeholder">
                            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="var(--sage)" stroke-width="1.2" opacity=".5" aria-hidden="true"><path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/></svg>
                            <span class="detail-img-placeholder-label">No image</span>
                        </div>
                    @endif
                </div>
                @if(is_array($product->gallery) && count($product->gallery))
                <div class="product-gallery-thumbs">
                    @if($product->image)
                    <div class="gallery-thumb active" data-src="{{ asset('storage/'.$product->image) }}">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" loading="lazy">
                    </div>
                    @endif
                    @foreach($product->gallery as $gi => $img)
                    <div class="gallery-thumb" data-src="{{ asset('storage/'.$img) }}">
                        <img src="{{ asset('storage/'.$img) }}" alt="{{ $product->name }} — view {{ $gi + 2 }}" loading="lazy">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="product-info">
                @if($product->category)
                <div class="product-cat-label">
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                </div>
                @endif

                <h1 class="product-detail-title">{{ $product->name }}</h1>
                @if($product->sku)<p class="product-sku">SKU: {{ $product->sku }}</p>@endif

                <div class="product-flags">
                    @if($product->is_featured)<span class="flag-pill flag-featured">Featured</span>@endif
                    @if($product->is_bestseller)<span class="flag-pill flag-bestseller">Best Seller</span>@endif
                    @if($product->is_new_arrival)<span class="flag-pill flag-new">New Arrival</span>@endif
                    @if($product->is_export_ready)<span class="flag-pill flag-export">Export Ready</span>@endif
                    @if(!$product->in_stock)<span class="flag-pill flag-outofstock">Out of Stock</span>@elseif($product->isLowStock())<span class="flag-pill flag-lowstock">Low Stock</span>@endif
                </div>

                @if($product->short_description)
                <p class="product-detail-desc">{{ $product->short_description }}</p>
                @endif

                {{-- Pricing box --}}
                <div class="product-price-box">
                    @php $variants = $product->variants ?? []; $hasVariants = count($variants) > 0; @endphp
                    @if($hasVariants)
                        {{-- Variant selector --}}
                        <div class="variant-selector">
                            <div class="variant-selector-label">Select Option:</div>
                            <div class="variant-pills">
                                @foreach($variants as $vi => $variant)
                                <button type="button"
                                    class="variant-pill{{ $vi === 0 ? ' active' : '' }}"
                                    data-index="{{ $vi }}"
                                    data-price="{{ $variant['price'] ?? '' }}"
                                    data-unit="{{ $variant['price_unit'] ?? 'kg' }}"
                                    data-currency="{{ $product->currency ?: 'USD' }}"
                                    data-image="{{ !empty($variant['image']) ? asset('storage/'.$variant['image']) : '' }}">
                                    {{ $variant['name'] }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                        {{-- Dynamic price display --}}
                        @php $first = $variants[0]; $cur = $product->currency ?: 'USD'; @endphp
                        <div class="product-price-main" id="variant-price-display">
                            @if(isset($first['price']) && $first['price'] !== null)
                            <span class="product-price-amount" id="vprice-amt">{{ $cur }} {{ number_format($first['price'], 2) }}</span>
                            @else
                            <div class="product-price-request" id="vprice-por">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                Price on Request
                            </div>
                            @endif
                        </div>
                    @elseif($product->price)
                        <div class="product-price-main">
                            <span class="product-price-amount">{{ $product->currency ?: 'USD' }} {{ number_format($product->price, 2) }}</span>
                        </div>
                    @else
                        <div class="product-price-request">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            Price on Request — contact us for a quote
                        </div>
                    @endif
                </div>
                @if($product->min_order_qty)
                <div class="product-moq">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    Min. Order: <strong>{{ number_format($product->min_order_qty, 0) }} {{ $product->min_order_unit }}</strong>
                </div>
                @endif

                {{-- Specs --}}
                @php
                    $specs = array_filter([
                        'Origin'           => $product->origin,
                        'Certifications'   => $product->certifications,
                        'Shelf Life'       => $product->shelf_life,
                        'Weight per Unit'  => null,
                    ]);
                @endphp
                @if(count($specs))
                <div class="product-specs-grid">
                    @foreach($specs as $label => $value)
                    <div class="product-spec-item">
                        <span class="product-spec-label">{{ $label }}</span>
                        <span class="product-spec-value">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Actions --}}
                <div class="product-actions">
                    @if($product->in_stock !== false)
                    <form method="POST" action="{{ route('cart.add') }}" class="detail-add-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="product-qty-row">
                            <div class="qty-form">
                                <label for="detail-qty" class="sr-only">Quantity</label>
                                <button type="button" class="qty-btn qty-dec-detail">−</button>
                                <input type="number" name="quantity" value="1" min="1" max="999" class="qty-input qty-input-detail" id="detail-qty">
                                <button type="button" class="qty-btn qty-inc-detail">+</button>
                            </div>
                            <button type="submit" class="btn btn-gold detail-add-btn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                                Add to Cart
                            </button>
                        </div>
                    </form>
                    @endif
                    <a href="{{ route('contact') }}?product={{ urlencode($product->name) }}&inquiry=quote" class="btn btn-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Get Export Quote
                    </a>
                    <a href="{{ route('contact') }}?product={{ urlencode($product->name) }}&inquiry=sample" class="btn btn-outline">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16v-2"/><polyline points="7.5 4.21 12 6.81 16.5 4.21"/><polyline points="7.5 19.79 7.5 14.6 3 12"/><polyline points="21 12 16.5 14.6 16.5 19.79"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                        Request Sample
                    </a>
                </div>

                {{-- Export info card --}}
                <div class="product-export-card">
                    <div class="product-export-card-row">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                        Available for bulk export to 60+ countries
                    </div>
                    <div class="product-export-card-row">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        ISO certified · Quality guaranteed
                    </div>
                </div>

                @if($product->description)
                <div class="product-full-desc">
                    {!! nl2br(e($product->description)) !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Related Products --}}
@if($related->count())
<section class="product-related">
    <div class="container">
        <div class="section-head">
            <span class="section-label">More Products</span>
            <h2 class="section-title">You May Also Like</h2>
        </div>
        <div class="products-grid products-grid-4">
            @foreach($related as $p)
            @include('partials.product-card', ['product' => $p])
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
(function(){
// Gallery thumb switching — also updates active thumb strip
document.querySelectorAll('.gallery-thumb').forEach(function(thumb){
    thumb.addEventListener('click', function(){
        document.querySelectorAll('.gallery-thumb').forEach(function(t){ t.classList.remove('active'); });
        thumb.classList.add('active');
        var main = document.getElementById('gallery-main');
        if(main) main.src = thumb.dataset.src;
    });
});

// Qty buttons on detail page
var dqInput = document.getElementById('detail-qty');
var decBtn = document.querySelector('.qty-dec-detail');
var incBtn = document.querySelector('.qty-inc-detail');
if(decBtn) decBtn.addEventListener('click', function(){
    if(dqInput && parseInt(dqInput.value) > 1) dqInput.value = parseInt(dqInput.value) - 1;
});
if(incBtn) incBtn.addEventListener('click', function(){
    if(dqInput && parseInt(dqInput.value) < 999) dqInput.value = parseInt(dqInput.value) + 1;
});

// Variant pill switching
document.querySelectorAll('.variant-pill').forEach(function(pill){
    pill.addEventListener('click', function(){
        document.querySelectorAll('.variant-pill').forEach(function(p){ p.classList.remove('active'); });
        pill.classList.add('active');

        var price    = pill.dataset.price;
        var currency = pill.dataset.currency || 'USD';
        var img      = pill.dataset.image;

        // Update price display (DOM-safe — no innerHTML)
        var priceWrap = document.getElementById('variant-price-display');
        if(priceWrap){
            priceWrap.textContent = '';
            if(price){
                var amtEl = document.createElement('span');
                amtEl.className = 'product-price-amount';
                amtEl.textContent = currency + ' ' + parseFloat(price).toFixed(2);
                priceWrap.appendChild(amtEl);
            } else {
                var porEl = document.createElement('div');
                porEl.className = 'product-price-request';
                porEl.textContent = 'Price on Request';
                priceWrap.appendChild(porEl);
            }
        }

        // Swap main gallery image and update active thumb
        if(img){
            var mainImg = document.getElementById('gallery-main');
            if(mainImg){ mainImg.src = img; }
            // Highlight matching thumb if it exists
            document.querySelectorAll('.gallery-thumb').forEach(function(t){
                t.classList.toggle('active', t.dataset.src === img);
            });
        }
    });
});
})();
</script>
@endpush
