<?php
/* One-time sort_order seeder — DELETE after use */
require dirname(__DIR__) . '/ceylon_aroma/vendor/autoload.php';
$app = require dirname(__DIR__) . '/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;

// slug => sort_order (steps of 10 so admin can insert in-between)
$orders = [
    // ── Spices group (10-49)
    'ceylon-spices'        => 10,
    'ceylon-cinnamon'      => 20,
    'alba-cinnamon'        => 30,
    'cardamom'             => 40,
    'blends-masala'        => 50,

    // ── Coffee group (60-89)
    'ceylon-coffee'        => 60,
    'classic-coffee'       => 70,
    'c5-special-c5'        => 80,
    'flavored-coffee'      => 90,

    // ── Tea group (100-119)
    'ceylon-tea'           => 100,
    'black-tea'            => 110,
    'flavoured-tea'        => 120,

    // ── Oils & Aromas (130-159)
    'aromatic-oils'        => 130,
    'aroma-products'       => 140,
    'carrier-oils'         => 150,
    'fragrance-sachets'    => 160,

    // ── Dehydrated & Dried (170-199)
    'dehydrated-products'  => 170,
    'dehydrated-fruits'    => 180,
    'herbal-powders'       => 190,

    // ── Frozen & Pulp (200-219)
    'frozen-pulp'          => 200,
    'frozen-pulps'         => 210,
    'fruit-puree'          => 220,

    // ── Nuts & Cashew (230-249)
    'nuts-natural-foods'   => 230,
    'ceylon-cashew'        => 240,

    // ── Wellness (250+)
    'traditional-remedies' => 250,
    'herbal-soaps'         => 260,
];

$updated = 0;
$missing = [];
foreach ($orders as $slug => $order) {
    $rows = Category::where('slug', $slug)->update(['sort_order' => $order]);
    if ($rows) {
        echo "OK [{$order}]: {$slug}<br>";
        $updated++;
    } else {
        $missing[] = $slug;
    }
}

if ($missing) {
    echo "<br><strong>Not found (slug may differ):</strong><br>";
    foreach ($missing as $s) echo "— {$s}<br>";
}

echo "<br>Updated: {$updated} categories. Done.";
