@extends('layouts.app')

@section('title', 'Export Services')
@section('meta_description', 'Full-service B2B export of Ceylon spices, teas, coffees and aromatic oils to 60+ countries. Flexible MOQ, ISO 22000 certified, competitive Incoterms. Request a quote.')

@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "What is the minimum order quantity for Ceylon spice exports?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "MOQs vary by product and packaging format. For Ceylon Cinnamon quills and powder, the retail pack MOQ is 500 units and bulk MOQ is 100 kg. Ceylon Tea starts at 1,000 units retail or 250 kg bulk. Contact us for a consolidated quote on mixed-product orders."
      }
    },
    {
      "@type": "Question",
      "name": "What Incoterms does Ceylon Aroma support?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "We support EXW (Ex Works Kegalle — our default), FOB (Free On Board Colombo — most requested), CIF (Cost, Insurance & Freight), and CIP (Carriage & Insurance Paid). All terms are Incoterms 2020."
      }
    },
    {
      "@type": "Question",
      "name": "How long does it take to dispatch product samples?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Product samples are dispatched within 3–5 working days via DHL or FedEx, accompanied by a Certificate of Analysis (COA)."
      }
    },
    {
      "@type": "Question",
      "name": "What certifications does Ceylon Aroma hold?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Ceylon Aroma holds ISO 22000:2018 (Food Safety Management), HACCP, USDA NOP Organic, EU Organic (EC 834/2007), SLSI certification, and GMP compliance. Full certification documentation is available upon request."
      }
    },
    {
      "@type": "Question",
      "name": "What export documents are provided with each shipment?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Standard export documents include: Commercial Invoice, Packing List, Certificate of Origin, Phytosanitary Certificate, Bill of Lading or Airway Bill, and Certificate of Analysis. Additional documents such as Health Certificates or pre-shipment inspection reports by SGS, Intertek, or Bureau Veritas can be arranged on request."
      }
    }
  ]
}
</script>
@endpush

@section('content')

{{-- Hero --}}
<div class="export-hero">
    <div class="container">
        <span class="section-label export-hero-label">International Trade</span>
        <h1>Export Services</h1>
        <p>From 500 kg to full container programmes — we handle the entire export cycle. Source procurement, processing, quality testing, freight booking, and documentation. You receive product and paperwork together.</p>
        <a href="{{ route('contact') }}" class="btn btn-gold">Request Export Quote
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>
</div>

{{-- Export process --}}
<section class="export-section">
    <div class="container">
        <div class="section-header-center">
            <span class="section-label">How It Works</span>
            <h2>Our Export Process</h2>
            <p>From first enquiry to delivered shipment — a transparent, documented process at every step.</p>
        </div>
        <div class="export-steps">
            <div class="export-step">
                <div class="export-step-num">01</div>
                <h3>Enquiry &amp; Quotation</h3>
                <p>Send your product specification, required quantity, and destination port. We respond with a FOB or CIF quote, available lot certificate, and lead time within 24 hours on business days.</p>
            </div>
            <div class="export-step">
                <div class="export-step-num">02</div>
                <h3>Sample Approval</h3>
                <p>Paid samples dispatched with full Certificate of Analysis within 3–5 working days. Sample costs are credited against your first commercial order of 500 kg or more.</p>
            </div>
            <div class="export-step">
                <div class="export-step-num">03</div>
                <h3>Purchase Order &amp; Pro Forma Invoice</h3>
                <p>You issue a PO. We issue a pro forma invoice with final price, payment terms (50% T/T advance + 50% against copy of shipping documents, or LC at sight), and confirmed shipment date.</p>
            </div>
            <div class="export-step">
                <div class="export-step-num">04</div>
                <h3>Production &amp; Quality Control</h3>
                <p>Product is processed, QC-tested at source, and a pre-shipment sample sent to the independent ISO 17025 laboratory. You receive the CoA before the container is sealed.</p>
            </div>
            <div class="export-step">
                <div class="export-step-num">05</div>
                <h3>Shipment &amp; Documentation</h3>
                <p>We book freight, obtain all export certificates, and release the full documentation pack — BL, Certificate of Origin, Phytosanitary Certificate, CoA, ISO cert, packing list, invoice — within 48 hours of container departure.</p>
            </div>
            <div class="export-step">
                <div class="export-step-num">06</div>
                <h3>Ongoing Supply Programme</h3>
                <p>Your account manager proactively notifies you of crop availability, price movements, and new products. Quarterly review calls to align supply with your forecast demand.</p>
            </div>
        </div>
    </div>
