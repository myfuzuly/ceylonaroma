<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

@php
  $siteName    = $settings['site_name']    ?? 'Ceylon Aroma';
  $siteUrl     = 'https://ceylonaroma.com';
  $pageTitle   = trim(strip_tags(View::yieldContent('title'))) ?: 'Premium Ceylon Spices, Tea & Coffee Exporter';
  $metaTitle   = $pageTitle . ' | ' . $siteName . ' — Sri Lanka Export';
  $metaDesc    = View::yieldContent('meta_description')
                 ?: ($settings['meta_description'] ?? 'Ceylon Aroma exports premium Ceylon cinnamon, spices, tea, coffee and natural products from Sri Lanka to 60+ countries. ISO certified. Request a wholesale quote today.');
  $metaImage   = View::yieldContent('og_image') ?: $siteUrl . '/images/og-ceylon-aroma.jpg';
  $canonicalUrl = $siteUrl . request()->getPathInfo();
@endphp

<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDesc }}">
<meta name="keywords" content="{{ $settings['meta_keywords'] ?? 'Ceylon cinnamon exporter, Sri Lanka spices wholesale, Ceylon tea supplier, Ceylon coffee export, natural products Sri Lanka, spice exporters Sri Lanka' }}">
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
<link rel="canonical" href="{{ $canonicalUrl }}">
<link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.php">

{{-- Open Graph --}}
<meta property="og:type"        content="@yield('og_type', 'website')">
<meta property="og:site_name"   content="{{ $siteName }}">
<meta property="og:title"       content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDesc }}">
<meta property="og:url"         content="{{ $canonicalUrl }}">
<meta property="og:image"       content="{{ $metaImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale"      content="en_US">

{{-- Twitter Card --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDesc }}">
<meta name="twitter:image"       content="{{ $metaImage }}">

{{-- JSON-LD: Organization + WebSite --}}
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "{{ $siteUrl }}/#organization",
      "name": "Ceylon Aroma",
      "url": "{{ $siteUrl }}",
      "logo": {
        "@type": "ImageObject",
        "url": "{{ $siteUrl }}/images/logo.png"
      },
      "description": "Premium Sri Lanka spice, tea, coffee and natural product exporter serving 60+ countries worldwide.",
      "foundingDate": "2009",
      "areaServed": "Worldwide",
      "knowsAbout": ["Ceylon Cinnamon","Ceylon Tea","Ceylon Coffee","Spices Export","Natural Products"],
      "contactPoint": {
        "@type": "ContactPoint",
        "contactType": "sales",
        "areaServed": "Worldwide",
        "availableLanguage": "English"
      },
      "address": {
        "@type": "PostalAddress",
        "addressCountry": "LK"
      },
      "sameAs": []
    },
    {
      "@type": "WebSite",
      "@id": "{{ $siteUrl }}/#website",
      "url": "{{ $siteUrl }}",
      "name": "{{ $siteName }}",
      "publisher": { "@id": "{{ $siteUrl }}/#organization" },
      "potentialAction": {
        "@type": "SearchAction",
        "target": {
          "@type": "EntryPoint",
          "urlTemplate": "{{ $siteUrl }}/products?search={search_term_string}"
        },
        "query-input": "required name=search_term_string"
      }
    }
  ]
}
</script>
@stack('schema')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,600;0,700;0,800;1,700;1,800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/bundle.css', 'resources/js/app.js'])
@stack('head')
</head>
<body>

{{-- ── Topbar ── --}}
<div class="topbar">
    <div class="topbar-inner">
        <div class="topbar-usps">
            <span class="topbar-usp">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/></svg>
                Delivering Natural Goodness of Sri Lanka to the World
            </span>
            <span class="topbar-usp">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                Exporting to 60+ Countries
            </span>
            <span class="topbar-usp">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                100% Natural &amp; Pure
            </span>
            <span class="topbar-usp">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Certified Quality
            </span>
        </div>
        <div class="topbar-right">
            <div class="topbar-lang">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                <select aria-label="Language">
                    <option value="en">EN</option>
                    <option value="si">SI</option>
                </select>
            </div>
            <a href="{{ route('contact') }}" class="topbar-cta">EXPORT INQUIRY
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</div>

{{-- ── Nav ── --}}
<nav class="nav" role="navigation">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="logo" aria-label="Ceylon Aroma Home">
            <img src="/images/ceylonaroma3.png" alt="Ceylon Aroma" class="logo-img">
        </a>

        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
@php
  if(empty($navCategories) || $navCategories->isEmpty()){
    try{
      $navCategories = \App\Models\Category::where('status',true)
        ->whereNull('parent_id')
        ->with(['children'=>function($q){ $q->where('status',true)->orderBy('sort_order'); }])
        ->orderBy('sort_order')->get();
    } catch(\Throwable $e){ $navCategories = collect(); }
  }
