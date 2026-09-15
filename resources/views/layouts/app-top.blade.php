<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<script>document.documentElement.classList.add('js-reveal');</script>

{{-- Google tag (gtag.js) --}}
<script async src="https://www.googletagmanager.com/gtag/js?id=G-H63JBCQSSV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-H63JBCQSSV');
</script>

@php
  $siteName    = $settings['site_name']    ?? 'Ceylon Aroma';
  $siteUrl     = 'https://ceylonaroma.com';
  $pageTitle   = html_entity_decode(trim(strip_tags(View::yieldContent('title'))), ENT_QUOTES | ENT_HTML5, 'UTF-8') ?: 'Premium Ceylon Spices, Tea & Coffee Exporter';
  $metaTitle   = $pageTitle . ' | ' . $siteName . ' — Sri Lanka Export';
  $metaDesc    = View::yieldContent('meta_description')
                 ?: ($settings['meta_description'] ?? 'Ceylon Aroma exports premium Ceylon cinnamon, spices, tea, coffee and natural products from Sri Lanka to 60+ countries. ISO certified. Request a wholesale quote today.');
  $metaImage   = View::yieldContent('og_image') ?: $siteUrl . '/images/spice-flatlay.png';
  $canonicalParts = [];
  if (request()->query('page') && (int)request()->query('page') > 1) $canonicalParts[] = 'page=' . (int)request()->query('page');
  $canonicalUrl = $siteUrl . request()->getPathInfo() . ($canonicalParts ? '?' . implode('&', $canonicalParts) : '');
@endphp

<title>{{ $metaTitle }}</title>
<meta name="description" content="{{ $metaDesc }}">
<meta name="keywords" content="{{ $settings['meta_keywords'] ?? 'Ceylon cinnamon exporter, Sri Lanka spices wholesale, Ceylon tea supplier, Ceylon coffee export, natural products Sri Lanka, spice exporters Sri Lanka' }}">
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large">
<link rel="canonical" href="{{ $canonicalUrl }}">
<link rel="alternate" hreflang="en" href="{{ $canonicalUrl }}">
<link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}">
<link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml">

<link rel="icon" type="image/x-icon" href="/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png">
<link rel="icon" type="image/png" sizes="192x192" href="/favicon-192.png">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

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
<meta name="twitter:site"        content="@CeylonAroma">
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
      "hasCredential": [
        { "@type": "EducationalOccupationalCredential", "credentialCategory": "certification", "name": "ISO 22000:2018 Food Safety Management" },
        { "@type": "EducationalOccupationalCredential", "credentialCategory": "certification", "name": "HACCP Certified" }
      ],
      "sameAs": [
        @if(!empty($settings['facebook_url']))"{{ $settings['facebook_url'] }}"@endif
        @if(!empty($settings['facebook_url']) && !empty($settings['linkedin_url'])),@endif
        @if(!empty($settings['linkedin_url']))"{{ $settings['linkedin_url'] }}"@endif
        @if((!empty($settings['facebook_url']) || !empty($settings['linkedin_url'])) && !empty($settings['instagram_url'])),@endif
        @if(!empty($settings['instagram_url']))"{{ $settings['instagram_url'] }}"@endif
      ]
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
<link rel="preload" as="image" href="/images/ceylonaroma4.png" fetchpriority="high">
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500;1,9..144,600&family=Plus+Jakarta+Sans:ital,wght@0,600;0,700;0,800;1,700;1,800&family=Inter:wght@400;500;600&display=swap" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;1,9..144,500;1,9..144,600&family=Plus+Jakarta+Sans:ital,wght@0,600;0,700;0,800;1,700;1,800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"></noscript>
@vite(['resources/css/bundle.css', 'resources/js/app.js'])
@stack('head')
<style>
/* ═══════════════════════════════════════════════════════════
   PREMIUM MEGA MENU — inline to guarantee load
   ═══════════════════════════════════════════════════════════ */
