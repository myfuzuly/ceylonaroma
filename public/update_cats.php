<?php
define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__);
require $base.'/ceylon_aroma/vendor/autoload.php';
$app = require_once $base.'/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;

// ── Update existing categories ──────────────────────────────
$updates = [
    'ceylon-spices'      => ['name'=>'Ceylon Spices',       'sort_order'=>4],
    'ceylon-coffee'      => ['name'=>'Ceylon Coffee',       'sort_order'=>2],
    'ceylon-tea'         => ['name'=>'Ceylon Tea',          'sort_order'=>3],
    'aromatic-oils'      => ['name'=>'Aromatic Oils',       'sort_order'=>6],
    'frozen-pulp'        => ['name'=>'Pulp',  'slug'=>'pulp','sort_order'=>5],
    'dehydrated-products'=> ['name'=>'Dehydrated Products', 'sort_order'=>9],
    'nuts-natural-foods' => ['name'=>'Dates & Nuts','slug'=>'dates-nuts','sort_order'=>10],
];

foreach ($updates as $slug => $data) {
    $rows = DB::table('categories')->where('slug', $slug)->update(array_merge(['updated_at'=>now()], $data));
    echo ($rows ? "UPDATED" : "SKIP")." : $slug → {$data['name']}\n";
}

// ── Add new categories ──────────────────────────────────────
$newCats = [
    ['name'=>'Ceylon Cinnamon',       'slug'=>'ceylon-cinnamon',       'description'=>'Premium Ceylon cinnamon in all grades and formats — Alba, C5, C4, M5, H1/H2, quills, powder and bulk export.', 'sort_order'=>1],
    ['name'=>'Ayurvedic Products',    'slug'=>'ayurvedic-products',    'description'=>'Traditional Sri Lankan Ayurvedic products — herbal powders, remedies, wellness oils and balms.', 'sort_order'=>7],
    ['name'=>'Lifestyle & Natural Care','slug'=>'lifestyle-natural-care','description'=>'Natural lifestyle products — fragrance sachets, herbal soaps, natural candles and spa & wellness products.', 'sort_order'=>8],
];

foreach ($newCats as $cat) {
    if (DB::table('categories')->where('slug', $cat['slug'])->exists()) {
        echo "SKIP (exists): {$cat['name']}\n";
        continue;
    }
    DB::table('categories')->insert(array_merge($cat, ['status'=>1,'created_at'=>now(),'updated_at'=>now()]));
    echo "ADDED: {$cat['name']}\n";
}

echo "\n=== Final category list ===\n";
foreach (DB::table('categories')->orderBy('sort_order')->get() as $c)
    echo "$c->sort_order. [$c->id] $c->slug — $c->name\n";
