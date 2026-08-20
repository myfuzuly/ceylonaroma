<?php
/* Add pricing & inventory to products, add price to order_items — DELETE after use */
require dirname(__DIR__) . '/ceylon_aroma/vendor/autoload.php';
$app = require dirname(__DIR__) . '/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

// Products: pricing & inventory columns
Schema::table('products', function (Blueprint $t) {
    if (!Schema::hasColumn('products','price'))              $t->decimal('price',10,2)->nullable()->after('description');
    if (!Schema::hasColumn('products','price_unit'))         $t->string('price_unit',30)->default('kg')->after('price');
    if (!Schema::hasColumn('products','currency'))           $t->string('currency',5)->default('USD')->after('price_unit');
    if (!Schema::hasColumn('products','min_order_qty'))      $t->decimal('min_order_qty',10,2)->nullable()->after('currency');
    if (!Schema::hasColumn('products','min_order_unit'))     $t->string('min_order_unit',30)->default('kg')->after('min_order_qty');
    if (!Schema::hasColumn('products','stock_qty'))          $t->integer('stock_qty')->nullable()->after('min_order_unit');
    if (!Schema::hasColumn('products','low_stock_threshold'))$t->integer('low_stock_threshold')->default(10)->after('stock_qty');
    if (!Schema::hasColumn('products','in_stock'))           $t->boolean('in_stock')->default(true)->after('low_stock_threshold');
    if (!Schema::hasColumn('products','sku'))                $t->string('sku',60)->nullable()->after('slug');
    if (!Schema::hasColumn('products','weight_per_unit'))    $t->decimal('weight_per_unit',8,2)->nullable()->after('min_order_unit');
    if (!Schema::hasColumn('products','origin'))             $t->string('origin',100)->default('Sri Lanka')->after('weight_per_unit');
    if (!Schema::hasColumn('products','certifications'))     $t->string('certifications',255)->nullable()->after('origin');
    if (!Schema::hasColumn('products','shelf_life'))         $t->string('shelf_life',100)->nullable()->after('certifications');
});
echo "DONE: products pricing columns<br>";

// order_items: add price columns
Schema::table('order_items', function (Blueprint $t) {
    if (!Schema::hasColumn('order_items','unit_price'))      $t->decimal('unit_price',10,2)->nullable()->after('quantity');
    if (!Schema::hasColumn('order_items','currency'))        $t->string('currency',5)->default('USD')->after('unit_price');
    if (!Schema::hasColumn('order_items','line_total'))      $t->decimal('line_total',12,2)->nullable()->after('currency');
});
echo "DONE: order_items price columns<br>";

echo "<br><strong>All done.</strong>";