.nav-mega{
  display:none;position:fixed;left:0;right:0;width:100%;
  background:#fff;
  border-top:3px solid transparent;
  border-image:linear-gradient(90deg,#C8922A 0%,#e8b84b 40%,#C8922A 100%) 1;
  box-shadow:0 8px 40px rgba(27,67,50,.13),0 2px 8px rgba(27,67,50,.07);
  z-index:9999;
  animation:megaFadeIn .22s cubic-bezier(.4,0,.2,1) both
}
@keyframes megaFadeIn{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
.nav-mega-wrap.mega-open .nav-mega{display:block}
.nav-mega-wrap{position:static}
.nav-mega-wrap .nav-link svg{transition:transform .2s}
.nav-mega-wrap.mega-open .nav-link svg{transform:rotate(180deg)}
.nav-mega-inner{max-width:1400px;margin:0 auto;padding:0}

/* Layout: category grid | featured panel */
.mega-flat-layout{
  display:grid;
  grid-template-columns:1fr 264px;
  background:#fff
}

/* Category grid */
.mega-flat-cats{
  display:grid;
  grid-template-columns:repeat(6,1fr);
  gap:0;
  padding:1.35rem 1.5rem 1.1rem;
  align-items:start;
  border-bottom:1px solid rgba(27,67,50,.06)
}
.mega-flat-col{
  padding:.6rem .8rem .75rem;
  border-right:1px solid rgba(27,67,50,.055);
  display:flex;flex-direction:column;
  cursor:default;
  position:relative;
  transition:background .22s
}
.mega-flat-col::after{
  content:'';
  position:absolute;left:0;top:12%;bottom:12%;
  width:2px;
  background:linear-gradient(180deg,transparent,#C8922A 30%,#C8922A 70%,transparent);
  opacity:0;
  transition:opacity .22s
}
.mega-flat-col:hover{background:rgba(200,146,42,.03)}
.mega-flat-col:hover::after{opacity:1}
.mega-flat-col:last-child{border-right:none}

/* Premium column title — no icons */
.mega-flat-title{
  display:block;
  font-size:.82rem;font-weight:700;
  color:#1A2A20;letter-spacing:.02em;
  line-height:1.25;
  text-decoration:none;
  margin-bottom:.42rem;
  transition:color .18s
}
.mega-flat-title:hover{color:#C8922A}

/* Gold gradient divider */
.mega-flat-line{
  height:1.5px;
  background:linear-gradient(90deg,#C8922A 0%,rgba(200,146,42,.18) 100%);
  margin-bottom:.52rem;border-radius:1px
}

/* Sub-items */
.mega-flat-item{
  display:flex;align-items:center;gap:.3rem;
  font-size:.72rem;color:#4a5568;
  padding:.19rem .08rem;
  text-decoration:none;
  transition:color .13s,padding-left .15s
}
.mega-flat-item:hover,.mega-flat-item.is-active{
  color:#1B4332;padding-left:.28rem
}
.mega-flat-chev{
  flex-shrink:0;color:#C8922A;opacity:.4;
  transition:opacity .13s,transform .13s
}
.mega-flat-item:hover .mega-flat-chev{opacity:.9;transform:translateX(2px)}

/* Row divider — spans full grid width */
.mega-flat-row-divider{
  grid-column:1 / -1;
  height:1px;
  background:linear-gradient(90deg,transparent,rgba(27,67,50,.12) 15%,rgba(27,67,50,.12) 85%,transparent);
  margin:.1rem 0
}
/* More-items separator (within a column, before "See all") */
.mega-flat-more-sep{
  height:1px;background:rgba(27,67,50,.07);
  margin:.4rem 0 .28rem
}
/* Row 1 columns (has-more): slightly elevated title */
.mega-flat-col.has-more .mega-flat-title{
  color:#1A2A20;font-weight:800
}

/* View all / See all link */
.mega-flat-all{
  display:inline-flex;align-items:center;gap:.22rem;
  margin-top:.4rem;
  font-size:.67rem;font-weight:700;color:#C8922A;
  text-decoration:none;letter-spacing:.015em;
  transition:color .15s,gap .15s
}
.mega-flat-all:hover{color:#1B4332;gap:.38rem}

/* ── Featured side panel ── */
.mega-feat{
  background:linear-gradient(160deg,#fffdf6 0%,#fef9ed 100%);
  border-left:1px solid rgba(200,146,42,.18);
  display:flex;flex-direction:column;overflow:hidden
}
.mega-feat-imgwrap{
  height:170px;overflow:hidden;flex-shrink:0;position:relative
}
.mega-feat-img{
  width:100%;height:100%;object-fit:cover;display:block;
  transition:transform .6s cubic-bezier(.4,0,.2,1)
}
.mega-feat:hover .mega-feat-img{transform:scale(1.06)}
.mega-feat-overlay{
  position:absolute;inset:0;
  background:linear-gradient(180deg,rgba(27,67,50,.0) 40%,rgba(27,67,50,.5) 100%);
  pointer-events:none
}
.mega-feat-body{
  padding:1rem 1.2rem 1.25rem;
  display:flex;flex-direction:column;flex:1
}
.mega-feat-label{
  font-size:.52rem;font-weight:800;letter-spacing:.22em;
  text-transform:uppercase;color:#C8922A;
  margin-bottom:.38rem;display:block
}
.mega-feat-title{
  font-family:'Fraunces',Georgia,serif;
  font-size:1.15rem;font-weight:700;color:#1B4332;
  line-height:1.2;margin:0 0 .38rem
}
.mega-feat-desc{
  font-size:.71rem;color:#6B7280;
  line-height:1.6;margin:0 0 .85rem;flex:1
}
.mega-feat-cta{
  display:flex;align-items:center;justify-content:center;gap:.45rem;
  background:#1B4332;color:#fff;
  font-size:.67rem;font-weight:700;letter-spacing:.09em;
  text-transform:uppercase;padding:.65rem 1rem;
  border-radius:8px;text-decoration:none;
  transition:background .2s,transform .15s,box-shadow .2s
}
.mega-feat-cta:hover{
  background:#C8922A;transform:translateY(-1px);
  box-shadow:0 4px 16px rgba(200,146,42,.35)
}
.mega-feat-cta svg{transition:transform .2s}
.mega-feat-cta:hover svg{transform:translateX(3px)}

/* ── Bottom quick-link strip ── */
.mega-strip{
  display:flex;align-items:center;justify-content:space-between;
  padding:.65rem 1.5rem;
  background:linear-gradient(90deg,#f6f2e9 0%,#f9f6ef 100%);
  border-top:1px solid rgba(200,146,42,.18)
}
.mega-strip-links{display:flex;align-items:center}
.mega-strip-link{
  display:flex;align-items:center;gap:.45rem;
  font-size:.72rem;font-weight:600;color:#374151;
  padding:.38rem .8rem;white-space:nowrap;text-decoration:none;
  transition:color .15s
}
.mega-strip-link:hover{color:#1B4332}
.mega-strip-icon{
  width:18px;height:18px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;
  color:#C8922A
}
.mega-strip-div{
  width:1px;height:16px;
  background:rgba(27,67,50,.15);
  flex-shrink:0;margin:0 .05rem
}
.mega-strip-all{
  display:inline-flex;align-items:center;gap:.4rem;
  font-size:.68rem;font-weight:700;color:#fff;
  background:#1B4332;padding:.5rem 1.1rem;
  border-radius:8px;text-transform:uppercase;
  letter-spacing:.06em;white-space:nowrap;
  text-decoration:none;
  transition:background .18s,transform .15s,box-shadow .18s
}
.mega-strip-all:hover{
  background:#C8922A;transform:translateY(-1px);
  box-shadow:0 3px 12px rgba(27,67,50,.2)
}
@media(max-width:1100px){
  .mega-flat-layout{grid-template-columns:1fr}
  .mega-feat{display:none}
}
@media(max-width:1100px){
  .mega-flat-cats{grid-template-columns:repeat(4,1fr)}
}
@media(max-width:768px){
  .mega-flat-cats{grid-template-columns:repeat(3,1fr)}
}

/* ═══════════════════════════════════════════════════════════
   HERO — UI/UX UPGRADE (reduced height + premium polish)
   ═══════════════════════════════════════════════════════════ */

/* Reduced left panel height */
.hs-left{min-height:440px}
.hs-left-inner{
  padding:2.75rem clamp(1.5rem,2.5vw,3rem) 2.75rem clamp(1.5rem,calc((100vw - 1280px)/2 + 2.5rem),6.5rem);
  max-width:540px;
}

/* Tighter title */
.hero-title{
  font-size:clamp(2.1rem,3.8vw,3.5rem);
  margin:0 0 1rem;
  line-height:1.08;
}

/* Description — slimmer */
.hero-desc{
  font-size:.9rem;
  line-height:1.75;
  margin:0 0 1.5rem;
  max-width:40ch;
}

/* CTA — premium gold primary button */
.hero-cta .btn-primary{
  background:linear-gradient(135deg,#C8922A 0%,#D4A843 55%,#C07A1F 100%);
  border-color:transparent;
  color:#fff;
  box-shadow:0 2px 12px rgba(200,146,42,.35);
  font-weight:700;
  letter-spacing:.03em;
}
.hero-cta .btn-primary:hover{
  background:linear-gradient(135deg,#B87E22 0%,#C8922A 55%,#A86D1A 100%);
  box-shadow:0 6px 22px rgba(200,146,42,.45);
  transform:translateY(-2px);
}
.hero-cta .btn-primary svg{transition:transform .2s}
.hero-cta .btn-primary:hover svg{transform:translateX(3px)}

/* Outline CTA — subtle forest */
.hero-cta .btn-outline{
  color:var(--canopy);
  border-color:rgba(27,67,50,.35);
  font-weight:600;
}
.hero-cta .btn-outline:hover{
  background:rgba(27,67,50,.06);
  border-color:var(--canopy);
  color:var(--canopy);
}

/* Trust badges — tighter */
.hero-trust{margin-top:1.5rem;padding-top:1.1rem}
.hero-trust-item svg{color:var(--gold)}

/* Purity badge — slightly smaller */
.hero-purity-badge{width:116px;height:116px}
.hpb-pct{font-size:1.7rem}

/* Stats bar — compact */
.stat-item{padding:1rem 1.25rem}
.stat-num{font-size:1.45rem}

/* Eyebrow pill — sharper */
.hero-eyebrow{
  font-size:.6rem;
  letter-spacing:.18em;
  padding:.32rem .9rem .32rem .65rem;
  margin-bottom:1rem;
  background:rgba(200,146,42,.07);
  border-color:rgba(200,146,42,.3);
}

/* Hero entrance animation */
.hs-left-inner{animation:heroIn .55s cubic-bezier(.22,1,.36,1) both}
@keyframes heroIn{
  from{opacity:0;transform:translateY(14px)}
  to{opacity:1;transform:translateY(0)}
}
@media(prefers-reduced-motion:reduce){
  .hs-left-inner{animation:none}
}

/* Mobile hero height */
@media(max-width:768px){
  .hs-right{height:260px}
  .hs-left{min-height:unset}
  .hs-left-inner{padding:2rem 1.25rem}
  .hero-title{font-size:1.85rem}
  .stat-item{padding:.75rem 1rem}
}
</style>
</head>
<body>
<a href="#main-content" class="skip-nav">Skip to main content</a>

{{-- ── Topbar ── --}}
<div class="topbar">
    <div class="topbar-inner">
        <div class="topbar-usps">
            <span class="topbar-usp">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/></svg>
                Delivering Natural Goodness of Sri Lanka to the World
            </span>
            <span class="topbar-usp">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                100% Natural &amp; Pure
            </span>
        </div>
        <div class="topbar-right">
            <a href="{{ route('blog.index') }}" class="topbar-usp topbar-link">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Blog
            </a>
            <a href="{{ route('contact') }}" class="topbar-usp topbar-link">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Contact
            </a>
            <div class="topbar-lang">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
                <span aria-label="Language: English">EN</span>
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
            <img src="/images/ceylonaroma4.png" alt="Ceylon Aroma" class="logo-img">
        </a>

        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
@php
  if(empty($navCategories) || $navCategories->isEmpty()){
    try{
      $navCategories = \App\Models\Category::where('status',true)
        ->whereNull('parent_id')
        ->where('show_in_nav', true)
        ->with(['children'=>function($q){ $q->where('status',true)->orderBy('sort_order')->with(['children'=>function($q2){ $q2->where('status',true)->orderBy('sort_order'); }]); }])
        ->orderBy('nav_order')->orderBy('sort_order')->get();
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
                        @php
                        $catIcons = [
                            0=>'<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 3C9 3 5 7 6 13c.6 3.5 3.5 6.5 6 7 2.5-.5 5.4-3.5 6-7 1-6-3-10-6-10z"/><path d="M9 12c1-1.5 3-2 6-1"/></svg>',
                            1=>'<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M17 8h1a4 4 0 010 8h-1"/><path d="M3 8h14v9a4 4 0 01-4 4H7a4 4 0 01-4-4V8z"/><line x1="6" y1="2" x2="6" y2="4"/><line x1="10" y1="2" x2="10" y2="4"/><line x1="14" y1="2" x2="14" y2="4"/></svg>',
                            2=>'<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M2 2l8 8"/><path d="M8.5 10.5C7 12 5.5 12.5 4 13c1 1.5 2.5 2.5 5.5 2.5C13 15.5 15 13.5 15.5 11s.5-5 .5-5-3 0-5 .5c-3 .75-4 3-5 4.5z"/></svg>',
                            3=>'<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>',
                            4=>'<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="4"/><path d="M8 8c0 3 8 3 8 0"/><path d="M6 20h12a1 1 0 000-2 2 2 0 00-2-2H8a2 2 0 00-2 2 1 1 0 000 2z"/></svg>',
                            5=>'<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><ellipse cx="12" cy="5" rx="4" ry="2.5"/><path d="M8 5c0 4.5 8 4.5 8 0"/><path d="M8 11c0 4.5 8 4.5 8 0"/><path d="M8 17c0 3.5 8 3.5 8 0"/></svg>',
                            6=>'<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
                            7=>'<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>',
                            8=>'<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>',
                        ];
                        $iconCount = count($catIcons);
                        @endphp
                        {{-- Flat all-in-one mega layout --}}
                        <div class="mega-flat-layout">
                            @php
                                $allCats  = $navCategories ?? collect();
                                $row1Cats = $allCats->slice(0, 6)->values();
                                $row2Cats = $allCats->slice(6)->values();
                            @endphp
                            <div class="mega-flat-cats">
                                {{-- Row 1: categories with more than 5 sub-items --}}
                                @foreach($row1Cats as $cat)
                                @php $childCount = $cat->children->count(); @endphp
                                <div class="mega-flat-col has-more">
                                    <a href="{{ route('products.category', $cat->slug) }}" class="mega-flat-title">{{ $cat->name }}</a>
                                    <div class="mega-flat-line"></div>
                                    @foreach($cat->children->take(5) as $child)
                                    <a href="{{ route('products.category', $child->slug) }}" class="mega-flat-item{{ optional(request()->route('category'))->slug === $child->slug ? ' is-active' : '' }}">
                                        <svg class="mega-flat-chev" width="7" height="7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                                        {{ $child->name }}
                                    </a>
                                    @endforeach
                                    <div class="mega-flat-more-sep"></div>
                                    <a href="{{ route('products.category', $cat->slug) }}" class="mega-flat-all">See all ({{ $childCount }}) →</a>
                                </div>
                                @endforeach

                                {{-- Row divider --}}
                                @if($row1Cats->isNotEmpty() && $row2Cats->isNotEmpty())
                                <div class="mega-flat-row-divider"></div>
                                @endif

                                {{-- Row 2: categories with 5 or fewer sub-items --}}
                                @foreach($row2Cats as $cat)
                                <div class="mega-flat-col">
                                    <a href="{{ route('products.category', $cat->slug) }}" class="mega-flat-title">{{ $cat->name }}</a>
                                    <div class="mega-flat-line"></div>
                                    @foreach($cat->children->take(5) as $child)
                                    <a href="{{ route('products.category', $child->slug) }}" class="mega-flat-item{{ optional(request()->route('category'))->slug === $child->slug ? ' is-active' : '' }}">
                                        <svg class="mega-flat-chev" width="7" height="7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                                        {{ $child->name }}
                                    </a>
                                    @endforeach
                                    @if($cat->children->isNotEmpty())
                                    <a href="{{ route('products.category', $cat->slug) }}" class="mega-flat-all">View all →</a>
                                    @endif
                                </div>
                                @endforeach
                            </div>

                            {{-- Right: featured panel --}}
                            <div class="mega-feat">
                                <div class="mega-feat-imgwrap">
                                    <img src="/images/cinnamon-feature.png" alt="Featured Collection" class="mega-feat-img" loading="lazy"
                                         onerror="this.src='/images/spice-flatlay.png'">
                                    <div class="mega-feat-overlay"></div>
                                </div>
                                <div class="mega-feat-body">
                                    <span class="mega-feat-label">Featured Collection</span>
                                    <h3 class="mega-feat-title">Pure Ceylon Cinnamon</h3>
                                    <p class="mega-feat-desc">The true taste of Sri Lanka, naturally exceptional.</p>
                                    <a href="{{ route('products.index') }}" class="mega-feat-cta">
                                        Shop Collection
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Bottom quick-link strip --}}
                        <div class="mega-strip">
                            <div class="mega-strip-links">
                                <a href="{{ route('products.index') }}" class="mega-strip-link">
                                    <span class="mega-strip-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></span>
                                    New Arrivals
                                </a>
                                <span class="mega-strip-div"></span>
                                <a href="{{ route('products.index') }}?sort=popular" class="mega-strip-link">
                                    <span class="mega-strip-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></span>
                                    Best Sellers
                                </a>
                                <span class="mega-strip-div"></span>
                                <a href="{{ route('export') }}" class="mega-strip-link">
                                    <span class="mega-strip-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg></span>
                                    Export Range
                                </a>
                                <span class="mega-strip-div"></span>
                                <a href="{{ route('contact') }}" class="mega-strip-link">
                                    <span class="mega-strip-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></span>
                                    Wholesale Enquiries
                                </a>
                            </div>
                            <a href="{{ route('products.index') }}" class="mega-strip-all">
                                View All Products
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('export') }}" class="nav-link {{ request()->routeIs('export') ? 'active' : '' }}">Export</a>
            <a href="{{ route('wholesale-prices.index') }}" class="nav-link {{ request()->routeIs('wholesale-prices.*') ? 'active' : '' }}">Wholesale Prices</a>
            <a href="{{ route('quality') }}" class="nav-link {{ request()->routeIs('quality') ? 'active' : '' }}">Quality</a>
            <a href="{{ route('private-label') }}" class="nav-link {{ request()->routeIs('private-label') ? 'active' : '' }}">Private Label</a>
        </div>

        <form method="GET" action="{{ route('products.index') }}" class="nav-search-form" role="search" autocomplete="off">
            <label for="nav-search-input" class="sr-only">Search products</label>
            <svg class="nav-search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="nav-search-input" name="search" value="{{ request('search') }}" placeholder="Search products…" class="nav-search-input" autocomplete="off">
            <div class="nav-search-suggest" id="nav-search-suggest"></div>
        </form>

        <div class="nav-actions">
            {{-- Wishlist icon --}}
            <a href="{{ route('wishlist') }}" class="nav-wish-btn" aria-label="Wishlist" id="nav-wish-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                <span class="nav-badge nav-wish-badge">0</span>
            </a>
            {{-- Cart icon --}}
            <a href="{{ route('cart.index') }}" class="nav-cart-btn" aria-label="Cart" id="nav-cart-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                @php $cartCount = count(session('cart',[])); @endphp
                @if($cartCount > 0)
                    <span class="nav-cart-badge cart-count" id="nav-cart-badge">{{ $cartCount }}</span>
                @else
                    <span class="nav-cart-badge nav-cart-badge-hidden cart-count" id="nav-cart-badge">0</span>
                @endif
            </a>
            {{-- Customer Account --}}
            @if(session('customer_id'))
                <div class="nav-account-wrap">
                    <button type="button" class="nav-account-btn" aria-label="My Account">
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
        </div>

        <button type="button" class="hamburger" aria-label="Open menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- Mobile overlay + drawer --}}
<div class="mobile-overlay" aria-hidden="true"></div>
<div class="mobile-nav" role="dialog" aria-label="Mobile menu" aria-modal="true">
    <div class="mobile-nav-header">
        <a href="{{ route('home') }}" class="logo" aria-label="Ceylon Aroma Home">
            <img src="/images/ceylonaroma4.png" alt="Ceylon Aroma" class="logo-img">
        </a>
        <button type="button" class="mobile-close" aria-label="Close menu">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
    <form method="GET" action="{{ route('products.index') }}" class="mobile-search-form" role="search">
        <label for="mobile-search-input" class="sr-only">Search products</label>
        <svg class="mobile-search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="mobile-search-input" name="search" value="{{ request('search') }}" placeholder="Search products…" class="mobile-search-input">
    </form>
    <div class="mobile-links">
        <a href="{{ route('home') }}"          class="mobile-link">Home</a>
        <a href="{{ route('about') }}"         class="mobile-link">About Us</a>

        {{-- Products accordion --}}
        <div class="mobile-accordion">
            <button type="button" class="mobile-link mobile-accordion-btn" aria-expanded="false" aria-controls="mobile-products-panel">
                Products
                <svg class="mobile-acc-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="mobile-accordion-body" id="mobile-products-panel">
                <a href="{{ route('products.index') }}" class="mobile-sub-link mobile-sub-all">All Products <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
                @foreach($navCategories ?? [] as $catIdx => $cat)
                @if($cat->children->isNotEmpty())
                <div class="mobile-cat-acc">
                    <button type="button" class="mobile-sub-link mobile-sub-cat mobile-cat-acc-btn" aria-expanded="false" aria-controls="mob-cat-{{ $cat->slug }}">
                        {{ $cat->name }}
                        <svg class="mob-cat-chevron" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <div class="mobile-cat-acc-body" id="mob-cat-{{ $cat->slug }}">
                        <a href="{{ route('products.category', $cat->slug) }}" class="mobile-sub-link mobile-sub-sub">All {{ $cat->name }}</a>
                        @foreach($cat->children as $sub)
                        <a href="{{ route('products.category', $sub->slug) }}" class="mobile-sub-link mobile-sub-sub">↳ {{ $sub->name }}</a>
                        @endforeach
                    </div>
                </div>
                @else
                <a href="{{ route('products.category', $cat->slug) }}" class="mobile-sub-link mobile-sub-cat">{{ $cat->name }}</a>
                @endif
                @endforeach
            </div>
        </div>

        <a href="{{ route('export') }}"         class="mobile-link">Export Services</a>
        <a href="{{ route('wholesale-prices.index') }}" class="mobile-link">Wholesale Prices</a>
        <a href="{{ route('quality') }}"        class="mobile-link">Quality & Certs</a>
        <a href="{{ route('private-label') }}"  class="mobile-link">Private Label</a>
        <a href="{{ route('blog.index') }}"     class="mobile-link">Blog</a>
        <a href="{{ route('contact') }}"        class="mobile-link">Contact Us</a>
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
            <span class="mob-nav-badge cart-count">{{ count(session('cart',[])) }}</span>
        @endif
        <span>Cart</span>
    </a>
    <button type="button" class="mob-nav-item" id="mobNavMenu" aria-label="Menu" aria-expanded="false">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        <span>Menu</span>
    </button>
</nav>
<script>
(function(){
  /* ── Mobile accordion (Products panel) ── */
  var accBtn  = document.querySelector('.mobile-accordion-btn');
  var accBody = document.querySelector('.mobile-accordion-body');
  if(accBtn && accBody){
    accBtn.addEventListener('click',function(){
      var open = accBody.classList.toggle('open');
      accBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }
  /* ── Mobile category sub-accordions ── */
  document.querySelectorAll('.mobile-cat-acc-btn').forEach(function(btn){
    btn.addEventListener('click',function(){
      var body = document.getElementById(btn.getAttribute('aria-controls'));
      if(!body) return;
      var open = body.classList.toggle('open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      var chevron = btn.querySelector('.mob-cat-chevron');
      if(chevron) chevron.style.transform = open ? 'rotate(180deg)' : '';
    });
  });

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

  window.addEventListener('resize', positionMega, {passive:true});
  positionMega();
})();
(function(){
  /* ── Nav search live suggestions ── */
  var input = document.getElementById('nav-search-input');
  var box   = document.getElementById('nav-search-suggest');
  if(!input || !box) return;
  var timer = null, activeIdx = -1, items = [];

  function escapeHtml(s){
    return s.replace(/[&<>"']/g, function(c){
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];
    });
  }
  function highlight(name, q){
    var i = name.toLowerCase().indexOf(q.toLowerCase());
    if(i === -1) return escapeHtml(name);
    return escapeHtml(name.slice(0,i)) + '<mark>' + escapeHtml(name.slice(i,i+q.length)) + '</mark>' + escapeHtml(name.slice(i+q.length));
  }
  function render(list, q){
    items = list;
    activeIdx = -1;
    if(!list.length){ box.innerHTML = ''; box.classList.remove('open'); return; }
    box.innerHTML = list.map(function(p, i){
      var img = p.image
        ? '<img src="'+p.image+'" alt="" loading="lazy">'
        : '<span class="nav-suggest-noimg"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/></svg></span>';
      return '<a href="'+p.url+'" class="nav-suggest-item" data-idx="'+i+'">'
           + img
           + '<span class="nav-suggest-text"><span class="nav-suggest-name">'+highlight(p.name, q)+'</span>'
           + (p.category ? '<span class="nav-suggest-cat">'+escapeHtml(p.category)+'</span>' : '')
           + '</span></a>';
    }).join('') + '<a href="{{ route('products.index') }}?search='+encodeURIComponent(q)+'" class="nav-suggest-viewall">View all results for &ldquo;'+escapeHtml(q)+'&rdquo;</a>';
    box.classList.add('open');
  }
  function close(){ box.classList.remove('open'); box.innerHTML=''; items=[]; activeIdx=-1; }

  input.addEventListener('input', function(){
    var q = input.value.trim();
    clearTimeout(timer);
    if(q.length < 2){ close(); return; }
    timer = setTimeout(function(){
      fetch('{{ route('products.suggestions') }}?q=' + encodeURIComponent(q))
        .then(function(r){ return r.json(); })
        .then(function(data){ if(input.value.trim() === q) render(data, q); })
        .catch(function(){});
    }, 220);
  });

  input.addEventListener('keydown', function(e){
    var links = box.querySelectorAll('.nav-suggest-item');
    if(!links.length) return;
    if(e.key === 'ArrowDown'){
      e.preventDefault();
      activeIdx = Math.min(activeIdx + 1, links.length - 1);
    } else if(e.key === 'ArrowUp'){
      e.preventDefault();
      activeIdx = Math.max(activeIdx - 1, 0);
    } else if(e.key === 'Enter' && activeIdx > -1){
      e.preventDefault();
      window.location.href = links[activeIdx].href;
      return;
    } else if(e.key === 'Escape'){
      close();
      return;
    } else {
      return;
    }
    links.forEach(function(l,i){ l.classList.toggle('active', i === activeIdx); });
    links[activeIdx].scrollIntoView({block:'nearest'});
  });

  document.addEventListener('click', function(e){
    if(!e.target.closest('.nav-search-form')) close();
  });
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
      if(e.isIntersecting){ e.target.classList.add('visible','in-view'); io.unobserve(e.target); }
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
    <button type="button" class="wa-toggle" id="waToggle" aria-label="Open WhatsApp chat" aria-expanded="false">
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
            <a class="wa-chat-btn" href="https://wa.me/{{ $settings['phone_whatsapp'] ?? '94712930930' }}?text=Hello%20Ceylon%20Aroma%2C%20I%20am%20interested%20in%20your%20products." target="_blank" rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="#fff"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.096.537 4.066 1.481 5.786L.057 23.882a.5.5 0 00.613.613l6.196-1.424A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22a9.947 9.947 0 01-5.073-1.388l-.363-.214-3.779.868.883-3.68-.236-.38A9.959 9.959 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                Start WhatsApp Chat
            </a>
        </div>
    </div>
</div>
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

