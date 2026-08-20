<?php
/* One-time category seeder — DELETE after use */
require dirname(__DIR__) . '/ceylon_aroma/vendor/autoload.php';
$app = require dirname(__DIR__) . '/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;

$add = [
    ['name'=>'Ceylon Spices',       'slug'=>'ceylon-spices',       'sort_order'=>1],
    ['name'=>'Ceylon Tea',          'slug'=>'ceylon-tea',          'sort_order'=>3],
    ['name'=>'Aromatic Oils',       'slug'=>'aromatic-oils',       'sort_order'=>4],
    ['name'=>'Dehydrated Products', 'slug'=>'dehydrated-products', 'sort_order'=>5],
];

foreach ($add as $row) {
    if (Category::where('slug', $row['slug'])->exists()) {
        echo "EXISTS: {$row['name']}<br>";
        continue;
    }
    Category::create([
        'name'       => $row['name'],
        'slug'       => $row['slug'],
        'status'     => true,
        'parent_id'  => null,
        'sort_order' => $row['sort_order'],
    ]);
    echo "ADDED: {$row['name']}<br>";
}

// Also fix Ceylon Coffee sort_order to 2 so it sits between Spices and Tea
Category::where('slug','ceylon-coffee')->whereNull('parent_id')->update(['sort_order'=>2]);
echo "UPDATED: Ceylon Coffee sort_order=2<br>";

echo "Done.";
