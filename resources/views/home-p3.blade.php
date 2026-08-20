{{-- ── Discover Coffee CTA — Premium ── --}}
<section class="ccta-section">
    {{-- Right half: coffee photograph --}}
    <div class="ccta-img" style="background-image:url('/images/coffee-cta.webp')" aria-hidden="true"></div>
    {{-- Left half: text content --}}
    <div class="ccta-content">
        <div class="ccta-inner">
            <span class="ccta-eyebrow">
                <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Single Origin &middot; Highland Grown
            </span>
            <h2 class="ccta-heading">
                Discover Authentic<br>
                <em>Ceylon Coffee</em>
            </h2>
            <p class="ccta-desc">Grown in the misty highlands of Sri Lanka at elevations above 1,200m — rich body, bright acidity, and a sweetness that no other origin can replicate.</p>
            <div class="ccta-feats">
                <span class="ccta-feat">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    Shade-Grown Arabica
                </span>
                <span class="ccta-feat">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    Washed &amp; Natural Process
                </span>
                <span class="ccta-feat">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    Specialty Grade &amp; Bulk Export
                </span>
            </div>
            <div class="ccta-actions">
                <a href="{{ route('products.index', ['category' => 'ceylon-coffee']) }}" class="ccta-btn-primary">
                    Explore Ceylon Coffee
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="{{ route('contact') }}" class="ccta-btn-secondary">Request Sample</a>
            </div>
        </div>
    </div>
</section>

{{-- ── Export Process ── --}}
<section class="section export-process">
    <div class="container">
        <div class="section-head center section-head-xl">
            <span class="section-label">How It Works</span>
            <h2 class="section-title">Our Export Process</h2>
            <p class="section-sub">From our farms to your hands — with care and quality</p>
        </div>
        <div class="process-row">
            <div class="process-line"></div>
            @foreach([
                ['01','Sourcing','Carefully selected from trusted farmers across Sri Lanka','<path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/>'],
                ['02','Processing','Cleaned and processed with modern technology','<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>'],
                ['03','Quality Check','Strict quality control to ensure purity and ISO standards','<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>'],
                ['04','Packaging','Hygienic &amp; premium packaging solutions for every market','<path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>'],
                ['05','Export','Delivered to your country safely &amp; on time','<rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>'],
            ] as [$num, $title, $desc, $svg])
            <div class="process-step-wrap">
                <div class="process-num">{{ $num }}</div>
                <div class="process-icon-wrap">
                    <div class="process-icon-circle">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">{!! $svg !!}</svg>
                    </div>
                </div>
                <div class="process-title">{{ $title }}</div>
                <p class="process-desc">{!! $desc !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Core Values Infographic ── --}}
<section class="core-values-section">
    <div class="container">
        <img src="/images/core-values.png"
             alt="Our Core Values — Authenticity, Purity, Sustainability, Quality, Trust"
             loading="lazy" class="core-values-img">
    </div>
</section>

{{-- ── Testimonials (hidden — review later) ── --}}
{{-- <section class="section testimonials-section"> --}}
@if(false)<section class="section testimonials-section">
    <div class="container">
        <div class="section-head center">
            <span class="section-label">What Importers Say</span>
            <h2 class="section-title">Trusted by Global Buyers</h2>
            <p class="section-sub">Real feedback from importers across 60+ countries who partner with us year after year</p>
        </div>
        <div class="testi-grid">
            <div class="testi-card reveal">
                <div class="testi-stars">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <blockquote class="testi-quote">"We've been importing Ceylon cinnamon and black pepper from Ceylon Aroma for six years. The consistency in quality is outstanding — every shipment passes our EU certification checks without issue."</blockquote>
                <div class="testi-author">
                    <div class="testi-flag">🇩🇪</div>
                    <div>
                        <div class="testi-name">Klaus Meier</div>
                        <div class="testi-role">Import Director, BioSpice GmbH — Germany</div>
                    </div>
                </div>
            </div>
            <div class="testi-card reveal reveal-delay-1">
                <div class="testi-stars">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <blockquote class="testi-quote">"Their private label service saved us 4 months of sourcing time. The Ceylon tea we import is selling brilliantly in our premium retail chain. Reliable partner, transparent documentation."</blockquote>
                <div class="testi-author">
                    <div class="testi-flag">🇦🇺</div>
                    <div>
                        <div class="testi-name">Sarah O'Brien</div>
                        <div class="testi-role">Procurement Head, NaturePure Co. — Australia</div>
                    </div>
                </div>
            </div>
            <div class="testi-card reveal reveal-delay-2">
                <div class="testi-stars">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <blockquote class="testi-quote">"From inquiry to delivery, the team at Ceylon Aroma is professional and responsive. We import cloves, cardamom, and vanilla — all impeccably packed and HACCP certified. Highly recommended."</blockquote>
                <div class="testi-author">
                    <div class="testi-flag">🇯🇵</div>
                    <div>
                        <div class="testi-name">Hiroshi Tanaka</div>
                        <div class="testi-role">Supply Chain Manager, Nakamura Foods — Japan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>@endif

{{-- ── Knowledge Centre — Premium ── --}}
@if($posts->count())
<section class="kcp-section">
    <div class="kcp-pattern" aria-hidden="true"></div>
    <div class="container">
        <div class="kcp-header">
            <div>
                <span class="section-label kcp-label">Insights &amp; Expertise</span>
                <h2 class="kcp-title">Knowledge Center</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="kcp-view-all">
                View All Articles
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
        <div class="kcp-grid">
            @foreach($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="kcp-card">
                <div class="kcp-img">
                    @if($post->image)
                        <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" loading="lazy">
                    @else
                        @php
                        $kcpPlaceholders = ['/images/blog-spices.webp','/images/blog-tea.jpg','/images/blog-coffee.webp','/images/blog-cinnamon.jpg','/images/blog-clove.jpg'];
                        @endphp
                        <img src="{{ $kcpPlaceholders[$loop->index % count($kcpPlaceholders)] }}" alt="{{ $post->title }}" loading="lazy" class="blog-placeholder-img">
                    @endif
                    @if($post->category)<span class="kcp-cat">{{ $post->category }}</span>@endif
                </div>
                <div class="kcp-body">
                    <div class="kcp-date">{{ $post->published_at?->format('M d, Y') }}</div>
                    <h3 class="kcp-post-title">{{ $post->title }}</h3>
                    @if($post->excerpt)<p class="kcp-excerpt">{{ $post->excerpt }}</p>@endif
                    <span class="kcp-read-more">
                        Read Article
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
