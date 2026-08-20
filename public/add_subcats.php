<?php
define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__);
require $base.'/ceylon_aroma/vendor/autoload.php';
$app = require_once $base.'/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// ── 1. Add parent_id column if not already there ──────────────
if (!Schema::hasColumn('categories', 'parent_id')) {
    DB::statement('ALTER TABLE categories ADD COLUMN parent_id BIGINT UNSIGNED NULL AFTER id');
    echo "Added parent_id column\n";
} else {
    echo "parent_id already exists\n";
}

// ── 2. Get parent IDs by slug ─────────────────────────────────
$parents = DB::table('categories')->whereNull('parent_id')->pluck('id', 'slug');
echo "Parents: " . $parents->toJson() . "\n\n";

// ── 3. Subcategory data ───────────────────────────────────────
$subcats = [
    // Ceylon Cinnamon
    'ceylon-cinnamon' => [
        ['Alba Cinnamon','alba-cinnamon',1],
        ['C5 Special & C5','c5-special-c5',2],
        ['C4 Cinnamon','c4-cinnamon',3],
        ['M5 & M4 Cinnamon','m5-m4-cinnamon',4],
        ['H1 & H2 Cinnamon','h1-h2-cinnamon',5],
        ['Cinnamon Cut','cinnamon-cut',6],
        ['Cinnamon Quills','cinnamon-quills',7],
        ['Cinnamon Powder','cinnamon-powder',8],
        ['Bulk Cinnamon Export','bulk-cinnamon-export',9],
    ],
    // Ceylon Coffee
    'ceylon-coffee' => [
        ['Classic Coffee','classic-coffee',1],
        ['Flavored Coffee','flavored-coffee',2],
        ['Gold Coffee','gold-coffee',3],
        ['Instant Coffee','instant-coffee',4],
        ['Original Coffee','original-coffee',5],
    ],
    // Ceylon Tea
    'ceylon-tea' => [
        ['Black Tea','black-tea',1],
        ['Flavoured Tea','flavoured-tea',2],
        ['Green Tea','green-tea',3],
        ['Herbal Tea','herbal-tea',4],
    ],
    // Ceylon Spices
    'ceylon-spices' => [
        ['Blends & Masala','blends-masala',1],
        ['Cardamom','cardamom',2],
        ['Cloves','cloves',3],
        ['Nutmeg & Mace','nutmeg-mace',4],
        ['Pepper','pepper',5],
    ],
    // Pulp
    'pulp' => [
        ['Fruit Puree','fruit-puree',1],
        ['Frozen Pulps','frozen-pulps',2],
        ['Cut Fruits','cut-fruits',3],
    ],
    // Aromatic Oils
    'aromatic-oils' => [
        ['Aroma Products','aroma-products',1],
        ['Carrier Oils','carrier-oils',2],
        ['Ceylon Essential Oils','ceylon-essential-oils',3],
        ['Herbal Oils & Balms','herbal-oils-balms',4],
        ['Natural Fragrance Oils','natural-fragrance-oils',5],
        ['Virgin Coconut Oil','virgin-coconut-oil',6],
    ],
    // Ayurvedic Products
    'ayurvedic-products' => [
        ['Herbal Powders','herbal-powders',1],
        ['Traditional Remedies','traditional-remedies',2],
        ['Wellness Oils & Balms','wellness-oils-balms',3],
    ],
    // Lifestyle & Natural Care
    'lifestyle-natural-care' => [
        ['Fragrance Sachets','fragrance-sachets',1],
        ['Herbal Soaps','herbal-soaps',2],
        ['Natural Candles','natural-candles',3],
        ['Spa & Wellness Products','spa-wellness-products',4],
    ],
    // Dehydrated Products
    'dehydrated-products' => [
        ['Fruits','dehydrated-fruits',1],
        ['Vegetables','dehydrated-vegetables',2],
        ['Herbs','dehydrated-herbs',3],
        ['Leaves','dehydrated-leaves',4],
        ['Spices','dehydrated-spices',5],
        ['Foods','dehydrated-foods',6],
    ],
    // Dates & Nuts
    'dates-nuts' => [
        ['Ceylon Cashew','ceylon-cashew',1],
        ['Almonds','almonds',2],
        ['Pistachios','pistachios',3],
        ['Walnuts','walnuts',4],
    ],
];

// ── 4. Insert subcategories ───────────────────────────────────
$added = 0; $skipped = 0;
foreach ($subcats as $parentSlug => $children) {
    $parentId = $parents[$parentSlug] ?? null;
    if (!$parentId) { echo "MISSING PARENT: $parentSlug\n"; continue; }

    foreach ($children as [$name, $slug, $sort]) {
        if (DB::table('categories')->where('slug', $slug)->exists()) {
            echo "SKIP: $name\n"; $skipped++; continue;
        }
        DB::table('categories')->insert([
            'parent_id'  => $parentId,
            'name'       => $name,
            'slug'       => $slug,
            'sort_order' => $sort,
            'status'     => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "ADDED: $name (parent: $parentSlug)\n";
        $added++;
    }
}

echo "\n=== Done: $added added, $skipped skipped ===\n";
echo "Total categories: " . DB::table('categories')->count() . "\n";
