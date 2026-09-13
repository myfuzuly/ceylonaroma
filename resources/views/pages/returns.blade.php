@extends('layouts.app')
@section('title', 'Return & Quality Claims Policy')
@section('meta_description', 'Return, refund and quality-claims policy for Ceylon Aroma Commodities Exports (Private) Limited — how we handle export shipment quality disputes.')

@section('content')
<div class="contact-hero">
    <div class="container">
        <span class="section-label contact-hero-label">Legal</span>
        <h1>Return &amp; Quality Claims Policy</h1>
        <p>Last updated: {{ date('d F Y') }}</p>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width:820px">
        <div class="blog-content" style="color:var(--ink)">

            <h2>1. Nature of Our Business</h2>
            <p>Ceylon Aroma Commodities Exports (Private) Limited supplies bulk and private-label spices, tea, coffee and natural products to wholesale importers, distributors and retailers worldwide. As a B2B export business shipping internationally under agreed Incoterms, our returns process differs from a retail consumer policy — physical return of goods across borders is rarely practical or required, so disputes are resolved through inspection, credit notes, or replacement shipments rather than reverse shipping.</p>

            <h2>2. Pre-Shipment Quality Control</h2>
            <p>Every consignment is quality-checked against the agreed specification (moisture content, grade, packaging, labeling) before it leaves our facility. Where requested, we provide pre-shipment sample approval, third-party inspection (e.g. SGS, Intertek) or a certificate of analysis prior to dispatch.</p>

            <h2>3. Reporting a Quality Claim</h2>
            <p>If goods received do not conform to the agreed specification, purchase order, or are damaged in transit, the claim must be submitted in writing to <a href="mailto:info@ceylonaroma.com" style="color:var(--forest)">info@ceylonaroma.com</a> within <strong>7 calendar days</strong> of the goods arriving at the destination port or warehouse. Claims must include:</p>
            <ul>
                <li>Invoice / order number and container or AWB reference</li>
                <li>Clear photographs of the goods, packaging and any damage</li>
                <li>An independent laboratory or surveyor report where the claim concerns quality, contamination or specification deviation</li>
            </ul>

            <h2>4. What Happens Next</h2>
            <p>We review every claim within 5 business days of receiving full supporting evidence. Depending on the finding, we will offer one of the following at our discretion: a replacement shipment of the affected quantity, a credit note applied to the next order, or a partial/full refund of the invoice value for the disputed goods.</p>

            <h2>5. Non-Returnable Situations</h2>
            <p>Because our products are perishable or consumable natural goods shipped internationally, we do not accept physical return of goods once they have cleared customs at the destination. We are not able to accept claims for: normal variation in natural product color/aroma within spec, damage caused after delivery (improper storage, re-packing, delayed customs clearance), or claims submitted after the 7-day window above.</p>

            <h2>6. Order Cancellations</h2>
            <p>Orders may be cancelled or amended free of charge before production has started. Once raw material has been allocated or processing has begun, cancellation may be subject to a cost-recovery charge reflecting work completed and materials committed.</p>

            <h2>7. Limitation</h2>
            <p>Our liability for any accepted claim is limited to the invoice value of the affected goods and does not extend to consequential loss, loss of resale profit, or third-party claims. This policy operates alongside, and does not replace, the terms in our <a href="{{ route('terms') }}" style="color:var(--forest)">Terms &amp; Conditions</a>.</p>

            <h2>8. Contact</h2>
            <p>
                <strong>Ceylon Aroma Commodities Exports (Pvt) Ltd</strong><br>
                No: F – 05, New City Building, Nidahas Mawatha, Kegalle, Sri Lanka<br>
                Email: <a href="mailto:info@ceylonaroma.com" style="color:var(--forest)">info@ceylonaroma.com</a><br>
                Phone: <a href="tel:+94718821234" style="color:var(--forest)">+94 71 882 1234</a>
            </p>

        </div>
    </div>
</section>
@endsection
