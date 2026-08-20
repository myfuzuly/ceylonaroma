{{-- ── Hero — Reference exact layout ── --}}
<section class="hero hero-split" id="heroSection">

    {{-- RIGHT: image slider (absolute, covers right 60%) --}}
    <div class="hs-right" id="hsRight">
        <div class="hs-slides">
            @forelse($slides as $i => $slide)
            <div class="hs-slide{{ $i === 0 ? ' active' : '' }}" data-index="{{ $i }}">
                <img src="{{ asset('storage/'.$slide->image) }}"
                     alt="{{ $slide->title ?? 'Ceylon Aroma' }}"
                     loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
            </div>
            @empty
            <div class="hs-slide active">
                <img src="/images/hero-visual.webp" alt="Ceylon Aroma Premium Products" loading="eager">
            </div>
            @endforelse
        </div>
        {{-- Cream fade — blends image left edge with text background --}}
        <div class="hs-fade"></div>
        {{-- Dot nav --}}
        @if($slides->count() > 1)
        <div class="hs-dots" id="hsDots">
            @foreach($slides as $i => $slide)
            <button class="hs-dot{{ $i === 0 ? ' active' : '' }}"
                    data-index="{{ $i }}"
                    aria-label="Slide {{ $i + 1 }}"></button>
            @endforeach
        </div>
        @endif
    </div>

    {{-- BADGE — positioned at image left boundary --}}
    <div class="hero-purity-badge">
        <div class="hpb-pct">100%</div>
        <div class="hpb-label">Pure Ceylon<br>Goodness</div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="hpb-leaf"><path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/></svg>
    </div>

    {{-- LEFT: text panel (relative, z above image) --}}
    <div class="hs-left">
        <div class="hs-left-inner">
            <div class="hero-eyebrow">
                <span class="hero-eyebrow-dot"></span>
                Premium Quality Export
            </div>
            <h1 class="hero-title">
                Delivering the<br>
                Natural <em>Taste &amp; Aroma</em><br>
                of Sri Lanka to the World
            </h1>
            <p class="hero-desc">
                Premium spices, teas, oils and natural products from the
                fertile highlands of Sri Lanka — crafted for global export
                with certified quality and authenticity.
            </p>
            <div class="hero-cta">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    Explore Products
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline">
                    Get Export Quote
                </a>
            </div>
            <div class="hero-trust">
                <div class="hero-trust-item">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    ISO Certified
                </div>
                <div class="hero-trust-item">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                    60+ Countries
                </div>
                <div class="hero-trust-item">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    25+ Years Experience
                </div>
            </div>
        </div>
    </div>

</section>

{{-- Slider JS --}}
@if($slides->count() > 1)
<script>
(function(){
    var slides = Array.from(document.querySelectorAll('.hs-slide'));
    var dots   = Array.from(document.querySelectorAll('.hs-dot'));
    var n = slides.length, cur = 0, timer = null;
    if(n < 2) return;
    function go(i){
        slides[cur].classList.remove('active');
        dots[cur] && dots[cur].classList.remove('active');
        cur = (i + n) % n;
        slides[cur].classList.add('active');
        dots[cur] && dots[cur].classList.add('active');
    }
    function play(){ timer = setInterval(function(){ go(cur+1); }, 5500); }
    function pause(){ clearInterval(timer); }
    play();
    dots.forEach(function(d,i){ d.addEventListener('click',function(){ pause(); go(i); play(); }); });
    var sx = null, el = document.getElementById('hsRight');
    el.addEventListener('pointerdown',function(e){ if(e.pointerType==='mouse') return; sx=e.clientX; },{passive:true});
    el.addEventListener('pointerup',  function(e){
        if(sx===null||e.pointerType==='mouse') return;
        var dx=e.clientX-sx; sx=null;
        if(Math.abs(dx)<40) return;
        pause(); go(dx<0?cur+1:cur-1); play();
    },{passive:true});
})();
</script>
@endif

{{-- ── Stats Bar ── --}}
<div class="stats-bar">
    <div class="stats-inner">
        <div class="stat-item">
            <div class="stat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg></div>
            <div class="stat-text">
                <div class="stat-num" data-to="60" data-plus="+">60+</div>
                <div class="stat-label">Countries Exported</div>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg></div>
            <div class="stat-text">
                <div class="stat-num" data-to="500" data-plus="+">500+</div>
                <div class="stat-label">Premium Products</div>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="6"/><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"/></svg></div>
            <div class="stat-text">
                <div class="stat-num" data-to="25" data-plus="+">25+</div>
                <div class="stat-label">Years of Excellence</div>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
            <div class="stat-text">
                <div class="stat-num" data-to="200" data-plus="+">200+</div>
                <div class="stat-label">Global Partners</div>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg></div>
            <div class="stat-text">
                <div class="stat-num">ISO</div>
                <div class="stat-label">Certified Quality</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Trust / Certification Bar ── --}}
<div class="trust-bar">
    <div class="trust-inner">
        <span class="trust-title">Certified &amp; Compliant</span>
        <div class="trust-certs">
            <div class="trust-cert">
                <svg class="tc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                <span>ISO 22000</span>
            </div>
            <div class="trust-cert">
                <svg class="tc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                <span>HACCP</span>
            </div>
            <div class="trust-cert">
                <svg class="tc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/></svg>
                <span>Organic</span>
            </div>
            <div class="trust-cert">
                <svg class="tc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>Fair Trade</span>
            </div>
            <div class="trust-cert">
                <svg class="tc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 12l2 2 4-4"/></svg>
                <span>SLSI Approved</span>
            </div>
            <div class="trust-cert">
                <svg class="tc-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                <span>Export Ready</span>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
  var nums = document.querySelectorAll('.stat-num[data-to]');
  if(!nums.length) return;
  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(!e.isIntersecting) return;
      var el = e.target;
      var to = parseInt(el.getAttribute('data-to'));
      var plus = el.getAttribute('data-plus') || '';
      var dur = 1400, start = null;
      function tick(now){
        if(!start) start = now;
        var pct = Math.min((now - start) / dur, 1);
        var ease = 1 - Math.pow(1 - pct, 3);
        el.textContent = Math.round(ease * to) + plus;
        if(pct < 1) requestAnimationFrame(tick);
      }
      requestAnimationFrame(tick);
      io.unobserve(el);
    });
  }, {threshold:0.5});
  nums.forEach(function(el){ io.observe(el); });
})();
</script>
