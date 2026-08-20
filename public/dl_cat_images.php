<?php
define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__);
require $base.'/ceylon_aroma/vendor/autoload.php';
$app = require_once $base.'/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$storagePath = $base . '/ceylon_aroma/storage/app/public/categories/';
if (!is_dir($storagePath)) mkdir($storagePath, 0755, true);

$ctx = stream_context_create(['http' => [
    'method' => 'GET',
    'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n",
    'timeout' => 30,
]]);

// Fetch all products from WP API to build category-to-image map
$url = 'https://ceylonaroma.com/wp-json/wp/v2/product?per_page=100&_embed';
$raw = @file_get_contents($url, false, $ctx);
$products = $raw ? json_decode($raw, true) : [];
echo "Fetched " . count($products) . " products\n";

// Build: wpCategorySlug => imageUrl
$catImgs = [];
foreach ($products as $prod) {
    $featImg = $prod['_embedded']['wp:featuredmedia'][0]['source_url'] ?? null;
    if (!$featImg) continue;
    $terms = $prod['_embedded']['wp:term'] ?? [];
    foreach ($terms as $termGroup) {
        foreach ($termGroup as $term) {
            if (($term['taxonomy'] ?? '') === 'product_cat') {
                $slug = $term['slug'] ?? '';
                if ($slug && !isset($catImgs[$slug])) {
                    $catImgs[$slug] = $featImg;
                }
            }
        }
    }
}
echo "Category image map:\n";
foreach ($catImgs as $s => $u) echo "  $s => " . basename($u) . "\n";

// Map WP slugs → our slugs
$map = [
    'cinnamon'                => 'ceylon-cinnamon',
    'ceylon-cinnamon'         => 'ceylon-cinnamon',
    'coffee'                  => 'ceylon-coffee',
    'ceylon-coffee'           => 'ceylon-coffee',
    'aromatic-oils'           => 'aromatic-oils',
    'essential-oils'          => 'aromatic-oils',
    'ayurvedic'               => 'ayurvedic-products',
    'ayurvedic-products'      => 'ayurvedic-products',
    'herbal'                  => 'ayurvedic-products',
    'lifestyle'               => 'lifestyle-natural-care',
    'lifestyle-natural-care'  => 'lifestyle-natural-care',
    'dates-nuts'              => 'dates-nuts',
    'nuts'                    => 'dates-nuts',
];

$missing = DB::table('categories')
    ->whereNull('parent_id')
    ->whereNull('image')
    ->orWhere('image','')
    ->pluck('slug','id');

echo "\nMissing images for: " . $missing->values()->implode(', ') . "\n\n";

foreach ($catImgs as $wpSlug => $imgUrl) {
    $localSlug = $map[$wpSlug] ?? $wpSlug;
    $cat = DB::table('categories')
        ->where('slug', $localSlug)
        ->whereNull('parent_id')
        ->whereNull('image')
        ->first();
    if (!$cat) continue;

    $ext  = strtolower(pathinfo(parse_url($imgUrl, PHP_URL_PATH), PATHINFO_EXTENSION)) ?: 'jpg';
    $ext  = explode('?', $ext)[0];
    $fname = $localSlug . '.' . $ext;
    $dest  = $storagePath . $fname;

    $img = @file_get_contents($imgUrl, false, $ctx);
    if (!$img || strlen($img) < 1000) {
        echo "FAIL: $localSlug ($imgUrl)\n";
        continue;
    }
    file_put_contents($dest, $img);
    DB::table('categories')->where('id', $cat->id)->update([
        'image'      => 'categories/' . $fname,
        'updated_at' => now(),
    ]);
    echo "OK: $localSlug (" . number_format(strlen($img)/1024, 1) . " KB) => categories/$fname\n";
}

// Final report
echo "\n=== Final ===\n";
$all = DB::table('categories')->whereNull('parent_id')->orderBy('sort_order')->get(['name','image']);
foreach ($all as $c) echo "  [{$c->name}] " . ($c->image ?: 'NONE') . "\n";