@endphp
            <div class="nav-dropdown nav-mega-wrap">
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    Products
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                </a>
                <div class="nav-mega">
                    <div class="nav-mega-inner">
                        {{-- View all bar --}}
                        <div class="nav-mega-topbar">
                            <span class="nav-mega-heading">Our Product Categories</span>
                            <a href="{{ route('products.index') }}" class="nav-mega-all">
                                View All Products
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                        {{-- Category columns --}}
                        <div class="nav-mega-grid">
                            @foreach($navCategories ?? [] as $cat)
                            <div class="nav-mega-col">
                                <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                                   class="nav-mega-cat {{ request()->is('products*') && request('category') === $cat->slug ? 'active' : '' }}">
                                    {{ $cat->name }}
                                </a>
                                @if($cat->children->isNotEmpty())
                                <ul class="nav-mega-subs">
                                    @foreach($cat->children as $sub)
                                    <li>
                                        <a href="{{ route('products.index', ['category' => $sub->slug]) }}"
                                           class="{{ request()->is('products*') && request('category') === $sub->slug ? 'active' : '' }}">
                                            <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                                            {{ $sub->name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('export') }}" class="nav-link {{ request()->routeIs('export') ? 'active' : '' }}">Export</a>
            <a href="{{ route('quality') }}" class="nav-link {{ request()->routeIs('quality') ? 'active' : '' }}">Quality</a>
            <a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
            <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
        </div>

        <div class="nav-actions">
            <button class="nav-search-btn" aria-label="Search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
            {{-- Cart icon --}}
            <a href="{{ route('cart.index') }}" class="nav-cart-btn" aria-label="Cart" id="nav-cart-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                @php $cartCount = count(session('cart',[])); @endphp
                @if($cartCount > 0)
                    <span class="nav-cart-badge" id="nav-cart-badge">{{ $cartCount }}</span>
                @else
                    <span class="nav-cart-badge nav-cart-badge-hidden" id="nav-cart-badge">0</span>
                @endif
            </a>
            {{-- Customer Account --}}
            @if(session('customer_id'))
                <div class="nav-account-wrap">
                    <button class="nav-account-btn" aria-label="My Account">
                        @if(session('customer_avatar'))
                            <img src="{{ session('customer_avatar') }}" alt="{{ session('customer_name') }}" class="nav-account-avatar">
                        @else
                            <span class="nav-account-initial">{{ strtoupper(substr(session('customer_name','?'),0,1)) }}</span>
                        @endif
                    </button>
                    <div class="nav-account-dropdown">
                        <div class="nav-account-name">{{ session('customer_name') }}</div>
                        <a href="{{ route('customer.dashboard') }}" class="nav-account-link">Dashboard</a>
                        <a href="{{ route('customer.orders') }}" class="nav-account-link">My Orders</a>
                        <a href="{{ route('customer.profile') }}" class="nav-account-link">Profile</a>
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button type="submit" class="nav-account-link nav-account-logout">Sign Out</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('customer.login') }}" class="nav-account-btn nav-login-btn" aria-label="Login">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </a>
            @endif
            <a href="{{ route('contact') }}" class="btn btn-primary btn-sm nav-cta-btn">
                Request Quote
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        <button class="hamburger" aria-label="Open menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- Mobile overlay + drawer --}}
<div class="mobile-overlay" aria-hidden="true"></div>
<div class="mobile-nav" role="dialog" aria-label="Mobile menu">
    <div class="mobile-nav-header">
        <a href="{{ route('home') }}" class="logo" aria-label="Ceylon Aroma Home">
            <img src="/images/ceylonaroma3.png" alt="Ceylon Aroma" class="logo-img">
        </a>
        <button class="mobile-close" aria-label="Close menu">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
    <div class="mobile-links">
        <a href="{{ route('home') }}"          class="mobile-link">Home</a>
        <a href="{{ route('about') }}"         class="mobile-link">About Us</a>

        {{-- Products accordion --}}
        <div class="mobile-accordion">
            <button class="mobile-link mobile-accordion-btn" aria-expanded="false">
                Products
                <svg class="mobile-acc-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="mobile-accordion-body">
                <a href="{{ route('products.index') }}" class="mobile-sub-link mobile-sub-all">All Products →</a>
                @foreach($navCategories ?? [] as $cat)
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="mobile-sub-link mobile-sub-cat">{{ $cat->name }}</a>
                @if($cat->children->isNotEmpty())
                    @foreach($cat->children as $sub)
                    <a href="{{ route('products.index', ['category' => $sub->slug]) }}" class="mobile-sub-link mobile-sub-sub">↳ {{ $sub->name }}</a>
                    @endforeach
                @endif
                @endforeach
            </div>
        </div>

        <a href="{{ route('export') }}"        class="mobile-link">Export</a>
        <a href="{{ route('quality') }}"       class="mobile-link">Quality</a>
        <a href="{{ route('blog.index') }}"    class="mobile-link">Blog</a>
        <a href="{{ route('contact') }}"       class="mobile-link">Contact Us</a>
    </div>
    <div class="mobile-actions">
        <a href="{{ route('cart.index') }}" class="btn btn-outline">
            Cart
            @if(count(session('cart',[])) > 0)
                <span class="nav-cart-badge">{{ count(session('cart',[])) }}</span>
            @endif
        </a>
        @if(session('customer_id'))
            <a href="{{ route('customer.dashboard') }}" class="btn btn-outline">My Account</a>
        @else
            <a href="{{ route('customer.login') }}" class="btn btn-outline">Login / Register</a>
        @endif
        <a href="{{ route('contact') }}" class="btn btn-primary">Export Inquiry</a>
    </div>
