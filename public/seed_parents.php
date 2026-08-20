<?php
/* Assign parent_id relationships — DELETE after use */
require dirname(__DIR__) . '/ceylon_aroma/vendor/autoload.php';
$app = require dirname(__DIR__) . '/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;

// parent slug => [child slugs]
$map = [
    'ceylon-spices'       => ['ceylon-cinnamon','alba-cinnamon','cardamom','blends-masala'],
    'ceylon-coffee'       => ['classic-coffee','c5-special-c5','flavored-coffee'],
    'ceylon-tea'          => ['black-tea','flavoured-tea'],
    'aromatic-oils'       => ['aroma-products','carrier-oils','fragrance-sachets'],
    'dehydrated-products' => ['dehydrated-fruits','herbal-powders'],
    'frozen-pulp'         => ['fruit-puree','frozen-pulps'],
    'nuts-natural-foods'  => ['ceylon-cashew'],
    'traditional-remedies'=> ['herbal-soaps'],
];

foreach ($map as $parentSlug => $childSlugs) {
    $parent = Category::where('slug', $parentSlug)->first();
    if (!$parent) { echo "MISSING PARENT: $parentSlug<br>"; continue; }

    foreach ($childSlugs as $childSlug) {
        $child = Category::where('slug', $childSlug)->first();
        if (!$child) { echo "MISSING CHILD: $childSlug<br>"; continue; }

        $child->update(['parent_id' => $parent->id]);
        echo "OK: {$child->name} → {$parent->name}<br>";
    }
}

echo "<br>Done.";
