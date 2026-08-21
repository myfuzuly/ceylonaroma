@extends('layouts.app')
@section('title', 'About Us — Ceylon Aroma Commodities')
@section('meta_description', 'Ceylon Aroma is a Sri Lanka B2B exporter of natural spices, teas, coffees and oils. 25+ years of experience, ISO 22000 certified, serving importers in 60+ countries.')
@section('content')

{{-- ── Hero ── --}}
<div class="about-hero">
    <div class="container">
        <span class="section-label about-hero-label">Our Story</span>
        <h1 class="about-hero-title">Delivering the Natural<br><em>Taste &amp; Aroma</em><br>of Sri Lanka to the World.</h1>
        <p class="about-hero-sub">Ceylon Aroma Commodities — trusted by importers in 60+ countries.</p>
    </div>
</div>

{{-- ── Who We Are ── --}}
<section class="section">
    <div class="container">
        <div class="about-intro-grid">
            <div>
                <span class="section-label">Who We Are</span>
                <h2 class="section-title">About Ceylon Aroma<br>Commodities</h2>
                <p class="about-intro-body">
                    Ceylon Aroma Commodities is a Sri Lankan export company dedicated to supplying premium spices, natural aromatic products, and value-added agricultural commodities to global markets. Built on Sri Lanka's rich agricultural heritage and world-renowned spice tradition, we bring authentic island-grown products to customers worldwide.
                </p>
                <p class="about-intro-body">
                    We collaborate closely with local farmers and trusted sourcing partners to select the finest raw materials cultivated in Sri Lanka's fertile landscapes. Every product is carefully processed, quality controlled, and packed to preserve its natural aroma, freshness, purity, and distinctive flavor.
                </p>
                <p class="about-intro-body">
                    Our mission is to share the authentic essence of Ceylon with international and local markets while promoting sustainable sourcing, empowering rural communities, and maintaining the highest standards of quality and reliability.
                </p>
                <div class="about-intro-cta">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Explore Products</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline">Export Inquiry</a>
                </div>
            </div>
            <div class="about-img-col">
                <img src="/images/ceylonaroma3.png" alt="Ceylon Aroma Spices" class="about-main-img">
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
                ['<path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/>','Sri Lankan Origin','Sourced exclusively from pristine highlands and fertile lands of Sri Lanka.'],
                ['<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>','Export Quality','Every batch tested and certified to meet international export standards.'],
                ['<polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>','Sustainable Sourcing','Ethical farming practices that protect the environment and local communities.'],
                ['<path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>','Premium Packaging','Custom hygienic packaging tailored to your specific market requirements.'],
                ['<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/>','Global Delivery','Reliable logistics to 60+ countries with full documentation and compliance.'],
                ['<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>','Direct Farmer Network','Direct partnerships — no middlemen, fresher products, and better pricing.'],
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
            <p class="section-sub">At Ceylon Aroma, we stand for authenticity, sustainability, and the timeless heritage of Sri Lanka. Every product we export carries the island's soul — from the misty tea plantations to the spice gardens, tropical orchards, and traditional kitchens.</p>
        </div>
        <div class="about-values-grid">
            @foreach([
                ['<path d="M12 2C7 2 3 7 4 13c.8 4.5 4.5 8 8 9 3.5-1 7.2-4.5 8-9 1-6-3-11-8-11z"/>','Authenticity','100% Sri Lankan origin, rooted in centuries-old traditions.'],
                ['<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/>','Purity','No preservatives, no MSG, no artificial additives — only nature\'s finest.'],
                ['<polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>','Sustainability','Eco-conscious packaging and responsible sourcing that respect the environment.'],
                ['<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>','Quality','Export-ready standards with small-batch consistency and freshness.'],
                ['<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>','Trust','Transparent processes and a brand promise backed by integrity.'],
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
