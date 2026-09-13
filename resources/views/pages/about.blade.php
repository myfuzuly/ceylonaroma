@extends('layouts.app')
@section('title', 'About Us — Ceylon Aroma Commodities')
@section('meta_description', 'Ceylon Aroma is a Sri Lanka B2B exporter of natural spices, teas, coffees and oils. 25+ years of experience, ISO 22000 certified, serving importers in 60+ countries.')
@section('content')

{{-- ── Hero ── --}}
<div class="about-hero">
    <div class="container">
        <span class="section-label about-hero-label">Our Story</span>
        <h1 class="about-hero-title">Sri Lanka's B2B<br><em>Spice Export Specialists.</em></h1>
        <p class="about-hero-sub">ISO 22000 certified. Direct from source. Supplying food businesses in 60+ countries for over 25 years.</p>
    </div>
</div>

{{-- ── Who We Are ── --}}
<section class="section">
    <div class="container">
        <div class="about-intro-grid">
            <div>
                <span class="section-label">Who We Are</span>
                <h2 class="section-title">About Ceylon Aroma</h2>
                <p class="about-intro-body">
                    Ceylon Aroma is a Kegalle-based spice, tea, and coffee exporter supplying food manufacturers, importers, wholesalers, and private label brands worldwide. We are not a trading company — we work directly with growers and processors in Sri Lanka's agricultural communities, buying at source, processing in our own ISO 22000-certified facility, and exporting under our own documentation.
                </p>
                <p class="about-intro-body">
                    That direct relationship gives you cleaner supply chain traceability, more competitive pricing, and faster response times than buying through intermediaries. We work exclusively B2B — our pricing, documentation, and logistics are structured around commercial buyers, not retail customers.
                </p>
                <p class="about-intro-body">
                    For over 25 years, we have built what we believe is the most commercially rigorous spice export operation in Sri Lanka — because the buyers who have worked with us for a decade know: the moment a shipment clears EU customs without a single query, that is where reputation is made.
                </p>
                <div class="about-intro-cta">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Explore Products</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline">Export Inquiry</a>
                </div>
            </div>
            <div class="about-img-col">
                <img src="/images/ceylonaroma4.png" alt="Ceylon Aroma Spices" class="about-main-img">
                <div class="about-stat-pill">
                    <span class="about-stat-num">60+</span>
                    <span class="about-stat-lbl">Countries Exported</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Why Choose Us ── --}}
<section class="wyc-section">
    <div class="wyc-pattern" aria-hidden="true"></div>
    <div class="container wyc-inner">
        <div class="wyc-header">
            <span class="section-label wyc-label">Our Advantage</span>
            <h2 class="wyc-heading">Why Choose <em>Ceylon Aroma?</em></h2>
            <p class="wyc-sub">Built on decades of expertise, trusted by importers across 60+ countries worldwide</p>
        </div>
        <div class="wyc-grid">
            @foreach([
                ['<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>','Certified at Source','ISO 22000:2018 and HACCP certification cover our entire supply chain, audited annually by an IAF-accredited third-party body. Certificates available before you place an order.'],
                ['<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>','Complete Documentation','Every shipment includes Certificate of Origin, Phytosanitary Certificate, multi-residue pesticide analysis (250+ compounds), aflatoxin and heavy metals report. Your customs broker will not be chasing us for paperwork.'],
                ['<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>','Transparent Pricing','We quote FOB Colombo, CIF your port, or DAP your warehouse. No brokerage markups. No undisclosed handling fees. The price on the quotation is the price on the invoice.'],
                ['<path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>','Sample Orders Welcome','Sample orders from 25 kg with full Certificate of Analysis. Charged at commercial rates — you need to evaluate the actual product you\'ll buy at scale. Sample cost credited against your first commercial order.'],
                ['<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>','Flexible MOQs','Commercial shipments from 500 kg LCL. Full 20-foot FCL from 5,000 kg. Private label from 500 retail units. We scale with your business — first order or full container programme.'],
                ['<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>','Dedicated Account Manager','Every commercial client is assigned a named account manager — one contact for quotes, documents, shipping updates, and reorders. No call centres. Direct WhatsApp available.'],
            ] as [$svg, $title, $desc])
            <div class="wyc-card">
                <div class="wyc-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">{!! $svg !!}</svg>
                </div>
                <h3 class="wyc-card-title">{{ $title }}</h3>
                <p class="wyc-card-desc">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── What We Stand For ── --}}
<section class="section">
    <div class="container">
        <div class="section-head center">
            <span class="section-label">Our Values</span>
            <h2 class="section-title">What We Stand For</h2>
            <p class="section-sub">We built this company on making the unglamorous things — testing, certification, documentation, chain of custody — completely reliable. The premium products are the easy part. Sri Lanka grows the finest cinnamon on earth. Our job is to make sure it reaches your facility exactly as specified, with documentation your procurement team can sign off without a second read.</p>
        </div>
        <div class="about-values-grid">
            @foreach([
                ['<path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/>','Quality Without Compromise','We reject non-conforming lots at source. Our customers never receive a consignment that did not pass internal QC before independent laboratory analysis was ordered.'],
                ['<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>','Transparent Trade','Our pricing is open-book. Our documentation is complete. We do not make margin on certificate markups or inflated freight quotes.'],
                ['<polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>','Long-Term Partnerships','We do not chase single orders. Our model is built on supply programmes with regular buyers. The better we understand your business, the better we can serve it.'],
                ['<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>','Direct from Source','No intermediaries, no trading-company markups. We source directly from registered farms and process in our own ISO 22000-certified facility.'],
                ['<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>','Buyer-First Documentation','Complete pre-shipment documentation pack — CoO, Phyto, pesticide analysis, aflatoxin, heavy metals, ISO cert — delivered within 48 hours of container departure.'],
            ] as [$icon, $title, $desc])
            <div class="about-value-card">
                <div class="about-value-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">{!! $icon !!}</svg>
                </div>
                <h3 class="about-value-title">{{ $title }}</h3>
                <p class="about-value-desc">{{ $desc }}</p>
            </div>
            @endforeach
        </div>

        {{-- Trust bar ── --}}
        <div class="about-trust-bar">
            @foreach(['Naturally Crafted. Responsibly Made.','Proudly Sri Lankan','Export Quality You Can Trust'] as $t)
            <div class="about-trust-item">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                {{ $t }}
            </div>
            @endforeach
            <div class="about-trust-item about-trust-phone">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.22 1.18 2 2 0 012.2 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.72 6.72l1.28-1.28a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                +94 71 882 1234
            </div>
        </div>
    </div>
</section>

@endsection
