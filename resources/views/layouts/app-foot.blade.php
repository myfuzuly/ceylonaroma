{{-- ── Pre-footer CTA Strip ── --}}
<section class="footer-cta-strip">
    <div class="footer-cta-img-inset" aria-hidden="true"></div>
    <div class="container">
        <div class="footer-cta-inner">
            <div class="footer-cta-text">
                <span class="footer-cta-eyebrow">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    Certified Export Partner &middot; Sri Lanka
                </span>
                <h3 class="footer-cta-heading">Ready to Import<br><em>Premium Ceylon Products?</em></h3>
                <p>Partner with us for certified, high-quality natural products trusted by importers in 60+ countries worldwide.</p>
                <div class="footer-cta-stats">
                    <div class="footer-cta-stat"><strong>60+</strong><span>Countries</span></div>
                    <div class="footer-cta-stat"><strong>ISO 22000</strong><span>Food Safety</span></div>
                    <div class="footer-cta-stat"><strong>25+</strong><span>Yrs Experience</span></div>
                </div>
            </div>

            @if(request()->routeIs('home'))
            @php
                $footerWp = \App\Models\WholesalePrice::with('product')
                    ->whereHas('product', fn($q) => $q->where('status', true))
                    ->orderByDesc('updated_at')->get()->unique('product_id')
                    ->take(5);
                $footerWpDate = $footerWp->max('updated_at');
            @endphp
            @if($footerWp->count())
            <div class="wp-mini-card">
                <div class="wp-mini-head">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                    Wholesale Prices
                </div>
                <table class="wp-mini-table">
                    <tbody>
                        @foreach($footerWp as $wp)
                        <tr>
                            <td class="wp-mini-name">{{ $wp->product->name }}</td>
                            <td class="wp-mini-price">{{ $wp->currency }} {{ number_format($wp->price, 2) }}<span>/{{ $wp->unit }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('wholesale-prices.index') }}" class="wp-mini-link">
                    View Full Price List
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                @if($footerWpDate)
                <div class="wp-mini-updated">Last updated {{ $footerWpDate->format('d M Y') }}</div>
                @endif
            </div>
            @endif
            @endif

            <div class="footer-cta-actions">
                <a href="{{ route('contact') }}" class="btn btn-gold footer-cta-btn-primary">
                    Request Export Quote
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                <a href="tel:+{{ $settings['phone_whatsapp'] ?? '94718821234' }}" class="btn btn-outline-white footer-cta-btn-secondary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 013.09 5.18 2 2 0 015.09 3h3a2 2 0 012 1.72c.127.96.36 1.903.7 2.81a2 2 0 01-.45 2.11L9.09 11a16 16 0 006.91 6.91l1.27-1.27a2 2 0 012.11-.45c.907.34 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    +94 71 882 1234
                </a>
                <a href="https://wa.me/{{ $settings['phone_whatsapp'] ?? '94718821234' }}" target="_blank" rel="noopener" class="footer-cta-whatsapp">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    WhatsApp Us
                </a>
                <span class="footer-cta-note">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Response within 24 hours
                </span>
            </div>
        </div>
    </div>
</section>

