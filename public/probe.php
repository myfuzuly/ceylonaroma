<?php
define('LARAVEL_START', microtime(true));
$base = dirname(__DIR__);
require $base.'/ceylon_aroma/vendor/autoload.php';
$app = require_once $base.'/ceylon_aroma/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\DB;
$cats = DB::table('categories')->select('id','name','slug')->orderBy('id')->get();
foreach ($cats as $c) echo "$c->id | $c->slug | $c->name\n";
echo "PRODUCTS: ".DB::table('products')->count()."\n";
