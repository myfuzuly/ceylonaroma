@extends('layouts.app')

@section('title', $blog_post->title)
@section('meta_description', $blog_post->excerpt ?: 'Read ' . $blog_post->title . ' — export insights and product guides from Ceylon Aroma, Sri Lanka.')
@section('og_type', 'article')

@php
$postImg = $blog_post->image
    ? asset('storage/'.$blog_post->image)
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
];
$currentFaqs = $postFaqs[$blog_post->slug] ?? [];
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ addslashes($blog_post->title) }}",
  "description": "{{ addslashes($blog_post->excerpt ?: $blog_post->title) }}",
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
  "articleSection": "{{ addslashes($blog_post->category) }}"@endif
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type": "ListItem", "position": 1, "name": "Home",            "item": "https://ceylonaroma.com" },
    { "@type": "ListItem", "position": 2, "name": "Knowledge Centre","item": "https://ceylonaroma.com/blog" },
    { "@type": "ListItem", "position": 3, "name": "{{ addslashes($blog_post->title) }}", "item": "https://ceylonaroma.com/blog/{{ $blog_post->slug }}" }
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
      "name": "{{ addslashes($faq['q']) }}",
      "acceptedAnswer": { "@type": "Answer", "text": "{{ addslashes($faq['a']) }}" }
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
                <img src="{{ asset('storage/'.$blog_post->image) }}" alt="{{ $blog_post->title }}">
            </div>
            @else
            <div class="blog-post-img-placeholder"></div>
            @endif

            <div class="blog-content">
                @if($blog_post->excerpt)
                <p class="blog-post-excerpt">{{ $blog_post->excerpt }}</p>
                @endif
                {!! $blog_post->content !!}
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

@endsection
