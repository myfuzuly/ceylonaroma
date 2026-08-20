<?php
require dirname(__DIR__) . '/ceylon_aroma/vendor/autoload.php';
$app = require dirname(__DIR__) . '/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Product;

$base = 'https://ceylonaroma.com';
$today = date('Y-m-d');

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

function url($loc, $priority = '0.7', $freq = 'weekly', $lastmod = null) {
    global $today;
    echo "  <url>\n";
    echo "    <loc>" . htmlspecialchars($loc) . "</loc>\n";
    echo "    <lastmod>" . ($lastmod ?: $today) . "</lastmod>\n";
    echo "    <changefreq>{$freq}</changefreq>\n";
    echo "    <priority>{$priority}</priority>\n";
    echo "  </url>\n";
}

// Static pages
url($base,                      '1.0', 'weekly');
url($base . '/about',           '0.8', 'monthly');
url($base . '/products',        '0.9', 'daily');
url($base . '/export',          '0.8', 'monthly');
url($base . '/quality',         '0.8', 'monthly');
url($base . '/private-label',   '0.8', 'monthly');
url($base . '/contact',         '0.7', 'monthly');
url($base . '/blog',            '0.8', 'weekly');

// Categories
foreach (Category::where('status', true)->orderBy('sort_order')->get() as $cat) {
    url($base . '/products?category=' . $cat->slug, '0.8', 'weekly', $cat->updated_at?->format('Y-m-d'));
}

// Products
foreach (Product::where('status', true)->latest('updated_at')->get() as $p) {
    url($base . '/products/' . $p->slug, '0.7', 'weekly', $p->updated_at?->format('Y-m-d'));
}

// Blog posts
if (class_exists(\App\Models\Post::class)) {
    foreach (\App\Models\Post::where('status', 'published')->latest('published_at')->get() as $post) {
        url($base . '/blog/' . $post->slug, '0.6', 'monthly', $post->published_at?->format('Y-m-d'));
    }
}

echo '</urlset>';
