@extends('layouts.app')

@section('title', 'Quality & Certifications')
@section('meta_description', 'ISO 22000, HACCP, USDA NOP, EU Organic and GMP certified. Ceylon Aroma maintains rigorous quality control from Sri Lanka farms to international ports.')

@section('content')

{{-- Hero --}}
<div class="export-hero">
    <div class="container">
        <span class="section-label export-hero-label">Standards & Compliance</span>
        <h1>Quality & Certifications</h1>
        <p>Every product we export meets internationally recognised food safety standards, backed by third-party laboratory testing and certified by accredited bodies.</p>
        <a href="{{ route('contact') }}" class="btn btn-gold">Request Certificate of Analysis
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>
</div>

{{-- Certifications --}}
<section class="export-section">
    <div class="container">
        <div class="section-header-center">
            <span class="section-label">Our Certifications</span>
            <h2>Accreditations &amp; Standards</h2>
            <p>All certification documentation is available upon request for due-diligence and procurement verification.</p>
        </div>
        <div class="cert-grid">
            <div class="cert-card">
                <div class="cert-logo">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
                </div>
                <h3>ISO 22000 : 2018</h3>
                <p class="cert-body">Food Safety Management System — covers the full supply chain from raw material sourcing through processing, packaging, and export.</p>
                <div class="cert-detail"><strong>Issuing body:</strong> SGS (Lanka) Ltd.</div>
                <div class="cert-detail"><strong>Scope:</strong> Processing and export of spices, tea, and coffee</div>
            </div>
            <div class="cert-card">
                <div class="cert-logo">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                </div>
                <h3>HACCP</h3>
                <p class="cert-body">Hazard Analysis and Critical Control Points — systematic preventive approach to food safety covering biological, chemical, and physical hazards.</p>
                <div class="cert-detail"><strong>Plan:</strong> Verified annually by an independent food safety auditor</div>
            </div>
            <div class="cert-card">
                <div class="cert-logo">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
                </div>
                <h3>USDA National Organic Programme (NOP)</h3>
                <p class="cert-body">USDA NOP organic certification for selected product lines destined for the United States market, meeting 7 CFR Part 205 standards.</p>
                <div class="cert-detail"><strong>Applies to:</strong> Organic Ceylon Cinnamon, Organic Ceylon Tea (selected grades)</div>
            </div>
            <div class="cert-card">
                <div class="cert-logo">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4l3 3"/></svg>
                </div>
                <h3>EU Organic (EC 834/2007)</h3>
                <p class="cert-body">European Union organic certification for products entering EU/EEA markets, complying with Council Regulation (EC) No 834/2007 and Regulation (EU) 2018/848.</p>
                <div class="cert-detail"><strong>Applies to:</strong> Organic spice lines for EU buyers</div>
            </div>
            <div class="cert-card">
                <div class="cert-logo">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/><polyline points="9 8 11 10 15 6"/></svg>
                </div>
                <h3>Sri Lanka Standards Institution (SLSI)</h3>
                <p class="cert-body">Compliance with Sri Lanka Standards for spices and condiments. SLSI certification required for Health Certificates issued by the Ministry of Health.</p>
            </div>
            <div class="cert-card">
                <div class="cert-logo">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                </div>
                <h3>GMP — Good Manufacturing Practice</h3>
                <p class="cert-body">All processing facilities comply with Good Manufacturing Practice guidelines, covering hygiene, pest control, equipment maintenance, traceability, and allergen management.</p>
            </div>
        </div>
    </div>
</section>

{{-- QC Process --}}
<section class="export-section export-section-alt">
    <div class="container">
        <div class="section-header-center">
            <span class="section-label">Quality Control</span>
            <h2>Our QC Process</h2>
            <p>Six-stage quality assurance from field to shipment — with documentation at every step.</p>
        </div>
        <div class="export-steps">
            <div class="export-step">
                <div class="export-step-num">01</div>
                <h3>Field Sourcing</h3>
                <p>Raw materials sourced from registered farms. Supplier farms audited annually for pesticide use, soil health, and organic compliance where applicable.</p>
            </div>
            <div class="export-step">
                <div class="export-step-num">02</div>
                <h3>Intake Inspection</h3>
                <p>All incoming raw materials are visually inspected and sampled. Rejected lots are segregated and returned to supplier. Acceptance records maintained per batch.</p>
            </div>
            <div class="export-step">
                <div class="export-step-num">03</div>
                <h3>Processing &amp; Sorting</h3>
                <p>Cleaning, drying, grading, and milling under GMP conditions. Temperature-controlled storage where required to preserve essential oil content and moisture targets.</p>
            </div>
            <div class="export-step">
                <div class="export-step-num">04</div>
                <h3>Laboratory Testing</h3>
                <p>Each production batch undergoes internal QC testing and selected batches are submitted to accredited third-party laboratories for COA parameters.</p>
            </div>
            <div class="export-step">
                <div class="export-step-num">05</div>
                <h3>Packaging &amp; Labelling</h3>
                <p>Packed in food-grade materials to specification — net weight, batch number, production and best-before dates, HS code, and origin statement on every carton.</p>
            </div>
            <div class="export-step">
                <div class="export-step-num">06</div>
                <h3>Pre-Shipment Inspection</h3>
                <p>Random container stuffing inspection at point of loading. Third-party pre-shipment inspection (PSI) by SGS, Intertek, or Bureau Veritas arranged on buyer request.</p>
            </div>
        </div>
    </div>
</section>

{{-- Lab Testing Parameters --}}
<section class="export-section">
    <div class="container">
        <div class="export-doc-grid">
            <div class="export-doc-text">
                <span class="section-label">Laboratory Analysis</span>
                <h2>Certificate of Analysis Parameters</h2>
                <p>Our COA covers the following standard parameters. Additional testing (e.g. radioactivity, specific pesticide residues, aflatoxins) is arranged on buyer request at cost.</p>
                <p>COA reports are available in PDF before shipment. Wet-chemistry originals dispatched with the commercial documents.</p>
                <a href="{{ route('contact') }}" class="btn btn-gold mt-3">Request Sample COA</a>
            </div>
            <div class="export-doc-list">
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Moisture Content</strong><span>% by mass — AOAC 925.10 or ASTA method</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Total Ash / Acid-Insoluble Ash</strong><span>Indicator of mineral content and extraneous matter</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Volatile Oil Content</strong><span>% v/w — ASTA 2.0 / ISO 6571 (cinnamon, cardamom, pepper)</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Heavy Metals</strong><span>Lead, Cadmium, Arsenic, Mercury — ICP-MS method</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Microbiology</strong><span>Total Plate Count, E. coli, Salmonella, Yeast &amp; Mould</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Pesticide Residues</strong><span>Multi-residue screen — EU MRL compliant (Regulation EC 396/2005)</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Coumarin Content</strong><span>For Ceylon Cinnamon (Cinnamomum zeylanicum) — GC/MS method</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Theaflavin / Thearubigin Ratio</strong><span>For orthodox black tea grades — Spectrophotometric method</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="export-cta-section">
    <div class="container">
        <div class="export-cta-inner">
            <h2>Need Specific Certification Documentation?</h2>
            <p>Contact our export team with your import country requirements and we'll confirm which certificates apply.</p>
            <a href="{{ route('contact') }}" class="btn btn-gold btn-lg">Contact Our Export Team
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>

@endsection
