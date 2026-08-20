<?php
define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__);
require $base.'/ceylon_aroma/vendor/autoload.php';
$app = require_once $base.'/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$storagePath = $base . '/ceylon_aroma/storage/app/public/categories/';
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0755, true);
    echo "Created categories storage dir\n";
}

// Fetch WooCommerce product categories via WordPress REST API
$url = 'https://ceylonaroma.com/wp-json/wc/v3/products/categories?per_page=100&hide_empty=false';
// Fall back to WP categories endpoint
$wpUrl = 'https://ceylonaroma.com/wp-json/wp/v2/product_cat?per_page=100&_embed';

$ctx = stream_context_create(['http' => [
    'method' => 'GET',
    'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n",
    'timeout' => 20,
]]);

// Try WP REST endpoint for product_cat taxonomy
$raw = @file_get_contents($wpUrl, false, $ctx);
$cats = $raw ? json_decode($raw, true) : null;

if (!$cats) {
    echo "WP REST failed, trying products/_embed for featured images...\n";
    // Fall through to manual mapping below
    $cats = [];
}

echo "Fetched " . count($cats) . " categories from API\n";

// Also fetch products to get images for categories we're missing
$prodUrl = 'https://ceylonaroma.com/wp-json/wp/v2/product?per_page=100&_embed';
$prodRaw = @file_get_contents($prodUrl, false, $ctx);
$products = $prodRaw ? json_decode($prodRaw, true) : [];
echo "Fetched " . count($products) . " products from API\n\n";

// Build a map: category-slug => first product image URL
$catImageMap = [];
foreach ($products as $prod) {
    $featured = $prod['_embedded']['wp:featuredmedia'][0]['source_url'] ?? null;
    $terms = $prod['_embedded']['wp:term'] ?? [];
    foreach ($terms as $termGroup) {
        foreach ($termGroup as $term) {
            if (($term['taxonomy'] ?? '') === 'product_cat' && $featured) {
                $slug = $term['slug'] ?? '';
                if ($slug && !isset($catImageMap[$slug])) {
                    $catImageMap[$slug] = $featured;
                }
            }
        }
    }
}
echo "Built image map for " . count($catImageMap) . " category slugs:\n";
foreach ($catImageMap as $slug => $imgUrl) {
    echo "  $slug => " . basename($imgUrl) . "\n";
}
echo "\n";

// Map WP category slugs to our local category slugs
$slugMap = [
    'spices'             => 'ceylon-spices',
    'coffee'             => 'ceylon-coffee',
    'tea'                => 'ceylon-tea',
    'cinnamon'           => 'ceylon-cinnamon',
    'fruits-pulps'       => 'pulp',
    'aromatic-oils'      => 'aromatic-oils',
    'ayurvedic'          => 'ayurvedic-products',
    'lifestyle'          => 'lifestyle-natural-care',
    'dehydrated'         => 'dehydrated-products',
    'dates-nuts'         => 'dates-nuts',
    // Also try direct matches
    'ceylon-spices'      => 'ceylon-spices',
    'ceylon-coffee'      => 'ceylon-coffee',
    'ceylon-tea'         => 'ceylon-tea',
    'ceylon-cinnamon'    => 'ceylon-cinnamon',
];

$downloaded = 0;
$failed = 0;

foreach ($catImageMap as $wpSlug => $imageUrl) {
    $localSlug = $slugMap[$wpSlug] ?? $wpSlug;

    $cat = DB::table('categories')->where('slug', $localSlug)->whereNull('parent_id')->first();
    if (!$cat) {
        echo "No local category for WP slug: $wpSlug (tried: $localSlug)\n";
        continue;
    }

    if ($cat->image) {
        echo "SKIP (has image): $localSlug\n";
        continue;
    }

    // Download image
    $ext  = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
    $ext  = strtolower(explode('?', $ext)[0]);
    $fname = $localSlug . '.' . $ext;
    $dest  = $storagePath . $fname;

    $img = @file_get_contents($imageUrl, false, $ctx);
    if (!$img) {
        echo "FAIL download: $imageUrl\n";
        $failed++;
        continue;
    }

    file_put_contents($dest, $img);
    $relPath = 'categories/' . $fname;

    DB::table('categories')->where('id', $cat->id)->update([
        'image'      => $relPath,
        'updated_at' => now(),
    ]);
    echo "OK: $localSlug => $relPath (" . strlen($img) . " bytes)\n";
    $downloaded++;
}

echo "\n=== Done: $downloaded downloaded, $failed failed ===\n";

// Show current state
$all = DB::table('categories')->whereNull('parent_id')->orderBy('sort_order')->get(['name','slug','image']);
echo "\nParent categories:\n";
foreach ($all as $c) {
    echo "  [{$c->name}] image=" . ($c->image ?: 'NONE') . "\n";
}