{{-- ── Footer ── --}}
<footer class="footer" role="contentinfo">
    <div class="footer-top">
        <div class="container">
            <div class="footer-grid-5">
                {{-- Brand --}}
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo" aria-label="Ceylon Aroma Home">
                        <img src="/images/ceylonaroma4.png" alt="Ceylon Aroma" class="logo-img logo-img-footer">
                    </a>
                    <p class="footer-tagline">We are a leading exporter of premium quality spices, tea, coffee, oils and natural products from Sri Lanka.</p>
                    <div class="footer-socials">
                        @if(!empty($settings['facebook_url']) && $settings['facebook_url'] !== '#')
                        <a href="{{ $settings['facebook_url'] }}" class="footer-social" target="_blank" rel="noopener" aria-label="Facebook"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
                        @endif
                        @if(!empty($settings['instagram_url']) && $settings['instagram_url'] !== '#')
                        <a href="{{ $settings['instagram_url'] }}" class="footer-social" target="_blank" rel="noopener" aria-label="Instagram"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                        @endif
                        @if(!empty($settings['linkedin_url']) && $settings['linkedin_url'] !== '#')
                        <a href="{{ $settings['linkedin_url'] }}" class="footer-social" target="_blank" rel="noopener" aria-label="LinkedIn"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
                        @endif
                        @if(!empty($settings['youtube_url']) && $settings['youtube_url'] !== '#')
                        <a href="{{ $settings['youtube_url'] }}" class="footer-social" target="_blank" rel="noopener" aria-label="YouTube"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.97C18.88 4 12 4 12 4s-6.88 0-8.59.45A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.4a2.78 2.78 0 001.95-1.97A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#0F2920"/></svg></a>
                        @endif
                    </div>
                    <div class="cert-logos">
                        <a href="{{ route('quality') }}" class="cert-badge" title="ISO 22000:2018 Food Safety Management">ISO 22000</a>
                        <a href="{{ route('quality') }}" class="cert-badge" title="Hazard Analysis Critical Control Points">HACCP</a>
                        <a href="{{ route('quality') }}" class="cert-badge" title="USDA National Organic Programme">USDA NOP</a>
                        <a href="{{ route('quality') }}" class="cert-badge" title="EU Organic Regulation">EU Organic</a>
                        <a href="{{ route('quality') }}" class="cert-badge" title="Good Manufacturing Practice">GMP</a>
                    </div>
                </div>
                {{-- Products --}}
                <div class="footer-col">
                    <h5>Products</h5>
                    <div class="footer-links">
                        <a href="{{ route('products.category', 'premium-ceylon-spices') }}">Premium Ceylon Spices</a>
                        <a href="{{ route('products.category', 'ceylon-coffee') }}">Ceylon Coffee</a>
                        <a href="{{ route('products.category', 'ceylon-tea') }}">Ceylon Tea</a>
                        <a href="{{ route('products.category', 'ceylon-essential-oils') }}">Ceylon Essential Oils</a>
                        <a href="{{ route('products.category', 'frozen-pulps') }}">Frozen Pulp</a>
                        <a href="{{ route('products.category', 'dehydrated-products') }}">Dehydrated Products</a>
                        <a href="{{ route('products.category', 'dates-nuts') }}">Dates &amp; Nuts</a>
                    </div>
                </div>
                {{-- Company --}}
                <div class="footer-col">
                    <h5>Company</h5>
                    <div class="footer-links">
                        <a href="{{ route('about') }}">About Us</a>
                        <a href="{{ route('quality') }}">Quality Assurance</a>
                        <a href="{{ route('quality') }}">Our Certifications</a>
                        <a href="{{ route('export') }}">Export Capabilities</a>
                        <a href="{{ route('contact') }}">Contact Us</a>
                    </div>
                </div>
                {{-- Export --}}
                <div class="footer-col">
                    <h5>Export</h5>
                    <div class="footer-links">
                        <a href="{{ route('export') }}">Export Process</a>
                        <a href="{{ route('private-label') }}">Private Label</a>
                        <a href="{{ route('quality') }}">Our Certifications</a>
                        <a href="{{ route('export') }}">Shipping &amp; Delivery</a>
                        <a href="{{ route('returns') }}">Return &amp; Quality Claims</a>
                        <a href="{{ route('terms') }}">Terms &amp; Conditions</a>
                    </div>
                </div>
                {{-- Contact --}}
                <div class="footer-col">
                    <h5>Contact Us</h5>
                    <div class="footer-contact-item">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>{{ $settings['site_address'] ?? 'No: F – 05, New City Building, Nidahas Mawatha, Kegalle, Sri Lanka' }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 013.09 5.18 2 2 0 015.09 3h3a2 2 0 012 1.72c.127.96.36 1.903.7 2.81a2 2 0 01-.45 2.11L9.09 11a16 16 0 006.91 6.91l1.27-1.27a2 2 0 012.11-.45c.907.34 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                        <span><a href="tel:+{{ $settings['phone_whatsapp'] ?? '94718821234' }}" class="footer-tel">+94 71 882 1234</a> (Mobile / WhatsApp)</span>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2A19.79 19.79 0 013.09 5.18 2 2 0 015.09 3h3a2 2 0 012 1.72c.127.96.36 1.903.7 2.81a2 2 0 01-.45 2.11L9.09 11a16 16 0 006.91 6.91l1.27-1.27a2 2 0 012.11-.45c.907.34 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                        <span><a href="tel:+94354341234" class="footer-tel">+94 35 434 1234</a> (Landline)</span>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span><a href="mailto:{{ $settings['site_email'] ?? 'info@ceylonaroma.com' }}" class="footer-tel">{{ $settings['site_email'] ?? 'info@ceylonaroma.com' }}</a></span>
                    </div>
                    <div class="footer-contact-cta">
                        <a href="{{ route('contact') }}" class="btn btn-gold btn-sm">Request a Quote</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Ceylon Aroma' }} (Pvt) Ltd. All Rights Reserved.</span>
            <span class="footer-credit">Engineered by <a href="https://fidhaps.com" target="_blank" rel="noopener" class="footer-credit-link">FIDHAPS</a></span>
            <div class="footer-bottom-links">
                <a href="{{ route('privacy') }}">Privacy Policy</a>
                <a href="{{ route('terms') }}">Terms &amp; Conditions</a>
                <a href="{{ route('returns') }}">Return Policy</a>
            </div>
        </div>
    </div>
</footer>

{{-- ── Back to Top ── --}}
<button type="button" id="back-to-top" class="back-to-top" aria-label="Back to top" title="Back to top">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
</button>
<script>
(function(){
    var btn = document.getElementById('back-to-top');
    if(!btn) return;
    window.addEventListener('scroll', function(){ btn.classList.toggle('btt-visible', window.scrollY > 400); }, {passive:true});
    btn.addEventListener('click', function(){ window.scrollTo({top:0, behavior:'smooth'}); });
})();
</script>

@stack('scripts')
<script>
if('serviceWorker' in navigator){
    navigator.serviceWorker.register('/sw.js').catch(function(){});
}
</script>

{{-- ── Cookie Consent Banner ── --}}
<div id="cookie-banner" class="cookie-banner" aria-live="polite" aria-label="Cookie consent" role="dialog" aria-modal="false" hidden>
    <div class="cookie-banner-inner">
        <div class="cookie-banner-text">
            <svg class="cb-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <p>We use essential cookies to keep the site secure and remember your preferences. By continuing, you agree to our <a href="{{ route('privacy') }}" class="cb-link">Privacy Policy</a>.</p>
        </div>
        <div class="cookie-banner-actions">
            <button id="cb-accept" class="cb-btn-accept" type="button">Accept All</button>
            <button id="cb-necessary" class="cb-btn-necessary" type="button">Necessary Only</button>
        </div>
        <button id="cb-close" class="cb-close" type="button" aria-label="Close cookie notice">&times;</button>
    </div>
</div>
<script>
(function(){
    var KEY = 'ca_cookie_consent';
    var banner = document.getElementById('cookie-banner');
    if(!banner || localStorage.getItem(KEY)) return;
    var t = setTimeout(function(){ banner.removeAttribute('hidden'); banner.classList.add('cb-visible'); }, 900);
    function dismiss(val){
        clearTimeout(t);
        localStorage.setItem(KEY, val);
        banner.classList.remove('cb-visible');
        banner.classList.add('cb-hiding');
        setTimeout(function(){ banner.setAttribute('hidden',''); }, 350);
    }
    document.getElementById('cb-accept').addEventListener('click', function(){ dismiss('all'); });
    document.getElementById('cb-necessary').addEventListener('click', function(){ dismiss('necessary'); });
    document.getElementById('cb-close').addEventListener('click', function(){ dismiss('necessary'); });
})();
</script>
</body>
</html>