</div>

{{-- ── Sticky Mobile Bottom Nav Bar ── --}}
<nav class="mob-nav-bar" aria-label="Mobile navigation">
    <a href="{{ route('home') }}" class="mob-nav-item {{ request()->routeIs('home') ? 'active' : '' }}" aria-label="Home">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Home</span>
    </a>
    <a href="{{ route('products.index') }}" class="mob-nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}" aria-label="Products">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        <span>Products</span>
    </a>
    <a href="{{ route('contact') }}" class="mob-nav-quote" aria-label="Get Quote">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        <span>Quote</span>
    </a>
    <a href="{{ route('cart.index') }}" class="mob-nav-item {{ request()->routeIs('cart.*') ? 'active' : '' }}" aria-label="Cart">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
        @if(count(session('cart',[])) > 0)
            <span class="mob-nav-badge">{{ count(session('cart',[])) }}</span>
        @endif
        <span>Cart</span>
    </a>
    <button class="mob-nav-item" id="mobNavMenu" aria-label="Menu" aria-expanded="false">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        <span>Menu</span>
    </button>
</nav>
<script>
(function(){
  /* ── Mobile accordion ── */
  var accBtn  = document.querySelector('.mobile-accordion-btn');
  var accBody = document.querySelector('.mobile-accordion-body');
  if(accBtn && accBody){
    accBtn.addEventListener('click',function(){
      var open = accBody.classList.toggle('open');
      accBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  /* ── Desktop mega-menu ── */
  var wrap = document.querySelector('.nav-mega-wrap');
  if(!wrap) return;
  var mega  = wrap.querySelector('.nav-mega');
  var nav   = document.querySelector('nav.nav, nav, .nav');
  var timer = null;

  /* Position mega below the nav bar */
  function positionMega(){
    if(!nav || !mega) return;
    var bottom = nav.getBoundingClientRect().bottom;
    mega.style.top = bottom + 'px';
  }

  function openMenu(){
    clearTimeout(timer);
    positionMega();
    wrap.classList.add('mega-open');
  }
  function closeMenu(){
    timer = setTimeout(function(){ wrap.classList.remove('mega-open'); }, 150);
  }

  wrap.addEventListener('mouseenter', openMenu);
  wrap.addEventListener('mouseleave', closeMenu);
  wrap.addEventListener('focusin',    openMenu);
  wrap.addEventListener('focusout',   closeMenu);

  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape') wrap.classList.remove('mega-open');
  });
  document.addEventListener('click', function(e){
    if(!wrap.contains(e.target)) wrap.classList.remove('mega-open');
  });

  window.addEventListener('scroll', positionMega, {passive:true});
  window.addEventListener('resize', positionMega, {passive:true});
})();
(function(){
  /* ── Account dropdown ── */
  var aw = document.querySelector('.nav-account-wrap');
  if(!aw) return;
  var btn = aw.querySelector('.nav-account-btn');
  var dd  = aw.querySelector('.nav-account-dropdown');
  btn.addEventListener('click', function(e){
    e.stopPropagation();
    dd.classList.toggle('open');
  });
  document.addEventListener('click', function(){ dd.classList.remove('open'); });
})();
document.addEventListener('DOMContentLoaded',function(){
  var rev = document.querySelectorAll('.reveal');
  if(!rev.length) return;
  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(e){
      if(e.isIntersecting){ e.target.classList.add('visible'); io.unobserve(e.target); }
    });
  }, {threshold:0.1});
  rev.forEach(function(el){ io.observe(el); });
});
(function(){
  /* ── Bottom nav menu button → opens mobile drawer ── */
  var mobMenuBtn = document.getElementById('mobNavMenu');
  var mobileBtn  = document.querySelector('.hamburger');
  if(mobMenuBtn && mobileBtn){
    mobMenuBtn.addEventListener('click',function(){ mobileBtn.click(); });
  }
})();
</script>

