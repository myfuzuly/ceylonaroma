<?php
define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__);
require $base.'/ceylon_aroma/vendor/autoload.php';
$app = require_once $base.'/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

$storagePath = $base . '/ceylon_aroma/storage/app/public/categories/';

// For each parent category with no image, find a product in that category
// (or any of its subcategories) that has an image, and copy it.
$parents = DB::table('categories')->whereNull('parent_id')->where('status', 1)->orderBy('sort_order')->get();

foreach ($parents as $cat) {
    if ($cat->image) {
        echo "SKIP (has image): {$cat->name}\n";
        continue;
    }

    // Find products in this category or any child category
    $childIds = DB::table('categories')->where('parent_id', $cat->id)->pluck('id');
    $allIds = $childIds->push($cat->id);

    $product = DB::table('products')
        ->whereIn('category_id', $allIds)
        ->whereNotNull('image')
        ->where('image', '!=', '')
        ->first();

    if (!$product) {
        echo "NO PRODUCT IMAGE: {$cat->name}\n";
        continue;
    }

    // The product image path is relative to storage/app/public/
    $srcPath = $base . '/ceylon_aroma/storage/app/public/' . $product->image;
    if (!file_exists($srcPath)) {
        echo "SRC FILE MISSING: {$product->image}\n";
        continue;
    }

    $ext   = pathinfo($srcPath, PATHINFO_EXTENSION) ?: 'jpg';
    $fname = $cat->slug . '.' . $ext;
    $dest  = $storagePath . $fname;

    copy($srcPath, $dest);
    $relPath = 'categories/' . $fname;

    DB::table('categories')->where('id', $cat->id)->update([
        'image'      => $relPath,
        'updated_at' => now(),
    ]);
    echo "OK: {$cat->name} => $relPath (from product: {$product->name})\n";
}

echo "\n=== Final state ===\n";
$all = DB::table('categories')->whereNull('parent_id')->orderBy('sort_order')->get(['name','slug','image']);
foreach ($all as $c) {
    echo "  [{$c->name}] " . ($c->image ?: 'NO IMAGE') . "\n";
}
