@extends('layouts.app')

@section('title', 'Private Label Services')
@section('meta_description', 'Launch your own branded Ceylon spice, tea or coffee range. MOQ from 50 kg, custom label artwork, 6 packaging formats. Trusted by brands in 60+ countries.')

@section('content')

{{-- Hero --}}
<div class="export-hero">
    <div class="container">
        <span class="section-label export-hero-label">Custom Branding</span>
        <h1>Private Label Services</h1>
        <p>Launch your own branded Ceylon spice, tea, or coffee line. We handle formulation, packaging, labelling, and export — you sell under your brand.</p>
        <a href="{{ route('contact') }}" class="btn btn-gold">Start Your Private Label Inquiry
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>
</div>

{{-- What is private label --}}
<section class="export-section">
    <div class="container">
        <div class="pl-intro-grid">
            <div class="pl-intro-text">
                <span class="section-label">How It Works</span>
                <h2>Your Brand. Our Expertise.</h2>
                <p>Private label means we produce, pack, and label products under your brand name instead of ours. You own the brand; we supply the product with full traceability and export documentation.</p>
                <p>Ideal for:</p>
                <ul class="pl-ideal-list">
                    <li>Supermarkets and grocery chains launching own-brand ranges</li>
                    <li>Specialty food distributors and importers</li>
                    <li>Online retail brands and direct-to-consumer businesses</li>
                    <li>Foodservice suppliers and hotel chains</li>
                    <li>Pharmaceutical companies requiring certified botanical ingredients</li>
                </ul>
            </div>
            <div class="pl-intro-stats">
                <div class="pl-stat"><strong>15+</strong><span>Years of private label experience</span></div>
                <div class="pl-stat"><strong>200+</strong><span>Private label SKUs produced annually</span></div>
                <div class="pl-stat"><strong>30+</strong><span>Countries served under client brands</span></div>
                <div class="pl-stat"><strong>3–5 days</strong><span>Sample dispatch from artwork approval</span></div>
            </div>
        </div>
    </div>
</section>

{{-- MOQ by product --}}
<section class="export-section export-section-alt">
    <div class="container">
        <div class="section-header-center">
            <span class="section-label">Minimum Orders</span>
            <h2>Minimum Order Quantities by Product</h2>
            <p>MOQs are per SKU per order. Mixed-product orders are accommodated — contact us for a consolidated quote.</p>
        </div>
        <div class="moq-table-wrap">
            <table class="moq-table">
                <thead>
                    <tr>
                        <th>Product Category</th>
                        <th>Retail Pack MOQ</th>
                        <th>Bulk / Food-Service MOQ</th>
                        <th>Sample</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Ceylon Cinnamon — Quills &amp; Sticks</td><td>500 units</td><td>100 kg</td><td>Available</td></tr>
                    <tr><td>Ceylon Cinnamon — Ground / Powder</td><td>500 units</td><td>100 kg</td><td>Available</td></tr>
                    <tr><td>Ceylon Tea — Loose Leaf &amp; Dust</td><td>1,000 units</td><td>250 kg</td><td>Available</td></tr>
                    <tr><td>Ceylon Tea — Tea Bags (string &amp; tag)</td><td>5,000 bags</td><td>—</td><td>Available</td></tr>
                    <tr><td>Ceylon Coffee — Roasted &amp; Ground</td><td>500 units</td><td>100 kg</td><td>Available</td></tr>
                    <tr><td>Black / White / Green Pepper</td><td>500 units</td><td>100 kg</td><td>Available</td></tr>
                    <tr><td>Cardamom, Cloves, Nutmeg</td><td>500 units</td><td>50 kg</td><td>Available</td></tr>
                    <tr><td>Spice Blends &amp; Custom Formulations</td><td colspan="2">Contact us — dependent on formula complexity</td><td>Available</td></tr>
                </tbody>
            </table>
        </div>
        <p class="moq-note">All pack sizes are negotiable. We produce retail packs from 25 g to 1 kg and bulk packs from 5 kg to 50 kg. <a href="{{ route('contact') }}">Contact us</a> for exact pricing.</p>
    </div>
</section>

