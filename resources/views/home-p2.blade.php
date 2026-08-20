{{-- ── Products (auto-slider) ── --}}
<section class="section products-section">
    <div class="container">
        <div class="products-tab-hd">
            <h2 class="section-title section-title-flush">Our Products</h2>
            <a href="{{ route('products.index') }}" class="view-all-link view-all-push">View All Products
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
        <div class="products-carousel-wrap">
            <button class="pc-arrow pc-prev" id="pcPrev" aria-label="Previous products">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="products-carousel" id="home-products">
                @foreach($featured as $product)
                @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
            <button class="pc-arrow pc-next" id="pcNext" aria-label="Next products">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>
</section>
<script>
(function(){
    var carousel = document.getElementById('home-products');
    if(!carousel) return;
    var prev = document.getElementById('pcPrev');
    var next = document.getElementById('pcNext');
    function getStep(){
        var card = carousel.querySelector('.product-card');
        if(!card) return 300;
        var gap = parseFloat(getComputedStyle(carousel).gap) || 20;
        return card.offsetWidth + gap;
    }
    function scrollNext(){
        var maxScroll = carousel.scrollWidth - carousel.clientWidth;
        if(carousel.scrollLeft >= maxScroll - 8){
            carousel.scrollTo({left:0, behavior:'smooth'});
        } else {
            carousel.scrollBy({left: getStep(), behavior:'smooth'});
        }
    }
    prev && prev.addEventListener('click', function(){ carousel.scrollBy({left:-getStep()*2,behavior:'smooth'}); });
    next && next.addEventListener('click', function(){ scrollNext(); });
    function update(){
        if(!prev || !next) return;
        prev.disabled = carousel.scrollLeft <= 4;
    }
    carousel.addEventListener('scroll', update, {passive:true});
    update();
    // Auto-play
    var timer = setInterval(scrollNext, 3500);
    carousel.addEventListener('mouseenter', function(){ clearInterval(timer); });
    carousel.addEventListener('mouseleave', function(){ timer = setInterval(scrollNext, 3500); });
    // Touch swipe
    var sx = null;
    carousel.addEventListener('pointerdown', function(e){ if(e.pointerType==='mouse') return; sx=e.clientX; clearInterval(timer); }, {passive:true});
    carousel.addEventListener('pointerup', function(e){
        if(sx===null||e.pointerType==='mouse') return;
        var dx=e.clientX-sx; sx=null;
        if(Math.abs(dx)<40){ timer=setInterval(scrollNext,3500); return; }
        carousel.scrollBy({left: dx<0?getStep()*2:-getStep()*2, behavior:'smooth'});
        timer=setInterval(scrollNext,3500);
    }, {passive:true});
})();
</script>

{{-- ── Cinnamon Feature Banner ── --}}
<div class="cinnamon-feature-banner">
    <div class="cfb-inner">
        <span class="cfb-label">Sri Lanka's Pride</span>
        <h2 class="cfb-title">Ceylon Cinnamon<br><em>World's Finest</em></h2>
        <p class="cfb-sub">Harvested from the heartland of Sri Lanka — the only true Ceylon cinnamon, with a delicate sweetness no other country can replicate.</p>
        <a href="{{ route('products.index', ['category' => 'ceylon-cinnamon']) }}" class="cfb-btn">
            Explore Cinnamon
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>
</div>

{{-- ── Categories ── --}}
<section class="section categories">
    <div class="container">
        <div class="section-head center">
            <span class="section-label">What We Export</span>
            <h2 class="section-title">Browse by Category</h2>
            <p class="section-sub">Explore our full range of natural products from Sri Lanka</p>
        </div>
        <div class="cat-grid">
            @foreach($categories as $cat)
            <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="cat-card">
                @if($cat->image)
                    <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}" loading="lazy" class="cat-bg-img">
                @else
                    <div class="cat-no-img">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.4)" stroke-width="1.5"><path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/></svg>
                    </div>
                @endif
                <div class="cat-label-bar">
                    <span class="cat-name">{{ $cat->name }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
