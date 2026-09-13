<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BlogPostSeeder2 extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title'        => 'Ceylon Cinnamon vs Cassia: The Complete Buyer\'s Guide',
                'slug'         => 'ceylon-cinnamon-vs-cassia-buyers-guide',
                'category'     => 'Import Guide',
                'excerpt'      => 'Ceylon cinnamon (Cinnamomum verum) and cassia (Cinnamomum cassia) are often sold under the same name, but they differ in coumarin content, flavour, price, and regulatory status in the EU. This guide explains what importers and buyers must know before sourcing.',
                'image'        => '/images/blog-cinnamon.jpg',
                'published_at' => Carbon::parse('2026-08-25'),
                'content'      => '<h2>Ceylon Cinnamon vs Cassia: What Importers Must Know</h2>
<p>Cinnamon is one of the most traded spices globally, yet most of what is sold as "cinnamon" in supermarkets around the world is actually cassia — a closely related but distinct species. For importers, food manufacturers, and retailers, understanding the difference is not just a quality matter — it has legal and regulatory implications.</p>
<h3>The Key Differences</h3>
<table><thead><tr><th>Feature</th><th>Ceylon Cinnamon (True)</th><th>Cassia</th></tr></thead><tbody><tr><td>Species</td><td>Cinnamomum verum</td><td>Cinnamomum cassia / aromaticum</td></tr><tr><td>Origin</td><td>Sri Lanka</td><td>China, Vietnam, Indonesia</td></tr><tr><td>Coumarin Content</td><td>Very low (&lt;0.004%)</td><td>High (0.3–0.9%)</td></tr><tr><td>Texture</td><td>Thin, multi-layered quills</td><td>Thick, hard bark</td></tr><tr><td>Flavour</td><td>Delicate, mildly sweet</td><td>Strong, pungent</td></tr><tr><td>Colour</td><td>Light tan / golden brown</td><td>Dark reddish brown</td></tr><tr><td>Price</td><td>Premium</td><td>Commodity</td></tr></tbody></table>
<h3>Coumarin and EU Regulations</h3>
<p>The European Food Safety Authority (EFSA) has set a Tolerable Daily Intake (TDI) of 0.1 mg/kg body weight for coumarin. Because cassia contains up to 250 times more coumarin than Ceylon cinnamon, the EU limits coumarin levels in food products. Ceylon cinnamon is exempt from these restrictions. For EU-bound food manufacturers, switching to Ceylon cinnamon eliminates compliance risk.</p>
<h3>How to Identify Genuine Ceylon Cinnamon</h3>
<ul><li><strong>Visual check:</strong> Ceylon quills have thin layers rolled like a cigar; cassia is a single thick tube.</li><li><strong>Lab test:</strong> Request a Certificate of Analysis showing coumarin content below 0.004%.</li><li><strong>Origin certificate:</strong> Sri Lanka Export Development Board (EDB) phytosanitary certificates confirm origin.</li><li><strong>Grade:</strong> Ceylon cinnamon grades — Alba, C5 Special, C4, M4, M5, H1, H2 — have no cassia equivalents.</li></ul>
<h3>Sourcing Ceylon Cinnamon for Export</h3>
<p>Ceylon Aroma exports certified Ceylon cinnamon in all standard grades from Alba (finest) to H1/H2 (bulk export). MOQs start at 50 kg per grade. All shipments include a Certificate of Origin, phytosanitary certificate, and Certificate of Analysis.</p>',
                'status'       => true,
            ],
            [
                'title'        => 'How to Find a Reliable Spice Supplier in Sri Lanka',
                'slug'         => 'how-to-find-reliable-spice-supplier-sri-lanka',
                'category'     => 'Import Guide',
                'excerpt'      => 'Sourcing spices directly from Sri Lanka offers significant cost advantages, but choosing the wrong supplier can result in quality failures, missed shipments, and regulatory issues. Here is a step-by-step process for vetting and onboarding a Sri Lanka spice exporter.',
                'image'        => '/images/blog-spice.jpg',
                'published_at' => Carbon::parse('2026-08-24'),
                'content'      => '<h2>How to Find a Reliable Spice Supplier in Sri Lanka</h2>
<p>Sri Lanka is one of the world\'s leading exporters of cinnamon, cloves, pepper, cardamom, and nutmeg. Sourcing directly from the origin country offers 20–40% cost savings over buying through intermediary distributors. But due diligence is critical — quality, compliance, and reliability vary widely.</p>
<h3>Step 1: Verify Export Licensing</h3>
<p>Any legitimate Sri Lankan spice exporter must be registered with the Sri Lanka Export Development Board (EDB) and hold an export license from the Sri Lanka Spices, Plantations & Allied Products Exporters Association (SPASAL). Ask for both licence numbers before proceeding.</p>
<h3>Step 2: Check Certifications</h3>
<p>For food-grade exports, look for:</p>
<ul><li><strong>ISO 22000</strong> — Food Safety Management System</li><li><strong>HACCP</strong> — Hazard Analysis and Critical Control Points</li><li><strong>Organic certification</strong> — USDA NOP or EU 2018/848 if required</li><li><strong>Halal / Kosher</strong> — if selling to relevant markets</li></ul>
<h3>Step 3: Request Samples and a Certificate of Analysis</h3>
<p>Never place a first order without receiving a physical sample. Test for moisture content, volatile oil content, ash content, and contaminants including heavy metals, pesticide residues, and aflatoxin. A reputable exporter will provide a third-party lab Certificate of Analysis on request.</p>
<h3>Step 4: Verify Production Capacity</h3>
<p>Ask for annual export volumes and references from existing buyers. A supplier who cannot provide 2–3 verifiable overseas buyer references is a risk.</p>
<h3>Step 5: Agree on Terms and Sample Order</h3>
<p>Place a trial order of 100–500 kg before committing to a full container. Agree on payment terms (30% advance, 70% against BL copy is standard for first orders), incoterms, and packaging specifications upfront.</p>
<h3>Red Flags to Avoid</h3>
<ul><li>No physical address or verifiable factory</li><li>Unwilling to provide a Certificate of Analysis</li><li>Prices significantly below market rates (often signals adulteration)</li><li>Requests for 100% advance payment from an unknown buyer</li></ul>',
                'status'       => true,
            ],
            [
                'title'        => 'US FDA Requirements for Importing Spices from Sri Lanka',
                'slug'         => 'us-fda-requirements-importing-spices-sri-lanka',
                'category'     => 'Import Guide',
                'excerpt'      => 'Importing spices into the United States involves FDA Prior Notice, FSVP compliance, labelling rules, and potential detention if documentation is incomplete. This guide covers exactly what US importers need from their Sri Lankan supplier.',
                'image'        => '/images/blog-spice.jpg',
                'published_at' => Carbon::parse('2026-08-23'),
                'content'      => '<h2>US FDA Requirements for Importing Spices from Sri Lanka</h2>
<p>The United States is one of the largest importers of Ceylon spices. However, FDA compliance requirements mean that importers and their suppliers must have documentation in order before any shipment leaves Sri Lanka.</p>
<h3>FDA Prior Notice</h3>
<p>All food shipments entering the US must be registered with the FDA via Prior Notice at least 2 hours before arrival by air or 8 hours before arrival by sea. Your Sri Lankan supplier should be registered with the FDA as a foreign food facility (registration is free via the FDA Unified Registration and Listing System — FURLS).</p>
<h3>Foreign Supplier Verification Program (FSVP)</h3>
<p>Under FSMA (Food Safety Modernization Act), US importers are responsible for verifying that their foreign suppliers meet US food safety standards. As the importer of record, you must maintain an FSVP file that includes:</p>
<ul><li>Hazard analysis for the imported food</li><li>Supplier verification activities (audit reports, CoA review, etc.)</li><li>Corrective actions taken for any non-conformance</li></ul>
<h3>Required Documentation Per Shipment</h3>
<ul><li>Commercial invoice with HS code</li><li>Packing list</li><li>Bill of Lading / Air Waybill</li><li>Certificate of Origin (from Sri Lanka EDB)</li><li>Phytosanitary Certificate (from Sri Lanka Dept. of Agriculture)</li><li>Certificate of Analysis from an accredited lab</li><li>FDA Prior Notice confirmation number</li></ul>
<h3>Common Reasons for FDA Detention</h3>
<p>Spice shipments from Sri Lanka are occasionally detained for Salmonella contamination, excess pesticide residues, or filth. Work with suppliers who steam-sterilise or use ETO (ethylene oxide) treatment — confirm which method complies with your target market regulations, as ETO is restricted in the EU.</p>
<h3>Labelling Requirements</h3>
<p>If repacking for retail in the US, spice labels must include: product name, net weight in both metric and US customary, country of origin, and allergen declarations per FALCPA. "Ceylon Cinnamon" or "True Cinnamon" is a legally defensible label for Cinnamomum verum.</p>',
                'status'       => true,
            ],
            [
                'title'        => 'Virgin Coconut Oil from Sri Lanka: Grades, Specs & Export Guide',
                'slug'         => 'virgin-coconut-oil-sri-lanka-export-guide',
                'category'     => 'Export Guide',
                'excerpt'      => 'Sri Lanka produces some of the world\'s finest virgin coconut oil (VCO). This guide covers the difference between VCO and RBD coconut oil, key quality parameters, packaging options, and how to source VCO from Sri Lanka for export markets.',
                'image'        => '/images/blog-spice.jpg',
                'published_at' => Carbon::parse('2026-08-22'),
                'content'      => '<h2>Virgin Coconut Oil from Sri Lanka: Grades, Specs & Export Guide</h2>
<p>Sri Lanka has a long history of coconut cultivation, with the Coconut Triangle (Kurunegala, Puttalam, Gampaha districts) producing some of the cleanest VCO available in global markets. The global VCO market is growing at over 9% annually, driven by food, cosmetics, and nutraceutical demand.</p>
<h3>VCO vs RBD Coconut Oil</h3>
<table><thead><tr><th>Parameter</th><th>Virgin Coconut Oil (VCO)</th><th>RBD (Refined, Bleached, Deodorised)</th></tr></thead><tbody><tr><td>Processing</td><td>Cold-pressed, no heat/chemicals</td><td>Refined with solvents and heat</td></tr><tr><td>Aroma</td><td>Fresh coconut scent</td><td>Odourless</td></tr><tr><td>Lauric acid</td><td>~50%</td><td>~50%</td></tr><tr><td>Colour</td><td>Water-white</td><td>Water-white</td></tr><tr><td>Price premium</td><td>2–3× RBD</td><td>Base price</td></tr><tr><td>Best for</td><td>Food, nutraceuticals, premium cosmetics</td><td>Industrial, food processing</td></tr></tbody></table>
<h3>Key Quality Parameters</h3>
<ul><li><strong>FFA (Free Fatty Acids):</strong> Max 0.1% for premium VCO</li><li><strong>Moisture:</strong> Max 0.1%</li><li><strong>Peroxide Value:</strong> Max 3 meq/kg</li><li><strong>Lauric Acid:</strong> Min 48%</li><li><strong>Colour:</strong> Water white (Lovibond 1.5R max)</li></ul>
<h3>Packaging Options</h3>
<p>VCO is available in: 200L HDPE drums (bulk export), 20L jerry cans, 5L PET bottles, 1L glass bottles (retail/private label). For cosmetic-grade VCO, food-grade stainless steel drums or aluminium containers are preferred to prevent oxidation.</p>
<h3>Certifications That Add Market Value</h3>
<ul><li>USDA Organic / EU Organic</li><li>ISO 22000 / HACCP</li><li>Vegan Society certified</li><li>Non-GMO Project Verified</li></ul>
<p>Ceylon Aroma supplies cold-pressed virgin coconut oil in bulk and private label formats. Request a sample and Certificate of Analysis to get started.</p>',
                'status'       => true,
            ],
            [
                'title'        => 'Ceylon Cardamom: Wholesale Grades, Sourcing & Export',
                'slug'         => 'ceylon-cardamom-wholesale-grades-export',
                'category'     => 'Export Guide',
                'excerpt'      => 'Sri Lanka produces high-quality green cardamom alongside Guatemala and India. This guide covers cardamom grades, volatile oil content benchmarks, and how to source cardamom wholesale from Sri Lanka.',
                'image'        => '/images/blog-spice.jpg',
                'published_at' => Carbon::parse('2026-08-21'),
                'content'      => '<h2>Ceylon Cardamom: Wholesale Grades, Sourcing & Export</h2>
<p>Cardamom is often called the "Queen of Spices" and commands significant premiums in global markets. While Guatemala dominates volume, Sri Lanka produces cardamom with excellent volatile oil content and aroma complexity prized by premium food manufacturers.</p>
<h3>Cardamom Grades (Sri Lanka)</h3>
<ul><li><strong>Extra Bold (AEB):</strong> Pods &gt;8mm, deep green, highest volatile oil content (6–8%)</li><li><strong>Bold (AB):</strong> Pods 7–8mm, uniform green colour</li><li><strong>Small (AG):</strong> Pods 5–7mm, slightly lighter colour</li><li><strong>Seeds only:</strong> Decorticated cardamom seeds for food manufacturing</li><li><strong>Powder:</strong> Ground cardamom for blending applications</li></ul>
<h3>Quality Parameters</h3>
<ul><li>Volatile oil content: min 5% (min 7% for premium)</li><li>Moisture: max 12%</li><li>Extraneous matter: max 0.5%</li><li>Shrivelled pods: max 5%</li></ul>
<h3>Applications by Grade</h3>
<p><strong>Extra Bold</strong> is preferred for retail packaging and whole-pod applications in Middle Eastern and European markets. <strong>Bold and Small grades</strong> suit food manufacturing — spice blends, chai masala, bakery, and confectionery. <strong>Seeds and powder</strong> are used for extract production and flavouring.</p>
<h3>Minimum Order Quantities</h3>
<p>Wholesale export orders typically start at 100 kg per grade. Full container loads (FCL 20\') hold approximately 5–6 MT of cardamom. Bulk packaging is in 10 kg or 25 kg inner poly bags inside jute sacks or double-walled cartons.</p>
<h3>Seasonality</h3>
<p>Sri Lanka cardamom has two harvesting seasons: August–October (main crop) and February–April (mid crop). Price and availability fluctuate accordingly. Forward contracts are available from established exporters for buyers who need price certainty.</p>',
                'status'       => true,
            ],
            [
                'title'        => 'Ceylon Moringa Powder: Wholesale Sourcing & Quality Guide',
                'slug'         => 'ceylon-moringa-powder-wholesale-sourcing-guide',
                'category'     => 'Health & Wellness',
                'excerpt'      => 'Moringa oleifera grown in Sri Lanka\'s dry zone produces leaf powder with exceptional nutrient density. This guide covers quality benchmarks, certifications required for nutraceutical markets, and how to source Ceylon moringa powder wholesale.',
                'image'        => '/images/blog-spice.jpg',
                'published_at' => Carbon::parse('2026-08-20'),
                'content'      => '<h2>Ceylon Moringa Powder: Wholesale Sourcing & Quality Guide</h2>
<p>The global moringa market is projected to exceed USD 10 billion by 2030, driven by demand from the nutraceutical, food supplement, and functional food industries. Sri Lanka\'s dry zone conditions produce moringa leaf powder with high chlorophyll retention and superior nutritional profiles compared to many competing origins.</p>
<h3>Why Ceylon Moringa?</h3>
<ul><li>Grown in mineral-rich soil with minimal pesticide use</li><li>Low-temperature drying preserves heat-sensitive nutrients</li><li>High isothiocyanate and antioxidant content</li><li>Clean heavy metal profile (critical for supplement-grade products)</li></ul>
<h3>Key Quality Parameters</h3>
<table><thead><tr><th>Parameter</th><th>Standard Grade</th><th>Premium / Supplement Grade</th></tr></thead><tbody><tr><td>Moisture</td><td>Max 8%</td><td>Max 5%</td></tr><tr><td>Protein</td><td>Min 25%</td><td>Min 27%</td></tr><tr><td>Ash</td><td>Max 10%</td><td>Max 8%</td></tr><tr><td>Lead (Pb)</td><td>Max 2 ppm</td><td>Max 0.5 ppm</td></tr><tr><td>Cadmium</td><td>Max 0.3 ppm</td><td>Max 0.1 ppm</td></tr><tr><td>Microbial (TPC)</td><td>Max 100,000 cfu/g</td><td>Max 10,000 cfu/g</td></tr></tbody></table>
<h3>Required Certifications for Supplement Markets</h3>
<ul><li><strong>US market:</strong> FDA facility registration, FSMA FSVP compliance, optionally USDA Organic</li><li><strong>EU market:</strong> Novel Food status not required for moringa leaf; EU Organic certification adds value</li><li><strong>UK market:</strong> UK Organic or BRC Global Standard</li><li><strong>General:</strong> ISO 22000, HACCP, COA from accredited lab per shipment</li></ul>
<h3>Packaging for Supplement Grade</h3>
<p>Supplement-grade moringa powder must be packed in: 25 kg multi-wall paper bags with inner poly liner (food contact grade), or 20 kg aluminium foil bags. Include desiccant sachets. Label must show lot number, production date, best-before date, and country of origin.</p>
<h3>MOQ and Pricing</h3>
<p>Wholesale MOQ starts at 100 kg. Supplement-grade pricing carries a 15–25% premium over food-grade. Request a sample with a full Certificate of Analysis (nutritional panel + heavy metals + microbial) before placing an order.</p>',
                'status'       => true,
            ],
            [
                'title'        => 'Private Label Tea from Sri Lanka: MOQ, Packaging & Process',
                'slug'         => 'private-label-tea-sri-lanka-moq-packaging-process',
                'category'     => 'Private Label',
                'excerpt'      => 'Ceylon tea is one of the world\'s most recognisable origins. Launching a private label tea brand sourced from Sri Lanka is more accessible than most buyers expect. This guide covers MOQs, packaging formats, label requirements, and lead times.',
                'image'        => '/images/blog-tea.jpg',
                'published_at' => Carbon::parse('2026-08-19'),
                'content'      => '<h2>Private Label Tea from Sri Lanka: MOQ, Packaging & Process</h2>
<p>Ceylon tea carries built-in brand equity — the Lion Logo, origin authenticity, and global recognition mean that a private label Ceylon tea brand has a credible story before a single box is sold. Whether you are a retailer, wellness brand, or food service buyer, here is exactly how the process works.</p>
<h3>Step 1: Choose Your Tea Type</h3>
<p>Ceylon tea comes in several categories:</p>
<ul><li><strong>Black tea:</strong> OP, BOP, BOPF, Pekoe grades — full-bodied, suits English Breakfast, breakfast blends</li><li><strong>Green tea:</strong> Gunpowder, Sencha-style — lighter, suits health and wellness positioning</li><li><strong>White tea:</strong> Silver Tips, White Pekoe — ultra-premium, low production volumes</li><li><strong>Flavoured tea:</strong> Base Ceylon black/green blended with natural flavours — bergamot, jasmine, ginger, etc.</li><li><strong>Herbal blends:</strong> Moringa, gotukola, cinnamon — Sri Lanka-specific botanicals</li></ul>
<h3>Step 2: Select Packaging Format</h3>
<table><thead><tr><th>Format</th><th>MOQ</th><th>Best For</th></tr></thead><tbody><tr><td>Loose leaf, bulk bag</td><td>10 kg</td><td>Food service, wholesalers</td></tr><tr><td>Pyramid tea bags (25/50 ct)</td><td>500 boxes</td><td>Premium retail</td></tr><tr><td>Standard tea bags (25/50/100 ct)</td><td>1,000 boxes</td><td>Mass retail, e-commerce</td></tr><tr><td>Tin caddy, loose leaf</td><td>500 units</td><td>Gift, specialty retail</td></tr><tr><td>Sachet retail carton</td><td>2,000 units</td><td>Supermarket retail</td></tr></tbody></table>
<h3>Step 3: Label Requirements</h3>
<p>Your private label must include: brand name, tea type and grade, net weight, country of origin ("Product of Sri Lanka"), best before date, brewing instructions, and importer details (required in EU/US). If using the Sri Lanka Tea Board Lion Logo, a licence from the Tea Board is required — Ceylon Aroma can facilitate this.</p>
<h3>Step 4: Lead Times</h3>
<ul><li>Sample approval: 7–14 days</li><li>Label design and print: 2–3 weeks (buyer provides artwork or we design)</li><li>Production and packing: 2–3 weeks</li><li>Shipping (sea freight to EU/US): 25–35 days</li></ul>
<p>Total first-order lead time: approximately 8–10 weeks from artwork approval.</p>',
                'status'       => true,
            ],
            [
                'title'        => 'Ceylon Nutmeg & Mace: Export Grades, Uses & Wholesale Sourcing',
                'slug'         => 'ceylon-nutmeg-mace-export-grades-wholesale-sourcing',
                'category'     => 'Export Guide',
                'excerpt'      => 'Sri Lanka produces Myristica fragrans nutmeg with high volatile oil content. This guide covers the difference between nutmeg and mace, export grades, key quality specs, and how to source nutmeg wholesale from Sri Lanka.',
                'image'        => '/images/blog-spice.jpg',
                'published_at' => Carbon::parse('2026-08-18'),
                'content'      => '<h2>Ceylon Nutmeg & Mace: Export Grades, Uses & Wholesale Sourcing</h2>
<p>Nutmeg and mace are two distinct spices from the same fruit of the Myristica fragrans tree. Sri Lanka produces both, with the Kandy and Matale districts as the primary growing regions. Ceylon nutmeg is valued for its high volatile oil content and clean flavour profile.</p>
<h3>Nutmeg vs Mace: The Difference</h3>
<p>The nutmeg is the seed kernel of the fruit. Mace is the bright red lacy aril (covering) that wraps around the nutmeg shell. When fresh, mace is brilliant scarlet; it dries to amber-orange. Mace has a more delicate, slightly sweeter flavour than nutmeg, and commands a higher price per kg due to lower yield.</p>
<h3>Export Grades — Nutmeg</h3>
<ul><li><strong>ABCD (whole):</strong> Sound, whole nutmegs, no visible damage, 110–120 nuts/kg</li><li><strong>BWP (Broken, Wormy, Punky):</strong> Lower grade, suitable for oil extraction</li><li><strong>Shrivelled:</strong> Dried-out nuts, lowest grade</li><li><strong>Nutmeg powder:</strong> Ground from ABCD grade, 15–20% volatile oil</li><li><strong>Nutmeg butter / oil:</strong> Extracted for pharmaceutical and fragrance use</li></ul>
<h3>Export Grades — Mace</h3>
<ul><li><strong>No.1 Blade:</strong> Whole mace blades, uniform amber, high oil content</li><li><strong>No.2 Blade:</strong> Broken pieces, slightly darker</li><li><strong>Mace powder:</strong> Fine grind from No.1 blades</li></ul>
<h3>Key Quality Specifications</h3>
<ul><li>Volatile oil: Min 7% for whole nutmeg (ASTA standard)</li><li>Moisture: Max 10%</li><li>Extraneous matter: Max 0.5%</li><li>Aflatoxin: Max 10 ppb (EU: 5 ppb B1, 10 ppb total)</li></ul>
<h3>Applications</h3>
<p>Nutmeg and mace are used in bakery, dairy, meat processing (sausage seasoning), beverages, and pharmaceutical preparations. Nutmeg butter is widely used in cosmetics and topical formulations.</p>
<p>Ceylon Aroma exports whole nutmeg (ABCD), mace blades, and powders. MOQ 50 kg. All shipments include phytosanitary certificate and Certificate of Analysis for aflatoxin and volatile oil content.</p>',
                'status'       => true,
            ],
            [
                'title'        => 'Ceylon Black Tea OP Grade: A Complete Guide for Buyers',
                'slug'         => 'ceylon-black-tea-op-grade-buyers-guide',
                'category'     => 'Tea Culture',
                'excerpt'      => 'Orange Pekoe (OP) is one of the most traded Ceylon tea grades globally. This guide explains what OP grade means, how it differs from BOP and BOPF, and what buyers should look for when sourcing Ceylon black tea in bulk.',
                'image'        => '/images/blog-tea.jpg',
                'published_at' => Carbon::parse('2026-08-17'),
                'content'      => '<h2>Ceylon Black Tea OP Grade: A Complete Guide for Buyers</h2>
<p>Ceylon black tea is traded in a range of orthodox grades, each defined by leaf size, appearance, and cup character. Orange Pekoe (OP) sits at the premium end of the orthodox grading system and is one of the most recognised grades by international tea buyers.</p>
<h3>Understanding Ceylon Tea Grades</h3>
<p>Ceylon orthodox tea grades are defined by the Sri Lanka Tea Board and internationally recognised. The main grades from largest to smallest leaf:</p>
<table><thead><tr><th>Grade</th><th>Leaf Size</th><th>Cup Character</th><th>Best For</th></tr></thead><tbody><tr><td>OP (Orange Pekoe)</td><td>Long wiry leaf, 8–15mm</td><td>Bright, golden liquor, medium body</td><td>Loose leaf retail, specialty</td></tr><tr><td>BOP (Broken Orange Pekoe)</td><td>Medium broken, 2–4mm</td><td>Strong, full-bodied, faster brew</td><td>Tea bags, foodservice</td></tr><tr><td>BOPF (BOP Fannings)</td><td>Fine fannings, 1–2mm</td><td>Very strong, quick infusion</td><td>Standard tea bags, mass retail</td></tr><tr><td>Dust No.1</td><td>Very fine</td><td>Instant strength</td><td>Industrial tea bags</td></tr></tbody></table>
<h3>What Makes Ceylon OP Premium?</h3>
<p>OP grade requires skilled hand plucking of a longer leaf with the bud. The extended withering and rolling process develops complexity. Buyers value Ceylon OP for its visual appeal in loose leaf retail — the long, wiry, golden-tipped leaves present beautifully in transparent packaging.</p>
<h3>High-Grown vs Low-Grown Ceylon OP</h3>
<p>The elevation where tea is grown significantly affects flavour:</p>
<ul><li><strong>High-grown (Nuwara Eliya, Dimbula, Uva, &gt;4,000 ft):</strong> Delicate, floral, with distinctive brightness. Commands the highest premiums. Uva season (July–September) and Dimbula season (January–March) are the best quality windows.</li><li><strong>Mid-grown (Kandy, 2,000–4,000 ft):</strong> Full-bodied, well-rounded. Good value for blending.</li><li><strong>Low-grown (Galle, Ratnapura, &lt;2,000 ft):</strong> Dark, bold liquor. High yield, lower price. Suited for CTC-style blending applications.</li></ul>
<h3>Buying OP Grade in Bulk</h3>
<p>Ceylon OP is sold at the Colombo Tea Auction (held weekly, one of the largest in the world) or directly from estate exporters. Direct purchase from an exporter bypasses auction premiums and allows for specification sourcing — elevation, estate, season, and flush preferences.</p>
<p>Ceylon Aroma exports OP, BOP, and BOPF grades in bulk (25 kg multi-wall bags) and private label formats. Contact us for current season availability and pricing.</p>',
                'status'       => true,
            ],
            [
                'title'        => 'Spice Import Minimum Order Quantities: What Wholesale Buyers Need to Know',
                'slug'         => 'spice-import-minimum-order-quantities-wholesale-guide',
                'category'     => 'Import Guide',
                'excerpt'      => 'Minimum order quantities (MOQs) are one of the first questions spice importers ask. This guide explains typical MOQs for Ceylon spices, how to negotiate them, and how to structure first orders to manage risk.',
                'image'        => '/images/blog-spice.jpg',
                'published_at' => Carbon::parse('2026-08-16'),
                'content'      => '<h2>Spice Import Minimum Order Quantities: What Wholesale Buyers Need to Know</h2>
<p>MOQs are one of the most common barriers for first-time spice importers. Understanding how MOQs are set — and how to work with them — makes it easier to start a supplier relationship without overcommitting capital on a first order.</p>
<h3>Why MOQs Exist</h3>
<p>Exporters set MOQs to make export logistics economically viable. A 25 kg order doesn\'t justify the cost of: export documentation, phytosanitary inspection, freight booking, bank charges, and packing. Most Sri Lankan spice exporters set MOQs to cover these fixed costs while keeping unit pricing competitive.</p>
<h3>Typical Ceylon Spice MOQs</h3>
<table><thead><tr><th>Spice</th><th>Sample</th><th>Minimum Export Order</th><th>FCL (20\') Volume</th></tr></thead><tbody><tr><td>Ceylon Cinnamon (quills)</td><td>500g–1kg</td><td>50–100 kg</td><td>8–10 MT</td></tr><tr><td>Black Pepper</td><td>500g</td><td>100 kg</td><td>15–18 MT</td></tr><tr><td>Cloves</td><td>500g</td><td>50 kg</td><td>10–12 MT</td></tr><tr><td>Cardamom</td><td>250g</td><td>50 kg</td><td>5–6 MT</td></tr><tr><td>Nutmeg (whole)</td><td>500g</td><td>50 kg</td><td>10 MT</td></tr><tr><td>Mace</td><td>250g</td><td>25 kg</td><td>3–4 MT</td></tr><tr><td>Moringa Powder</td><td>500g</td><td>100 kg</td><td>8 MT</td></tr><tr><td>Virgin Coconut Oil</td><td>1L</td><td>100L (drums)</td><td>16 MT</td></tr></tbody></table>
<h3>How to Reduce First-Order Risk</h3>
<ul><li><strong>Combine SKUs:</strong> Many exporters allow mixed containers — meet the overall order minimum by combining multiple spices rather than placing one large single-SKU order.</li><li><strong>LCL freight:</strong> Less-than-Container-Load (LCL) shipments are viable for 200–1,000 kg orders. Unit freight cost is higher but total cash outlay is lower.</li><li><strong>Sample approval first:</strong> Never skip samples. A sample order costs USD 50–200; it can save thousands on a rejected shipment.</li><li><strong>Trial order clause:</strong> Negotiate a lower MOQ (e.g. 50% of standard) for the first order in exchange for committing to a follow-on order within 90 days if quality is approved.</li></ul>
<h3>Payment Terms for First Orders</h3>
<p>Standard for first-time buyers: 30–50% advance by T/T, balance against copy of Bill of Lading. After 2–3 successful orders, most exporters will offer 30-day open account or Letter of Credit terms. Avoid any exporter demanding 100% advance payment before shipment from an unknown buyer.</p>',
                'status'       => true,
            ],
        ];

        foreach ($posts as $post) {
            DB::table('blog_posts')->updateOrInsert(
                ['slug' => $post['slug']],
                array_merge($post, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        $this->command->info('Blog posts seeded: ' . count($posts) . ' posts added/updated.');
    }
}