{{-- ── Floating WhatsApp Quick-Contact Widget (left side) ── --}}
<div class="wa-widget" id="waWidget" aria-label="WhatsApp Chat">
    <button class="wa-toggle" id="waToggle" aria-label="Open WhatsApp chat" aria-expanded="false">
        <svg class="wa-icon-wa" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.096.537 4.066 1.481 5.786L.057 23.882a.5.5 0 00.613.613l6.196-1.424A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.947 9.947 0 01-5.073-1.388l-.363-.214-3.779.868.883-3.68-.236-.38A9.959 9.959 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
        <svg class="wa-icon-close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#fff" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="wa-panel" id="waPanel">
        <div class="wa-panel-head">
            <div class="wa-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.096.537 4.066 1.481 5.786L.057 23.882a.5.5 0 00.613.613l6.196-1.424A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.947 9.947 0 01-5.073-1.388l-.363-.214-3.779.868.883-3.68-.236-.38A9.959 9.959 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
            </div>
            <div class="wa-head-text">
                <div class="wa-head-name">Ceylon Aroma</div>
                <div class="wa-head-status">Typically replies within minutes</div>
            </div>
        </div>
        <div class="wa-panel-body">
            <div class="wa-bubble">
                <p>Hello! 👋 I'm interested in your products. Can you help me with an export inquiry?</p>
            </div>
        </div>
        <div class="wa-panel-foot">
            <a class="wa-chat-btn" href="https://wa.me/94718821234?text=Hello%20Ceylon%20Aroma%2C%20I%20am%20interested%20in%20your%20products." target="_blank" rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.096.537 4.066 1.481 5.786L.057 23.882a.5.5 0 00.613.613l6.196-1.424A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.947 9.947 0 01-5.073-1.388l-.363-.214-3.779.868.883-3.68-.236-.38A9.959 9.959 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                Start WhatsApp Chat
            </a>
        </div>
    </div>
</div>
<style>
.wa-widget{position:fixed;left:20px;bottom:24px;z-index:9998;display:flex;flex-direction:column;align-items:flex-start;gap:10px}
.wa-toggle{width:52px;height:52px;border-radius:50%;background:#25D366;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 18px rgba(37,211,102,.45);transition:transform .2s,box-shadow .2s;position:relative}
.wa-toggle:hover{transform:scale(1.1);box-shadow:0 6px 24px rgba(37,211,102,.6)}
.wa-icon-close{display:none;position:absolute}
.wa-widget.open .wa-icon-wa{display:none}
.wa-widget.open .wa-icon-close{display:block}
.wa-panel{display:none;width:280px;border-radius:12px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,.18);background:#fff;margin-bottom:8px;order:-1}
.wa-widget.open .wa-panel{display:flex;flex-direction:column}
.wa-panel-head{background:#25D366;padding:.9rem 1rem;display:flex;align-items:center;gap:.75rem}
.wa-avatar{width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.25);display:flex;align-items:center;justify-content:center;flex-shrink:0}
.wa-head-name{font-size:.88rem;font-weight:700;color:#fff;line-height:1.2}
.wa-head-status{font-size:.68rem;color:rgba(255,255,255,.82)}
.wa-panel-body{padding:1rem;background:#e5ddd5;flex:1}
.wa-bubble{background:#fff;border-radius:0 10px 10px 10px;padding:.65rem .85rem;font-size:.82rem;color:#1a2a20;line-height:1.5;max-width:240px;box-shadow:0 1px 3px rgba(0,0,0,.1)}
.wa-panel-foot{padding:.75rem 1rem;background:#fff}
.wa-chat-btn{display:flex;align-items:center;justify-content:center;gap:.5rem;background:#25D366;color:#fff;font-size:.8rem;font-weight:700;text-decoration:none;padding:.65rem 1rem;border-radius:6px;transition:background .2s}
.wa-chat-btn:hover{background:#1ebe5a;color:#fff}
</style>
<script>
(function(){
  var w=document.getElementById('waWidget');
  var btn=document.getElementById('waToggle');
  if(!w||!btn) return;
  btn.addEventListener('click',function(){
    var open=w.classList.toggle('open');
    btn.setAttribute('aria-expanded',open?'true':'false');
  });
  document.addEventListener('click',function(e){
    if(!w.contains(e.target)) w.classList.remove('open');
  });
})();
</script>

