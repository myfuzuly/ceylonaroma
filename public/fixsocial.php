<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/../ceylon_aroma/vendor/autoload.php';
$app = require_once __DIR__.'/../ceylon_aroma/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: text/plain');

$placeholders = ['http://www.facebook.com','https://www.facebook.com','http://facebook.com','https://facebook.com','#',''];
$keys = ['facebook_url','instagram_url','linkedin_url','youtube_url'];

foreach ($keys as $key) {
    $row = DB::table('settings')->where('key', $key)->first();
    $val = $row ? rtrim($row->value ?? '', '/') : null;
    if (!$val || in_array($val, $placeholders)) {
        DB::table('settings')->where('key', $key)->update(['value' => null]);
        echo "Cleared: $key\n";
    } else {
        echo "Kept: $key = $val\n";
    }
}

@unlink(__FILE__);
