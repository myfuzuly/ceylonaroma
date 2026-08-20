<?php
define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__);
require $base.'/ceylon_aroma/vendor/autoload.php';
$app = require_once $base.'/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$storagePath = $base . '/ceylon_aroma/storage/app/public/slider/';
if (!is_dir($storagePath)) mkdir($storagePath, 0755, true);
$catPath = $base . '/ceylon_aroma/storage/app/public/categories/';
if (!is_dir($catPath)) mkdir($catPath, 0755, true);

$ctx = stream_context_create(['http' => [
    'method' => 'GET',
    'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\nAccept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\nAccept-Language: en-US,en;q=0.5\r\n",
    'timeout' => 30,
]]);

// Fetch ceylonaroma.com homepage
echo "Fetching ceylonaroma.com...\n";
$html = @file_get_contents('https://ceylonaroma.com/', false, $ctx);
if (!$html) {
    echo "Failed to fetch homepage. Trying WP media API...\n";
} else {
    echo "Fetched " . strlen($html) . " bytes\n";
}

// Find all img src URLs in the HTML
$imageUrls = [];
if ($html) {
    // Match slider/banner/hero images - look for common slider classes
    // Metaslider, WP slider, Revolution Slider, Elementor, etc.
    preg_match_all('/(?:data-src|src|data-lazy-src)=["\']([^"\']+(?:\.jpg|\.jpeg|\.png|\.webp)[^"\']*)["\']/', $html, $m);
    foreach ($m[1] as $url) {
        if (strpos($url, 'ceylonaroma.com') !== false || strpos($url, 'wp-content') !== false) {
            // Filter out small thumbnails (keep large images)
            if (!preg_match('/-\d+x\d+\./', $url) || preg_match('/-\d{3,4}x\d{3,4}\./', $url)) {
                $imageUrls[] = $url;
            }
        }
    }
    echo "Found " . count($imageUrls) . " image URLs on homepage\n";
    foreach (array_slice($imageUrls, 0, 20) as $u) echo "  $u\n";
}

// Also try WP media API to find recent uploads
echo "\nFetching WP media API...\n";
$mediaUrl = 'https://ceylonaroma.com/wp-json/wp/v2/media?per_page=50&media_type=image&orderby=date&order=desc';
$mediaRaw = @file_get_contents($mediaUrl, false, $ctx);
$media = $mediaRaw ? json_decode($mediaRaw, true) : [];
echo "Found " . count($media) . " media items\n";

$wideImages = [];
foreach ($media as $m) {
    $src = $m['source_url'] ?? '';
    $w   = $m['media_details']['width'] ?? 0;
    $h   = $m['media_details']['height'] ?? 0;
    if ($w >= 800 && $w > $h) { // landscape/wide images
        $wideImages[] = ['url' => $src, 'w' => $w, 'h' => $h, 'title' => $m['title']['rendered'] ?? ''];
    }
}
// Sort by width desc
usort($wideImages, fn($a, $b) => $b['w'] - $a['w']);
echo "Wide images (" . count($wideImages) . "):\n";
foreach (array_slice($wideImages, 0, 20) as $img) {
    echo "  [{$img['w']}x{$img['h']}] {$img['title']} => " . basename($img['url']) . "\n";
}

// Download top wide images as slider images
echo "\nDownloading slider images...\n";
$downloaded = 0;
foreach (array_slice($wideImages, 0, 8) as $i => $img) {
    $ext = strtolower(pathinfo(parse_url($img['url'], PHP_URL_PATH), PATHINFO_EXTENSION)) ?: 'jpg';
    $fname = 'slide-' . ($i+1) . '.' . $ext;
    $dest = $storagePath . $fname;
    $data = @file_get_contents($img['url'], false, $ctx);
    if ($data && strlen($data) > 5000) {
        file_put_contents($dest, $data);
        echo "OK: $fname (" . number_format(strlen($data)/1024, 0) . " KB) — {$img['title']}\n";
        $downloaded++;
    } else {
        echo "FAIL: {$img['url']}\n";
    }
}

// Also try to fill missing category images from wide images
echo "\nTrying to fill missing category images...\n";
$missing = DB::table('categories')
    ->whereNull('parent_id')
    ->where(function($q){ $q->whereNull('image')->orWhere('image',''); })
    ->get(['id','name','slug']);

// Keywords to match category to image title/filename
$keywords = [
    'ceylon-cinnamon'       => ['cinnamon','cinnam'],
    'ceylon-coffee'         => ['coffee','cafe'],
    'aromatic-oils'         => ['oil','aroma','coconut','essential'],
    'ayurvedic-products'    => ['ayurved','herbal','herb','moringa','gotukola','turmeric'],
    'lifestyle-natural-care'=> ['lifestyle','soap','candle','spa','wellness'],
    'dates-nuts'            => ['nut','cashew','date','almond'],
];

foreach ($missing as $cat) {
    $words = $keywords[$cat->slug] ?? [strtolower(str_replace('-',' ',$cat->slug))];
    foreach ($wideImages as $img) {
        $haystack = strtolower($img['title'] . ' ' . basename($img['url']));
        foreach ($words as $w) {
            if (strpos($haystack, $w) !== false) {
                $ext = strtolower(pathinfo(parse_url($img['url'], PHP_URL_PATH), PATHINFO_EXTENSION)) ?: 'jpg';
                $fname = $cat->slug . '.' . $ext;
                $dest = $catPath . $fname;
                if (!file_exists($dest)) {
                    $data = @file_get_contents($img['url'], false, $ctx);
                    if ($data && strlen($data) > 5000) {
                        file_put_contents($dest, $data);
                    }
                }
                if (file_exists($dest)) {
                    DB::table('categories')->where('id', $cat->id)->update([
                        'image' => 'categories/' . $fname,
                        'updated_at' => now(),
                    ]);
                    echo "MATCHED: {$cat->name} => $fname (keyword: $w)\n";
                    break 2;
                }
            }
        }
    }
}

echo "\n=== Final categories ===\n";
$all = DB::table('categories')->whereNull('parent_id')->orderBy('sort_order')->get(['name','image']);
foreach ($all as $c) echo "  [{$c->name}] " . ($c->image ?: 'NONE') . "\n";

echo "\nSlider images in storage/slider/:\n";
foreach (glob($storagePath . '*') as $f) {
    echo "  " . basename($f) . " (" . number_format(filesize($f)/1024, 0) . " KB)\n";
}
