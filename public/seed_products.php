<?php
// Ceylon Aroma product seeder — sourced from ceylonaroma.com — DELETE AFTER RUN
define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__);
require $base.'/ceylon_aroma/vendor/autoload.php';
$app = require_once $base.'/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

set_time_limit(120);

// Category ID map: ceylonaroma.com category name -> local category_id
$catMap = [
    'Spices'              => 1, // ceylon-spices
    'Ceylon Tea'          => 3, // ceylon-tea
    'Flavoured Tea'       => 3, // ceylon-tea
    'Dehydrated Products' => 6, // dehydrated-products
    'Leaves'              => 6, // dehydrated-products
    'Fruits'              => 6, // dehydrated-products
    'Fruit Pulp'          => 5, // frozen-pulp
];

$products = [
    [
        'name'  => 'Ceylon Gotukola Powder',
        'slug'  => 'ceylon-gotukola-powder',
        'short' => '100% Dried Centella Asiatica Leaves — Sourced from the lush herbal gardens of Sri Lanka.',
        'desc'  => 'Sourced from the lush herbal gardens of Sri Lanka, Gotukola (Centella Asiatica) is revered in Ayurvedic and traditional medicine for its cognitive, circulatory, and skin health benefits. Our pure, export-grade powder is carefully dried and milled to retain maximum potency.',
        'cats'  => ['Dehydrated Products', 'Leaves'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/gotukola-powder.jpg',
    ],
    [
        'name'  => 'Ceylon Moringa Powder',
        'slug'  => 'ceylon-moringa-powder',
        'short' => 'Premium export-grade superfood made from 100% dried moringa leaves (Moringa Oleifera).',
        'desc'  => 'True Ceylon Moringa Powder is a premium, export-grade superfood made from 100% dried moringa leaves (Moringa Oleifera), cultivated and processed in Sri Lanka. Rich in antioxidants, vitamins, and minerals, it is ideal for health food, nutraceutical, and wellness brands worldwide.',
        'cats'  => ['Dehydrated Products', 'Leaves'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/moringa-powder.png',
    ],
    [
        'name'  => 'Ceylon True Mace',
        'slug'  => 'ceylon-true-mace',
        'short' => 'The delicate crimson aril of the nutmeg seed — one of Sri Lanka\'s most prized spices.',
        'desc'  => 'Mace, the delicate crimson aril of the nutmeg seed, is one of Sri Lanka\'s most prized spices. Known for its warm, aromatic flavor and vibrant reddish-orange hue, True Ceylon Mace adds depth to savory and sweet dishes alike. Sourced from certified farms in Sri Lanka.',
        'cats'  => ['Spices'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/mace.jpg',
    ],
    [
        'name'  => 'Ceylon True Cinnamon',
        'slug'  => 'ceylon-true-cinnamon',
        'short' => 'World\'s finest cinnamon — Alba Grade, harvested from the lush plantations of Sri Lanka.',
        'desc'  => 'Discover the world\'s finest cinnamon, known as Ceylon Cinnamon or "True Cinnamon." Harvested from the lush plantations of Sri Lanka, this premium Alba Grade variety is prized for its delicate sweetness, thin paper-like quills, and low coumarin content — the gold standard for global importers.',
        'cats'  => ['Spices'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/true-ceylon-cinnamon-alba.jpg',
    ],
    [
        'name'  => 'Ceylon True Clove',
        'slug'  => 'ceylon-true-clove',
        'short' => 'Bold aroma and rich flavor — harvested from the fertile highlands of Sri Lanka.',
        'desc'  => 'Experience the bold aroma and rich flavor of True Ceylon Clove, harvested from the fertile highlands of Sri Lanka. Each clove is carefully selected for its deep brown hue, intact bud, and potent essential oil content. Available in whole, bud, and powder formats for export.',
        'cats'  => ['Spices'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/clove.jpg',
    ],
    [
        'name'  => 'Dried Pineapple Tidbits',
        'slug'  => 'dried-pineapple-tidbits',
        'short' => 'Sun-kissed dried pineapple tidbits — naturally preserved, rich in flavor, free from additives.',
        'desc'  => 'Savor the tropical sweetness of Sri Lanka with our sun-kissed dried pineapple tidbits — naturally preserved, rich in flavor, and free from additives. Each piece is carefully selected and dehydrated to retain maximum nutrition and natural sweetness. Ideal for snack mixes, confectionery, and cereal exports.',
        'cats'  => ['Dehydrated Products', 'Fruits'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/dried-pineapple-tidbits.jpg',
    ],
    [
        'name'  => 'Dried Tomatoes',
        'slug'  => 'dried-tomatoes',
        'short' => 'Sri Lankan sun-dried tomatoes — concentrated flavor, perfect for culinary export.',
        'desc'  => 'Premium quality sun-dried tomatoes sourced from Sri Lanka, processed under strict hygienic conditions. Rich concentrated flavor ideal for culinary applications, gourmet food products, and restaurant supply. Available in slices, halves, and chopped formats.',
        'cats'  => ['Dehydrated Products', 'Fruits'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/dried-tomatoes.jpg',
    ],
    [
        'name'  => 'Dried Red Papaya',
        'slug'  => 'dried-red-papaya',
        'short' => 'Vibrant dried red papaya from Sri Lanka — naturally sweet, tropical, export-ready.',
        'desc'  => 'Vibrant dried red papaya sourced from Sri Lanka\'s tropical farms. Naturally sweet with no artificial colors or preservatives. Ideal for trail mixes, confectionery, health snacks, and retail export packaging. Available in strips, chunks, and diced formats.',
        'cats'  => ['Dehydrated Products', 'Fruits'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/dried-red-papaya.jpg',
    ],
    [
        'name'  => 'Dried Mango Strips',
        'slug'  => 'dried-mango-strips',
        'short' => 'Premium dried mango strips from ripe Sri Lankan mangoes — no additives, export-grade.',
        'desc'  => 'Premium dried mango strips made from ripe Sri Lankan mangoes, carefully dehydrated to preserve natural sweetness and tropical aroma. Free from artificial preservatives and additives. Perfect for snack exports, trail mixes, and health food retail.',
        'cats'  => ['Dehydrated Products', 'Fruits'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/dried-mango-strips.jpg',
    ],
    [
        'name'  => 'Red Papaya Chunks',
        'slug'  => 'red-papaya-chunks',
        'short' => 'Premium tropical preserve — ripe Sri Lankan papayas in export-grade glass jars.',
        'desc'  => 'Ceylon Aroma Red Papaya Chunks are a premium tropical preserve made from ripe Sri Lankan papayas, packed in syrup and sealed in export-grade glass jars. 100% natural, rich in nutrients, and ideal for foodservice, retail, and private-label export.',
        'cats'  => ['Fruit Pulp'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/red-papaya-chunks.jpg',
    ],
    [
        'name'  => 'Pineapple Chunks',
        'slug'  => 'pineapple-chunks',
        'short' => 'Premium tropical pineapple chunks from ripe Sri Lankan pineapples — dried or frozen.',
        'desc'  => 'Ceylon Aroma Pineapple Chunks are a premium tropical offering made from ripe Sri Lankan pineapples, available in dried or frozen formats. Ideal for snacking, baking, or blending into smoothies. Naturally sweet, free from additives, and export-certified.',
        'cats'  => ['Fruit Pulp'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/pineapple-chunks.jpg',
    ],
    [
        'name'  => 'Moringa Flavoured Tea',
        'slug'  => 'moringa-flavored-tea',
        'short' => 'Bold Ceylon tea infused with nutrient-rich Moringa leaves — the Miracle Tree blend.',
        'desc'  => 'Infused with the nutrient-rich leaves of Moringa (often called the Miracle Tree), this herbal blend combines the bold character of Ceylon tea with the earthy, refreshing notes of Moringa. Rich in antioxidants and vitamins. Available in loose leaf and pyramid bag formats for global export.',
        'cats'  => ['Ceylon Tea', 'Flavoured Tea'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/murunga-tea.jpg',
    ],
    [
        'name'  => 'Gotukola Flavoured Tea',
        'slug'  => 'gotukola-flavored-tea',
        'short' => 'Ceylon tea fused with Gotukola — a traditional Ayurvedic herbal wellness blend.',
        'desc'  => 'Infused with the goodness of Gotukola (Centella asiatica), this unique herbal blend combines the bold character of Ceylon tea with the refreshing, earthy notes of Gotukola. A celebrated Ayurvedic herb known for cognitive and circulatory benefits. Available in loose leaf and retail tea bags.',
        'cats'  => ['Ceylon Tea', 'Flavoured Tea'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/gotukola-tea.webp',
    ],
    [
        'name'  => 'Cocktail Mix',
        'slug'  => 'cocktail-mix',
        'short' => 'Vibrant tropical fruit cocktail mix — naturally sweet, export-grade, hotel & foodservice ready.',
        'desc'  => 'A vibrant blend of tropical fruits crafted into ready-to-use cocktail chunks and mixes. Each piece is carefully selected, cut, and preserved to retain its natural sweetness, color, and aroma. Perfect for hotels, juice bars, foodservice, and retail export.',
        'cats'  => ['Fruit Pulp'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/cocktails.webp',
    ],
    [
        'name'  => 'Ceylon Black Tea',
        'slug'  => 'ceylon-black-tea',
        'short' => 'World-renowned Ceylon Black Tea from the lush highlands of Sri Lanka.',
        'desc'  => 'Discover the world-renowned taste of Ceylon Black Tea, cultivated in the lush highlands of Sri Lanka. Handpicked and carefully processed, our tea delivers a rich aroma, bold flavor, and deep amber colour. Available in BOP, BOPF, and Pekoe grades for bulk and retail export.',
        'cats'  => ['Ceylon Tea'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/black-tea.webp',
    ],
    [
        'name'  => 'Mango Chunks',
        'slug'  => 'mango-chunks',
        'short' => 'Naturally sweet mango chunks — harvested at peak ripeness from Sri Lankan farms.',
        'desc'  => 'Enjoy the tropical taste of Sri Lanka with our naturally sweet mango chunks. Harvested at peak ripeness, each piece is carefully cut and preserved to maintain its vibrant color, rich flavor, and nutritional value. Available in syrup, dried, and frozen formats for export.',
        'cats'  => ['Fruit Pulp'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/mango-chunks.webp',
    ],
    [
        'name'  => 'Mango Puree',
        'slug'  => 'mango-puree',
        'short' => 'Smooth golden mango puree from carefully selected ripe Sri Lankan mangoes.',
        'desc'  => 'Experience the rich tropical flavor of Sri Lankan mangoes in our smooth, golden puree. Made from carefully selected ripe mangoes, this puree is naturally sweet, free from additives, and processed under strict export-grade hygiene standards. Ideal for beverages, bakery, and foodservice.',
        'cats'  => ['Fruit Pulp'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/mango-puree.webp',
    ],
    [
        'name'  => 'Dried Pineapple Ring',
        'slug'  => 'dried-pineapple-ring',
        'short' => 'Sun-kissed dried pineapple rings — naturally preserved, tropical sweetness preserved.',
        'desc'  => 'Savor the tropical sweetness of Sri Lanka with our sun-kissed dried pineapple rings — naturally preserved, rich in flavor, and free from additives. Each ring is carefully selected and dehydrated to retain maximum nutrition and natural sweetness. Ideal for retail snack, gift packs, and foodservice export.',
        'cats'  => ['Dehydrated Products', 'Fruits'],
        'img'   => 'https://ceylonaroma.com/wp-content/uploads/2026/03/dried-pineapple-ring.jpg',
    ],
];

$storageDir = $base.'/ceylon_aroma/storage/app/public/products';
if (!is_dir($storageDir)) mkdir($storageDir, 0775, true);

$added = 0; $skipped = 0; $imgFailed = [];

foreach ($products as $i => $p) {
    // Resolve category
    $catId = null;
    foreach ($p['cats'] as $cat) {
        if (isset($catMap[$cat])) { $catId = $catMap[$cat]; break; }
    }

    // Download image
    $filename = basename($p['img']);
    $localPath = $storageDir.'/'.$filename;
    $dbImgPath = 'products/'.$filename;

    if (!file_exists($localPath)) {
        $ctx = stream_context_create(['http'=>['timeout'=>15,'header'=>'User-Agent: Mozilla/5.0']]);
        $imgData = @file_get_contents($p['img'], false, $ctx);
        if ($imgData) {
            file_put_contents($localPath, $imgData);
        } else {
            $imgFailed[] = $filename;
            $dbImgPath = null;
        }
    }

    // Skip if slug already exists
    if (DB::table('products')->where('slug', $p['slug'])->exists()) {
        echo "SKIP (exists): {$p['name']}\n";
        $skipped++;
        continue;
    }

    DB::table('products')->insert([
        'category_id'      => $catId,
        'name'             => $p['name'],
        'slug'             => $p['slug'],
        'short_description'=> $p['short'],
        'description'      => $p['desc'],
        'image'            => $dbImgPath,
        'is_featured'      => ($i < 6) ? 1 : 0,
        'is_bestseller'    => in_array($p['slug'], ['ceylon-true-cinnamon','ceylon-black-tea','mango-puree']) ? 1 : 0,
        'is_new_arrival'   => ($i >= 12) ? 1 : 0,
        'is_export_ready'  => 1,
        'status'           => 1,
        'sort_order'       => $i + 1,
        'created_at'       => now(),
        'updated_at'       => now(),
    ]);
    echo "ADDED: {$p['name']}\n";
    $added++;
}

echo "\n=== Done: $added added, $skipped skipped ===\n";
if ($imgFailed) echo "Image download failed: ".implode(', ',$imgFailed)."\n";
echo "DELETE THIS FILE AFTER RUNNING.\n";