</section>

{{-- Incoterms --}}
<section class="export-section export-section-alt">
    <div class="container">
        <div class="section-header-center">
            <span class="section-label">Trade Terms</span>
            <h2>Supported Incoterms 2020</h2>
            <p>We accommodate the following international trade terms. Our default is EXW Kegalle; FOB and CIF are most commonly requested.</p>
        </div>
        <div class="export-incoterm-grid">
            <div class="incoterm-card incoterm-card-featured">
                <div class="incoterm-code">EXW</div>
                <div class="incoterm-name">Ex Works — Kegalle</div>
                <p>Goods available at our facility. Buyer arranges and pays for all freight, insurance, and customs clearance from our warehouse.</p>
                <span class="incoterm-badge">Default Term</span>
            </div>
            <div class="incoterm-card">
                <div class="incoterm-code">FOB</div>
                <div class="incoterm-name">Free On Board — Colombo</div>
                <p>We deliver goods to Colombo Port and load onto the nominated vessel. Buyer bears risk and cost from the ship's rail onwards.</p>
                <span class="incoterm-badge incoterm-badge-pop">Most Requested</span>
            </div>
            <div class="incoterm-card">
                <div class="incoterm-code">CIF</div>
                <div class="incoterm-name">Cost, Insurance & Freight</div>
                <p>We arrange and pay for freight and marine insurance to the destination port. Risk transfers at the port of loading.</p>
            </div>
            <div class="incoterm-card">
                <div class="incoterm-code">CIP</div>
                <div class="incoterm-name">Carriage & Insurance Paid</div>
                <p>We arrange carriage and insurance to a named destination. Suitable for multimodal transport including air freight.</p>
            </div>
        </div>
    </div>
</section>

{{-- Freight modes --}}
<section class="export-section">
    <div class="container">
        <div class="section-header-center">
            <span class="section-label">Logistics</span>
            <h2>Freight Options</h2>
        </div>
        <div class="freight-grid">
            <div class="freight-card">
                <div class="freight-icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 21h20"/><path d="M6 9h12v6H6z"/><path d="M9 9V6h6v3"/><rect x="3" y="15" width="18" height="3" rx="1"/><path d="M8 15v3M16 15v3"/></svg>
                </div>
                <h3>Sea Freight — FCL</h3>
                <p>Full Container Load (20' or 40') from Colombo Port. Ideal for large bulk orders. Lead time: 14–35 days depending on destination.</p>
                <div class="freight-detail"><strong>Port:</strong> Colombo (LKCMB)</div>
                <div class="freight-detail"><strong>Min. Order:</strong> 1 FCL (~17–25MT)</div>
            </div>
            <div class="freight-card">
                <div class="freight-icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                </div>
                <h3>Sea Freight — LCL</h3>
                <p>Less than Container Load for smaller shipments consolidated with other cargo. Flexible quantities for trial or repeat orders.</p>
                <div class="freight-detail"><strong>Port:</strong> Colombo (LKCMB)</div>
                <div class="freight-detail"><strong>Min. Order:</strong> 500 kg</div>
            </div>
            <div class="freight-card">
                <div class="freight-icon">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 20 3c-1-1-3-1-4.5.5L12 7 3.8 5.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 3.7c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.1z"/></svg>
                </div>
                <h3>Air Freight</h3>
                <p>Express shipments via BIA (Colombo), consolidated through DHL, FedEx, or Emirates SkyCargo. Ideal for samples and urgent orders.</p>
                <div class="freight-detail"><strong>Airport:</strong> BIA — Colombo (CMB)</div>
                <div class="freight-detail"><strong>Lead time:</strong> 2–5 days</div>
            </div>
        </div>
    </div>
