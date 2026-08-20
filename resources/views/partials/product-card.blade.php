<article class="product-card">
    <div class="product-img-wrap">
        <a href="{{ route('products.show', $product->slug) }}" class="product-img-link">
            <div class="product-img">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" loading="lazy">
                @else
                    <div class="product-img-placeholder">🌿</div>
                @endif
            </div>
        </a>
        {{-- Badges --}}
        @if($product->is_featured)
            <span class="product-badge badge-featured">Featured</span>
        @elseif($product->is_new_arrival)
            <span class="product-badge badge-new">New</span>
        @endif
        {{-- Quick actions on hover --}}
        <div class="product-quick-add">
            <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="quick-add-btn">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                    Add to Cart
                </button>
            </form>
            <a href="{{ route('contact') }}?product={{ urlencode($product->name) }}" class="quick-quote-btn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Get Quote
            </a>
        </div>
    </div>

    <div class="product-body">
        @if($product->category)
            <div class="product-category">{{ $product->category->name }}</div>
        @endif

        <h3 class="product-name">
            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
        </h3>

        <div class="product-card-footer">
            @if($product->price)
                <div class="product-card-price">
                    <span class="product-card-price-amount">{{ number_format($product->price, 2) }}</span>
                </div>
            @else
                <span class="product-card-price-por">Price on Request</span>
            @endif
            <div class="product-card-btns">
                <a href="{{ route('contact') }}?product={{ urlencode($product->name) }}" class="product-quote-icon" title="Get Export Quote">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                </a>
                <a href="{{ route('products.show', $product->slug) }}" class="product-view-btn" title="View Product">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
            </div>
        </div>
    </div>
</article>
