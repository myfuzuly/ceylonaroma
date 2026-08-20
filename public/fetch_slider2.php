<?php
// Fetch actual hero slider images from ceylonaroma.com
$base = dirname(__DIR__);
$sliderPath = $base . '/ceylon_aroma/storage/app/public/slider/';
if (!is_dir($sliderPath)) mkdir($sliderPath, 0755, true);

$ctx = stream_context_create(['http' => [
    'method' => 'GET',
    'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\nAccept: text/html,application/xhtml+xml,*/*;q=0.9\r\nAccept-Language: en-US,en;q=0.5\r\n",
    'timeout' => 30,
]]);

echo "Fetching ceylonaroma.com homepage...\n";
$html = @file_get_contents('https://ceylonaroma.com/', false, $ctx);
if (!$html) { die("Failed\n"); }
echo "Fetched " . strlen($html) . " bytes\n\n";

// Target slider-specific patterns:
// MetaSlider, WP Slider, Revolution Slider, Elementor Slider, Swiper, nivo-slider, etc.
$sliderImgs = [];

// 1. MetaSlider — class="ms-image" or inside .metaslider
preg_match_all('/class="[^"]*(?:ms-image|metaslider|nivoSlider|nivo-main-image)[^"]*"[^>]*src="([^"]+)"/', $html, $m);
foreach ($m[1] as $u) $sliderImgs[] = $u;

// 2. Revolution Slider — data-src or data-bg inside .rev-slidebg or rs-slide
preg_match_all('/class="[^"]*(?:rev-slidebg|rs-slide|rs-lazyload)[^"]*"[^>]*(?:data-src|src)="([^"]+)"/', $html, $m);
foreach ($m[1] as $u) $sliderImgs[] = $u;

// 3. Elementor slider / swiper
preg_match_all('/class="[^"]*(?:elementor-slide-bg|swiper-slide)[^"]*"[^>]*style="[^"]*background-image\s*:\s*url\(\'?([^\')\s]+)\'?\)/', $html, $m);
foreach ($m[1] as $u) $sliderImgs[] = $u;

// 4. data-src anywhere near "slider", "slide", "hero", "banner"
preg_match_all('/(?:data-src|data-lazy)="(https?:\/\/ceylonaroma\.com\/wp-content\/uploads\/[^"]+\.(?:jpg|jpeg|png|webp)[^"]*)"/', $html, $m);
foreach ($m[1] as $u) $sliderImgs[] = $u;

// 5. Any large image from the first 15000 chars (likely the hero/above-fold)
$aboveFold = substr($html, 0, 15000);
preg_match_all('/src="(https?:\/\/ceylonaroma\.com\/wp-content\/uploads\/[^"]+\.(?:jpg|jpeg|png|webp))"/', $aboveFold, $m);
foreach ($m[1] as $u) {
    // Skip thumbnails (small sizes like -150x150, -300x200)
    if (!preg_match('/-\d{1,3}x\d{1,3}\./', $u)) $sliderImgs[] = $u;
}

// 6. All wp-content images in HTML — bigger ones (no tiny thumbnail suffix)
preg_match_all('/src="(https?:\/\/ceylonaroma\.com\/wp-content\/uploads\/[^"]+\.(?:jpg|jpeg|png|webp))"/', $html, $m);
foreach ($m[1] as $u) {
    if (!preg_match('/-\d{1,3}x\d{1,3}\./', $u)) $sliderImgs[] = $u;
}

// Deduplicate while preserving order
$seen = []; $unique = [];
foreach ($sliderImgs as $u) {
    $key = strtok($u, '?');
    if (!isset($seen[$key])) { $seen[$key] = true; $unique[] = $u; }
}

echo "Found " . count($unique) . " candidate slide images:\n";
foreach ($unique as $i => $u) echo "  [$i] " . basename($u) . "\n";
echo "\n";

// Clear old slider images
foreach (glob($sliderPath . '*.{jpg,jpeg,png,webp}', GLOB_BRACE) as $f) {
    unlink($f);
    echo "Removed old: " . basename($f) . "\n";
}

// Download up to 10 images
$n = 0;
foreach (array_slice($unique, 0, 10) as $url) {
    $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION)) ?: 'jpg';
    $fname = 'slide-' . ($n + 1) . '.' . $ext;
    $dest  = $sliderPath . $fname;

    $data = @file_get_contents($url, false, $ctx);
    if (!$data || strlen($data) < 10000) {
        echo "SKIP (too small or failed): " . basename($url) . "\n";
        continue;
    }

    // Verify it's actually an image (check magic bytes)
    $magic = substr($data, 0, 4);
    $isImg = (substr($magic, 0, 3) === "\xFF\xD8\xFF") // JPEG
          || (substr($magic, 0, 4) === "\x89PNG")       // PNG
          || (substr($magic, 0, 4) === 'RIFF')          // WebP (RIFF....WEBP)
          || (substr($data, 0, 6) === 'GIF87a') || (substr($data, 0, 6) === 'GIF89a'); // GIF
    if (!$isImg) { echo "SKIP (not image): " . basename($url) . "\n"; continue; }

    file_put_contents($dest, $data);
    echo "OK slide-" . ($n+1) . ": " . basename($url) . " (" . number_format(strlen($data)/1024, 0) . " KB)\n";
    $n++;
}

echo "\nTotal: $n slider images downloaded\n";
echo "Files in slider/:\n";
foreach (glob($sliderPath . '*') as $f) echo "  " . basename($f) . " (" . number_format(filesize($f)/1024, 0) . " KB)\n";
