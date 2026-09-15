@extends('layouts.app')

@section('title', $blog_post->title)
@section('meta_description', $blog_post->excerpt ?: 'Read ' . $blog_post->title . ' — export insights and product guides from Ceylon Aroma, Sri Lanka.')
@section('og_type', 'article')

@php
$blogImgUrl = $blog_post->image
    ? (\Illuminate\Support\Str::startsWith($blog_post->image, ['http', '/']) ? $blog_post->image : asset('storage/'.$blog_post->image))
    : null;
$postImg = $blogImgUrl
    ? $blogImgUrl
    : match(true) {
        str_contains($blog_post->slug, 'tea')    => 'https://ceylonaroma.com/images/blog-tea.jpg',
        str_contains($blog_post->slug, 'coffee') => 'https://ceylonaroma.com/images/blog-coffee.webp',
        str_contains($blog_post->slug, 'pepper') => 'https://ceylonaroma.com/images/blog-spices.webp',
        default                                  => 'https://ceylonaroma.com/images/blog-cinnamon.jpg',
    };
@endphp
@section('og_image', $postImg)

@push('schema')
@php
/* ── Per-post FAQ data ── */
$postFaqs = [
  'how-to-import-ceylon-cinnamon-guide' => [
    ['q'=>'What are the grades of Ceylon cinnamon?','a'=>'Ceylon cinnamon is graded as Alba (00000) — finest quill under 6mm; Continental (000) — 6–10mm, the most exported; Mexican (0–1) — value grade for extraction; and Hamburg (0H) for mid-range applications.'],
    ['q'=>'What documents are required to import Ceylon cinnamon?','a'=>'Required documents include: Phytosanitary Certificate, Certificate of Origin, ISO 22000/HACCP certificate, and a heavy metal and pesticide residue test report.'],
    ['q'=>'What is the minimum order for Ceylon cinnamon wholesale?','a'=>'Our minimum order is 50 kg for sample orders and 500 kg for commercial shipments. Full container (FCL) orders start from 5,000 kg.'],
  ],
  'ceylon-tea-grades-importers-guide' => [
    ['q'=>'What are the main Ceylon tea grades?','a'=>'Orthodox whole-leaf grades include OP (Orange Pekoe), FOP (Flowery Orange Pekoe), and GFOP (Golden Flowery Orange Pekoe). Broken grades include BOP (Broken Orange Pekoe) and BOPF (Broken Orange Pekoe Fannings), which is the most widely exported grade globally.'],
    ['q'=>'Which Ceylon tea grade is best for teabags?','a'=>'BOPF (Broken Orange Pekoe Fannings) is optimised for envelope-style teabags, offering a fast-brewing, consistent cup. BOP suits pyramid bags and stronger brews.'],
    ['q'=>'What is the minimum order for Ceylon tea wholesale?','a'=>'Minimum order is 100 kg for bulk tea and 500 units for private label retail packaging.'],
  ],
  'iso-22000-haccp-certification-spice-importers' => [
    ['q'=>'What is HACCP certification?','a'=>'HACCP (Hazard Analysis and Critical Control Points) is a preventive food safety management system. It is a regulatory requirement in the EU and US for food manufacturers and is a key due-diligence requirement for spice importers worldwide.'],
    ['q'=>'What is ISO 22000?','a'=>'ISO 22000:2018 is an international food safety management system standard that integrates HACCP principles, audited by IAF-accredited third-party bodies. Ceylon Aroma holds a current ISO 22000 certificate, available on request.'],
    ['q'=>'How do I verify a spice supplier\'s food safety certificates?','a'=>'Ask for the full certificate document (not just a logo), check that the scope covers your specific product, verify the certificate is within its validity period, and confirm the certifying body is IAF-accredited.'],
  ],
  'shipping-spices-sri-lanka-incoterms-freight-guide' => [
    ['q'=>'What is the shipping lead time from Sri Lanka to Europe?','a'=>'Sea freight from Colombo to European ports typically takes 18–24 days. To the USA East Coast: 22–28 days. Middle East: 7–12 days. Australia: 14–18 days.'],
    ['q'=>'What Incoterm is best for importing spices from Sri Lanka?','a'=>'FOB Colombo is the most common term for experienced importers — you control freight and insurance from the port. CIF is convenient for new importers as the exporter arranges freight and marine insurance. DAP provides door-to-door delivery.'],
    ['q'=>'When does LCL shipping make sense for spice imports?','a'=>'LCL (Less-than-Container-Load) suits orders under 5–8 CBM or roughly under 2,000 kg. A full 20-foot FCL container offers a 20–35% cost saving per kg for larger volumes.'],
  ],
  'private-label-spices-sri-lanka-process' => [
    ['q'=>'What is the minimum order for private label spices from Sri Lanka?','a'=>'Our private label MOQ is 500 units for retail pouches and 100 kg net for bulk bags. Contact our export team to discuss custom requirements.'],
    ['q'=>'How long does the private label process take?','a'=>'From brand brief to first shipment typically takes 6–10 weeks: 1–2 weeks for product specification and sample production, 1 week for sample approval, 2–3 weeks for artwork and packaging, 2–3 weeks for production and quality control.'],
    ['q'=>'What packaging formats are available for private label spices?','a'=>'We offer retail pouches (50g–1kg), stand-up ziplock bags, glass jars, bulk kraft bags (1–25kg), and custom packaging to your specification. All packaging can carry your brand artwork.'],
  ],
  'ceylon-black-pepper-vs-indian-pepper-buyers-guide' => [
    ['q'=>'How does Ceylon black pepper differ from Indian Malabar pepper?','a'=>'Ceylon pepper (Kandy and Matale regions) delivers a clean, bright heat with floral-citrus aromatic notes and volatile oil content of 3.5–5%. Malabar pepper is earthier and more resinous, ideal for industrial applications. Tellicherry is size-graded Indian pepper with greater aroma complexity.'],
    ['q'=>'What is the piperine content of Ceylon black pepper?','a'=>'Ceylon black pepper typically contains 5–7% piperine (the compound responsible for heat), comparable to premium Indian grades. Volatile oil content of 3.5–5% gives it a particularly aromatic quality valued by premium spice brands.'],
    ['q'=>'Which black pepper origin is best for fine dining applications?','a'=>'For premium retail and fine dining where origin provenance matters, Ceylon black pepper is the preferred choice. For cost-effective industrial and food manufacturing use, Malabar is the most economical high-volume option.'],
  ],
  'ceylon-coffee-private-label-sourcing-guide' => [
    ['q'=>'What is the flavour profile of Ceylon Arabica coffee?','a'=>'High-grown Ceylon Arabica (1,000–1,500m elevation from Kandy, Nuwara Eliya, and Badulla) produces a medium-bodied cup with mild acidity, subtle chocolate and dried-fruit notes, and a clean, sweet finish.'],
    ['q'=>'What is the minimum order for Ceylon coffee private label?','a'=>'Minimum order is 50 kg for roasted private label (whole bean or ground) and 200 kg for green bean export. We supply branded retail bags (100g–1kg), capsule filling, and bulk green bean to specification.'],
    ['q'=>'Do you supply green coffee beans from Sri Lanka?','a'=>'Yes, Ceylon Aroma exports unroasted green Arabica and Robusta beans from Sri Lanka. Green bean is available for buyers who roast in their own facility or partner roastery. Minimum 200 kg.'],
  ],
  'ceylon-cloves-grades-moc-wholesale-export-guide' => [
    ['q'=>'What are the grades of Ceylon cloves?','a'=>'Ceylon cloves are traded in three main grades: HPS (Hand-Picked Select) — whole buds, moisture ≤12%, volatile oil ≥15%, stems <2%, the premium export grade; FAQ (Fair Average Quality) — whole buds with up to 5% stems, the most commonly traded bulk grade; and Broken/Stemmy for oleoresin and oil extraction.'],
    ['q'=>'What is the MOC specification for Ceylon cloves?','a'=>'MOC (Moisture on Commodity) for whole Ceylon cloves is maximum 12% under Sri Lanka\'s SLS 37 standard. EU buyers typically specify ≤10% in contracts to allow for transit moisture gain without breaching import limits on arrival.'],
    ['q'=>'What is the minimum order quantity for Ceylon cloves wholesale?','a'=>'Ceylon Aroma accepts sample orders from 25 kg HPS whole cloves. Commercial bulk shipments start from 500 kg (LCL), with full 20-foot FCL containers holding approximately 14,000–15,000 kg for the best per-kilogram rate.'],
  ],
  'eu-spice-import-regulations-compliance-guide' => [
    ['q'=>'What are the EU aflatoxin limits for spices?','a'=>'Under EU Regulation (EC) No 1881/2006, the maximum permitted level of aflatoxin B1 in spices is 5 µg/kg, and total aflatoxins (B1+B2+G1+G2) must not exceed 10 µg/kg. This is among the most common causes of spice shipment rejections at EU borders.'],
    ['q'=>'What food safety certificates must a Sri Lankan spice supplier hold for EU export?','a'=>'EU-destined spice shipments require: ISO 22000:2018 or FSSC 22000 certificate, HACCP plan documentation, an ISO 17025-accredited multi-residue pesticide test report (≥200 compounds), aflatoxin and heavy metals analysis, Phytosanitary Certificate, and a Certificate of Origin (Form A for GSP).'],
    ['q'=>'How do I check if a product is on the EU enhanced import controls list?','a'=>'Check the current Annex II of Commission Implementing Regulation (EU) 2019/1793 via the EU TRACES NT system and the RASFF consumer portal. Enhanced controls require additional official certification and increased border sampling, adding cost and clearance time. Verify before every new supply contract.'],
  ],
  'health-benefits-black-pepper' => [
    ['q'=>'What is piperine and why is it important?','a'=>'Piperine is the primary alkaloid in black pepper, responsible for its heat and most of its health properties. It has documented anti-inflammatory, antioxidant, and neuroprotective effects, and is best known for dramatically increasing the absorption of other nutrients — most famously curcumin from turmeric, by up to 2,000% when taken together.'],
    ['q'=>'How does black pepper increase nutrient absorption?','a'=>'Piperine inhibits P-glycoprotein (an efflux pump in intestinal cells) and certain cytochrome P450 enzymes that break down compounds before they enter the bloodstream. By slowing this first-pass metabolism, more of the nutrient survives to reach systemic circulation. This is why turmeric-and-pepper combinations are pharmacologically meaningful, not just culinary habit.'],
    ['q'=>'How much black pepper should I eat per day for health benefits?','a'=>'Most research uses piperine doses of 5–20 mg per day. A quarter-teaspoon of freshly ground black pepper (about 0.6 g) contains roughly 30–42 mg piperine — above the threshold studied in bioavailability research. Freshly grinding whole peppercorns matters: volatile oils degrade quickly after grinding.'],
    ['q'=>'Is Ceylon black pepper better than Indian pepper?','a'=>'Both are Piper nigrum and deliver similar piperine content, so health benefits are comparable. Ceylon pepper from Kandy and Matale districts has a brighter, cleaner heat with citrus-floral aromatic complexity and typically higher volatile oil content (3.5–5% vs 2.5–3.5% for Malabar). For premium culinary and supplement applications, Ceylon is preferred; for high-volume industrial uses, Malabar is the most economical choice.'],
    ['q'=>'Can black pepper interact with medications?','a'=>'At normal culinary doses (a pinch to a teaspoon), black pepper does not cause clinically significant drug interactions for most people. However, concentrated piperine supplements (5–20 mg extract) can meaningfully raise blood levels of certain drugs by inhibiting their metabolism — particularly cyclosporine, phenytoin, and some chemotherapy agents. Speak to your pharmacist before taking piperine supplements if you take prescription medications.'],
  ],
  'health-benefits-ceylon-cinnamon' => [
    ['q'=>'Is Ceylon cinnamon safe to take every day?','a'=>'Yes. Unlike Cassia, Ceylon cinnamon contains only trace amounts of coumarin (0.004 mg/g vs 1–12 mg/g in Cassia) and is considered safe for daily consumption at normal dietary doses up to 6 g/day. Long-term supplementation at these levels has not produced adverse effects in clinical trials.'],
    ['q'=>'How much Ceylon cinnamon should I take for blood sugar benefits?','a'=>'Clinical trials showing blood glucose benefits have used doses between 1 g and 6 g per day, with the most studied range being 1–3 g (about ½–1 teaspoon of ground cinnamon). Benefits appear dose-dependent up to approximately 3 g. Dividing the dose across two or three meals may be more effective than a single large dose.'],
    ['q'=>'How do I tell real Ceylon cinnamon from Cassia?','a'=>'Ceylon cinnamon quills are thin, multi-layered, and papery — they crumble easily and roll into a tight spiral with many inner layers visible at the end. Cassia sticks are thick, hard, and usually just a single layer. On product labels, look for the botanical name Cinnamomum verum or the origin "Sri Lanka."'],
    ['q'=>'What makes Kegalle, Sri Lanka cinnamon special?','a'=>'The Kegalle district in the Sabaragamuwa Province of Sri Lanka has soil composition, humidity, and elevation conditions that produce cinnamon with a high concentration of essential oils and polyphenols. Kegalle-origin cinnamon is prized by European spice importers for its aroma complexity and thin, paper-like bark grade.'],
    ['q'=>'Does Ceylon cinnamon help with weight loss?','a'=>'Cinnamon is not a direct weight-loss supplement, but by improving insulin sensitivity and reducing post-meal blood sugar spikes it may reduce hunger and carbohydrate cravings. Studies on people with metabolic syndrome have observed modest reductions in waist circumference over 12-week supplementation periods.'],
  ],
  'how-to-start-import-business-sri-lanka' => [
    ['q'=>'What is the minimum investment to start importing from Sri Lanka?','a'=>'A realistic starting budget for a first FCL spice shipment is USD 15,000–30,000, covering product cost (USD 10,000–20,000), freight (USD 2,000–3,500 to Europe), customs clearance (EUR 300–500), and working capital buffer. LCL trial shipments can start from USD 2,000–5,000 for 100–500 kg of product.'],
    ['q'=>'Do I need a food import licence to import spices?','a'=>'In most markets, no specific food import licence is required, but you need: business registration, EORI/customs ID, and food business registration. The EU requires FBO registration; the US requires FDA food facility registration; Australia requires AQIS import permits for certain plant products.'],
    ['q'=>'How long does it take from placing an order to receiving goods?','a'=>'Expect 6–10 weeks total: 1–2 weeks for production/packing after deposit; 2–4 weeks for vessel booking and container loading; 18–26 days ocean transit to Europe; 3–7 days for customs clearance and delivery. Air freight reduces transit to 3–5 days but costs 8–12x more than sea freight.'],
    ['q'=>'Can I import organic-certified products from Sri Lanka?','a'=>'Yes. Several major exporters hold EU Organic (Regulation 2018/848) certification through ECOCERT, SKAL, and Control Union. USDA NOP-certified exporters also exist. Organic-certified products command a 30–80% price premium and attract health food, specialty retail, and private label buyers.'],
    ['q'=>'What is the safest payment method for a first order?','a'=>'Use a Documentary Letter of Credit (LC) through a tier-1 international bank (HSBC, Citibank, Standard Chartered). The LC releases payment only when the exporter presents complete shipping documents — Bill of Lading, commercial invoice, packing list, certificate of origin, and phytosanitary certificate. Cost: typically 0.1–0.5% of the LC value from each bank.'],
  ],
  'ceylon-tea-vs-other-tea' => [
    ['q'=>'Is all tea from Sri Lanka called Ceylon tea?','a'=>'Yes. Any tea produced in Sri Lanka — black, green, white, or oolong — is technically Ceylon tea by origin. In commercial usage, "Ceylon tea" most often refers to black orthodox tea from Sri Lanka\'s high-grown or mid-grown regions. The Sri Lanka Tea Board\'s Lion Logo is the mark of genuinely Sri Lankan-packed tea; bulk tea for blending carries a Certificate of Origin from the Ceylon Chamber of Commerce.'],
    ['q'=>'Why does Ceylon tea taste brighter than Indian black tea?','a'=>'The brightness of Ceylon tea — particularly from Nuwara Eliya and Dimbula — is due to two factors: the specific climate of Sri Lanka\'s central highlands (cool nights, morning mist, and bright afternoon sun create a slow-growth cycle that concentrates aromatic compounds) and the orthodox rolling method, which preserves the essential oils responsible for citrus-like top notes. Assam\'s malt character comes from different cultivar genetics and a warmer, more humid growing environment.'],
    ['q'=>'What is the difference between OP and BOP grades?','a'=>'OP (Orange Pekoe) refers to a long, wiry, whole-leaf grade — the name comes from the Dutch "oranje" (referring to the Royal House of Orange, a mark of quality) not the fruit. BOP (Broken Orange Pekoe) is the same leaf broken into smaller pieces during sorting. BOP brews faster and with more colour than OP; OP has a more delicate, complex flavour. FBOP (Flowery BOP) contains golden tips mixed in, indicating a finer-plucked harvest. BOPF (BOP Fannings) is the smallest grade, used in teabags.'],
    ['q'=>'Can I buy Ceylon tea directly from Sri Lanka for my business?','a'=>'Yes. Ceylon tea is traded through the Colombo Tea Auction (the world\'s largest tea auction by volume) and through direct private sales between exporters and importers. For B2B buyers needing consistent supply above 100 kg per order, direct relationships with licensed Sri Lankan tea exporters are standard. Minimum order quantities for direct export typically start from 50–100 kg for premium grades. Ceylon Aroma handles tea exports alongside spices and can provide current auction prices and availability.'],
  ],
  'coffee-buying-guide-ceylon' => [
    ['q'=>'Is Ceylon coffee rare?','a'=>'Yes, relatively. Sri Lanka produces roughly 1,500–2,500 metric tonnes of coffee per year — compared to Ethiopia\'s 450,000+ tonnes or Brazil\'s 3.5 million tonnes. Most Ceylon coffee is consumed domestically or sold to specialty importers in Japan, South Korea, and Europe. It is genuinely limited in supply, which is why it commands a premium and is rarely found in mainstream supermarket channels.'],
    ['q'=>'How does Ceylon coffee compare to Jamaica Blue Mountain?','a'=>'Both are island-grown arabicas with mild, balanced profiles and low bitterness. Jamaica Blue Mountain commands a much higher premium (USD 50–100+/kg roasted retail) due to strict GI protection and heavily controlled supply. Ceylon specialty arabica delivers comparable balance and smoothness at a fraction of the price, making it a genuine value alternative for importers building specialty single-origin ranges without Blue Mountain\'s cost constraints.'],
    ['q'=>'Can I source certified organic Ceylon coffee?','a'=>'Yes, though supply is limited. Several smallholder cooperatives and estate processors in the Kandy and Badulla districts hold EU Organic certification (Control Union, ECOCERT). USDA NOP-certified Ceylon coffee is rarer still. Organic-certified green Ceylon coffee typically commands a 40–80% premium over conventional. Given the small farm sizes and limited pesticide use in traditional Ceylon highland cultivation, some "organic in practice" coffee is available without formal certification, though this cannot be marketed as organic in regulated markets.'],
    ['q'=>'What is the minimum order for importing Ceylon coffee?','a'=>'For specialty-grade green coffee, most Ceylon exporters work with minimums of 60 kg per lot (one burlap or GrainPro sack) for trial orders, scaling to 300–600 kg for regular shipments. Full-container commercial orders start from 10–15 metric tonnes. For importers new to Ceylon coffee, starting with 60–120 kg of one or two lots is recommended for quality evaluation and market testing before committing to container quantities.'],
  ],
  'ceylon-cinnamon-oil-bark-vs-leaf-buyers-guide' => [
    ['q'=>'What is the difference between cinnamon bark oil and cinnamon leaf oil?','a'=>'Ceylon cinnamon bark oil is dominated by trans-cinnamaldehyde (55–75%), giving it an intense sweet-spicy cinnamon character and commanding a price premium of 8–12× over leaf oil. Cinnamon leaf oil is dominated by eugenol (70–90%), has a warmer clove-like fragrance, and is suited to soap, cleaning, dental, and aromatherapy applications.'],
    ['q'=>'Can cinnamon leaf oil be substituted for bark oil in formulations?','a'=>'No. The two oils have fundamentally different chemical profiles and sensory characters. Substituting leaf oil (eugenol-dominant) into a recipe formulated for bark oil (cinnamaldehyde-dominant) will produce a noticeably different flavour, fragrance, and biological activity. They are not drop-in substitutes.'],
    ['q'=>'What are the IFRA limits for cinnamon bark oil in cosmetics?','a'=>'Under IFRA\'s 49th Amendment, cinnamon bark oil (cinnamaldehyde >50%) has a maximum use level of 0.05% in Category 4 leave-on fine fragrance products and 0.2% in Category 9 rinse-off products. Cinnamon leaf oil (eugenol >70%) has higher permitted levels: 0.5% leave-on and 1.6% rinse-off. Both require SDS and IFRA conformance certificates for EU cosmetic registration.'],
  ],
];
$currentFaqs = $postFaqs[$blog_post->slug] ?? [];
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": {!! json_encode($blog_post->title) !!},
  "description": {!! json_encode($blog_post->excerpt ?: $blog_post->title) !!},
  "image": "{{ $postImg }}",
  "datePublished": "{{ $blog_post->published_at?->toIso8601String() }}",
  "dateModified": "{{ $blog_post->updated_at?->toIso8601String() }}",
  "author": { "@type": "Organization", "name": "Ceylon Aroma", "url": "https://ceylonaroma.com" },
  "publisher": {
    "@type": "Organization",
    "name": "Ceylon Aroma",
    "logo": { "@type": "ImageObject", "url": "https://ceylonaroma.com/images/logo.png" }
  },
  "mainEntityOfPage": { "@type": "WebPage", "@id": "https://ceylonaroma.com/blog/{{ $blog_post->slug }}" }@if($blog_post->category),
  "articleSection": {!! json_encode($blog_post->category) !!}@endif
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home",            "item": "https://ceylonaroma.com" },
    { "@type": "ListItem", "position": 2, "name": "Knowledge Centre","item": "https://ceylonaroma.com/blog" },
    { "@type": "ListItem", "position": 3, "name": {!! json_encode($blog_post->title) !!}, "item": "https://ceylonaroma.com/blog/{{ $blog_post->slug }}" }
  ]
}
</script>
@if(count($currentFaqs))
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    @foreach($currentFaqs as $i => $faq)
    {
      "@type": "Question",
      "name": {!! json_encode($faq['q']) !!},
      "acceptedAnswer": { "@type": "Answer", "text": {!! json_encode($faq['a']) !!} }
    }{{ $i < count($currentFaqs) - 1 ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endif
@endpush

@section('content')

<div class="blog-post-hero">
    <div class="container">
        @if($blog_post->category)
        <span class="section-label blog-cat-label-gold">{{ $blog_post->category }}</span>
        @endif
        <h1>{{ $blog_post->title }}</h1>
        <p class="blog-meta"><time datetime="{{ $blog_post->published_at?->toDateString() }}">{{ $blog_post->published_at?->format('d M Y') }}</time></p>
    </div>
</div>

<section class="blog-post-layout">
    <div class="container">
        <article>
            @if($blog_post->image)
            <div class="blog-post-img">
                <img src="{{ $blogImgUrl }}" alt="{{ $blog_post->title }}">
            </div>
            @else
            <div class="blog-post-img-placeholder"></div>
            @endif

            <div class="blog-content">
                @if($blog_post->excerpt)
                <p class="blog-post-excerpt">{{ $blog_post->excerpt }}</p>
                @endif
                {!! preg_replace(
                    ['/<script\b[^>]*>[\s\S]*?<\/script>/i','/\s+on[a-z]+\s*=\s*(?:"[^"]*"|\'[^\']*\')/i','/href\s*=\s*"javascript:[^"]*"/i'],
                    ['','','href="#"'],
                    $blog_post->content ?? ''
                ) !!}
            </div>

            <div class="blog-post-foot">
                <a href="{{ route('blog.index') }}" class="btn btn-outline btn-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                    Back to Articles
                </a>
                <a href="{{ route('contact') }}" class="btn btn-primary btn-sm">Get Export Quote</a>
            </div>
        </article>

        {{-- Blog sidebar --}}
        <aside class="blog-sidebar">
            @if($related->count())
            <div class="sidebar-card">
                <h4>Related Articles</h4>
                @foreach($related as $r)
                <div class="blog-related-item">
                    <div class="blog-related-cat">{{ $r->category }}</div>
                    <a href="{{ route('blog.show', $r->slug) }}" class="blog-related-title">{{ $r->title }}</a>
                    <div class="blog-related-date"><time datetime="{{ $r->published_at?->toDateString() }}">{{ $r->published_at?->format('d M Y') }}</time></div>
                </div>
                @endforeach
            </div>
            @endif
            <div class="blog-sidebar-cta">
                <h4 class="blog-sidebar-cta-title">Ready to Import?</h4>
                <p class="blog-sidebar-cta-text">Get premium Ceylon products exported worldwide.</p>
                <a href="{{ route('contact') }}" class="btn btn-gold">Contact Us</a>
            </div>
        </aside>
    </div>
</section>

<script>
document.querySelectorAll('.art-faq-q').forEach(function(q){
    q.addEventListener('click',function(){
        var item=q.closest('.art-faq-item');
        var open=item.classList.contains('open');
        document.querySelectorAll('.art-faq-item.open').forEach(function(i){i.classList.remove('open');});
        if(!open)item.classList.add('open');
    });
});
</script>
@endsection