{{-- Packaging options --}}
<section class="export-section">
    <div class="container">
        <div class="section-header-center">
            <span class="section-label">Packaging</span>
            <h2>Packaging Formats &amp; Materials</h2>
            <p>We work with a range of food-grade packaging materials. All formats meet EU food-contact material regulations (Regulation EC 1935/2004).</p>
        </div>
        <div class="pkg-grid">
            <div class="pkg-card">
                <div class="pkg-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 9h18M9 21V9"/></svg>
                </div>
                <h3>Kraft Stand-Up Pouch</h3>
                <p>Flat-bottom, resealable zip-lock. Natural brown or white kraft, with or without window. Most popular for premium retail positioning.</p>
                <div class="pkg-sizes">25 g / 50 g / 100 g / 200 g / 500 g / 1 kg</div>
            </div>
            <div class="pkg-card">
                <div class="pkg-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                </div>
                <h3>Food-Grade Tin / Canister</h3>
                <p>Printed or plain tin with press-fit or friction lid. Premium look for gift and specialty retail. Best for loose tea and ground coffee.</p>
                <div class="pkg-sizes">50 g / 100 g / 200 g / 500 g</div>
            </div>
            <div class="pkg-card">
                <div class="pkg-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path d="M12 3v9l5 3"/></svg>
                </div>
                <h3>Glass Jar</h3>
                <p>Flint or amber glass with aluminium or PP lid. Best for ground spices, herb blends, and premium cinnamon powder for specialty food retail.</p>
                <div class="pkg-sizes">50 g / 100 g / 200 g</div>
            </div>
            <div class="pkg-card">
                <div class="pkg-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 2h18v4H3zM3 18h18v4H3zM7 6v12M17 6v12"/></svg>
                </div>
                <h3>Retail Carton (Tea Bags)</h3>
                <p>Full-colour outer carton with individual string-and-tag tea bags, envelope sachets, or pyramid bags. 25-bag, 50-bag, and 100-bag formats.</p>
                <div class="pkg-sizes">25 / 50 / 100 bags</div>
            </div>
            <div class="pkg-card">
                <div class="pkg-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                </div>
                <h3>Woven Poly Bag (Bulk)</h3>
                <p>25 kg or 50 kg polypropylene woven bags with liner, printed with product details, net weight, and your brand. Standard for foodservice and industrial buyers.</p>
                <div class="pkg-sizes">25 kg / 50 kg</div>
            </div>
            <div class="pkg-card">
                <div class="pkg-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Custom / Bespoke</h3>
                <p>Have a specific packaging requirement? We work with trusted packaging suppliers to source and trial non-standard formats. MOQ and lead time vary by supplier.</p>
                <div class="pkg-sizes">Contact us for details</div>
            </div>
        </div>
    </div>
</section>

{{-- Label artwork specs --}}
<section class="export-section export-section-alt">
    <div class="container">
        <div class="export-doc-grid">
            <div class="export-doc-text">
                <span class="section-label">Artwork</span>
                <h2>Label Artwork Specifications</h2>
                <p>Submit your artwork files following these specifications. Our design team can assist with layout adaptation and mandatory regulatory text at no additional charge.</p>
                <a href="{{ route('contact') }}" class="btn btn-gold mt-3">Send Your Artwork</a>
            </div>
            <div class="export-doc-list">
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>File Format</strong><span>AI, PDF (press-quality), or EPS. CMYK colour mode. RGB files not accepted for print.</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Resolution</strong><span>Minimum 300 DPI at print size. Bitmap/raster elements embedded at 600 DPI for sharp results.</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Bleed &amp; Safe Zone</strong><span>3 mm bleed on all edges. Keep critical content 5 mm inside the trim line. We provide die-cut templates on request.</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Mandatory Label Info</strong><span>Product name, net weight, ingredients list, country of origin ("Product of Sri Lanka"), best-before date format, storage instructions, and your company address. We advise on destination-specific requirements (EU 1169/2011, FDA, SFDA, etc.).</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Certification Marks</strong><span>We supply print-ready artwork for organic, fair-trade, or Rainforest Alliance marks you are licensed to use. Unlicensed logos cannot be printed.</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Approval Process</strong><span>We supply a PDF proof and a physical print sample before full production run. Approval required in writing before proceeding.</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Process timeline --}}
<section class="export-section">
    <div class="container">
        <div class="section-header-center">
            <span class="section-label">Timeline</span>
            <h2>Private Label Process &amp; Lead Times</h2>
        </div>
        <div class="export-steps">
            <div class="export-step">
                <div class="export-step-num">01</div>
                <h3>Inquiry &amp; Briefing</h3>
                <p>Submit your product specification, packaging format, quantity, and destination. We respond with a Proforma quote within 24–48 hours. <em>Day 0–2.</em></p>
            </div>
            <div class="export-step">
                <div class="export-step-num">02</div>
                <h3>Sampling</h3>
                <p>Generic (unbranded) product samples dispatched within 3–5 working days for quality evaluation. Sample cost refunded on first commercial order. <em>Day 3–7.</em></p>
            </div>
            <div class="export-step">
                <div class="export-step-num">03</div>
                <h3>Artwork Submission &amp; Proof</h3>
                <p>Submit your artwork files. We produce a PDF proof within 2 working days and a physical print sample within 5 working days. <em>Day 8–14.</em></p>
            </div>
            <div class="export-step">
                <div class="export-step-num">04</div>
                <h3>Production</h3>
                <p>On artwork and PO approval, production begins. Typical production lead time: 15–25 working days depending on order size and product complexity. <em>Day 15–40.</em></p>
            </div>
            <div class="export-step">
                <div class="export-step-num">05</div>
                <h3>QC &amp; Documentation</h3>
                <p>Final product inspected, COA issued, and all export documents prepared including Certificate of Origin and Phytosanitary Certificate. <em>Day 38–42.</em></p>
            </div>
            <div class="export-step">
                <div class="export-step-num">06</div>
                <h3>Shipment</h3>
                <p>Goods shipped from Colombo. Bill of Lading and tracking details sent on despatch. Typical sea freight to EU/US: 20–35 days. <em>Day 43+.</em></p>
            </div>
        </div>
        <p class="moq-note" style="text-align:center;margin-top:2rem">Lead times are indicative and subject to order complexity, packaging stock availability, and production scheduling. Confirmed timelines provided in Proforma Invoice.</p>
    </div>
</section>

{{-- CTA --}}
<section class="export-cta-section">
    <div class="container">
        <div class="export-cta-inner">
            <h2>Ready to Launch Your Brand?</h2>
            <p>Share your product brief and we'll respond with a quotation, sample plan, and timeline within 24 hours.</p>
            <a href="{{ route('contact') }}" class="btn btn-gold btn-lg">Start Your Private Label Project
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>

@endsection