</section>

{{-- Documentation --}}
<section class="export-section export-section-alt">
    <div class="container">
        <div class="export-doc-grid">
            <div class="export-doc-text">
                <span class="section-label">Compliance</span>
                <h2>Export Documentation</h2>
                <p>We prepare and supply all documentation required for customs clearance and regulatory compliance at the destination.</p>
                <p>All documents are available in digital (PDF) and original hard-copy form.</p>
                <a href="{{ route('contact') }}" class="btn btn-gold mt-3">Ask About Documentation</a>
            </div>
            <div class="export-doc-list">
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Commercial Invoice</strong><span>Price, quantity, Harmonised System (HS) codes, buyer/seller details</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Packing List</strong><span>Net/gross weights, dimensions, carton count, marks &amp; numbers</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Certificate of Origin</strong><span>Issued by the Ceylon Chamber of Commerce — Form A/GSP available</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Phytosanitary Certificate</strong><span>Issued by the Department of Agriculture, Sri Lanka</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Certificate of Analysis (COA)</strong><span>Moisture, purity, heavy metals, microbiology, pesticide residues</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Health Certificate</strong><span>Issued by the Sri Lanka Standards Institution where required</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Bill of Lading / Airway Bill</strong><span>Issued by the carrier — original copies provided for LC compliance</span></div>
                </div>
                <div class="doc-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--gold)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <div><strong>Fumigation Certificate</strong><span>Available on request for wooden packing material (ISPM 15)</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MOQ / Minimums --}}
<section class="export-section">
    <div class="container">
        <div class="section-header-center">
            <span class="section-label">Minimum Orders</span>
            <h2>Minimum Order Quantities</h2>
            <p>Indicative MOQs by product category. Contact us for exact minimums for specific products or custom blends.</p>
        </div>
        <div class="moq-table-wrap">
            <table class="moq-table">
                <thead>
                    <tr>
                        <th>Product Category</th>
                        <th>Sea Freight (FCL)</th>
                        <th>Sea Freight (LCL)</th>
                        <th>Air Freight</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Ceylon Cinnamon (Quills, Powder, Oil)</td><td>5,000 kg</td><td>500 kg</td><td>50 kg</td></tr>
                    <tr><td>Ceylon Tea (Orthodox, CTC, Green)</td><td>10,000 kg</td><td>1,000 kg</td><td>100 kg</td></tr>
                    <tr><td>Ceylon Coffee (Green, Roasted)</td><td>5,000 kg</td><td>500 kg</td><td>50 kg</td></tr>
                    <tr><td>Pepper (Black, White, Green)</td><td>5,000 kg</td><td>500 kg</td><td>50 kg</td></tr>
                    <tr><td>Cardamom, Cloves, Nutmeg</td><td>3,000 kg</td><td>300 kg</td><td>30 kg</td></tr>
                    <tr><td>Turmeric, Cumin, Ginger (Dried)</td><td>5,000 kg</td><td>500 kg</td><td>50 kg</td></tr>
                    <tr><td>Essential Oils &amp; Extracts</td><td>500 kg</td><td>50 kg</td><td>5 kg</td></tr>
                    <tr><td>Sample Orders</td><td colspan="3" style="text-align:center;color:var(--muted-text)">No minimum — DHL/FedEx, 3–5 working days</td></tr>
                </tbody>
            </table>
        </div>
        <p class="moq-note">All weights are net product weight. MOQs may vary by processing grade or packaging specification. <a href="{{ route('contact') }}">Contact us</a> for custom requirements.</p>
    </div>
</section>

{{-- CTA --}}
<section class="export-cta-section">
    <div class="container">
        <div class="export-cta-inner">
            <h2>Ready to Source Directly from Sri Lanka?</h2>
            <p>Send your product specification and destination country. We'll respond with a priced FOB or CIF quote within 24 hours — no obligation to proceed.</p>
            <a href="{{ route('contact') }}" class="btn btn-gold btn-lg">Request Your Export Quote
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>

@endsection
