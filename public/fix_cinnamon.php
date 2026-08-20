<?php
require dirname(__DIR__) . '/ceylon_aroma/vendor/autoload.php';
$app = require dirname(__DIR__) . '/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;

$rows = Category::where('slug','ceylon-cinnamon')->update(['parent_id' => null, 'sort_order' => 1]);
echo $rows ? "OK: Ceylon Cinnamon → main category, sort_order=1 (first)." : "NOT FOUND: ceylon-cinnamon";
