<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/../ceylon_aroma/vendor/autoload.php';
$app = require_once __DIR__.'/../ceylon_aroma/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
header('Content-Type: text/plain');
\Illuminate\Support\Facades\Artisan::call('view:clear');
echo "view:clear OK\n";
if(function_exists('opcache_reset')) { opcache_reset(); echo "opcache OK\n"; }
\Illuminate\Support\Facades\Artisan::call('view:cache');
echo "view:cache OK\n";
@unlink(__FILE__);
echo "DONE\n";
