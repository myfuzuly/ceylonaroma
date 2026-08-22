<?php
$BASE = '/home/ceylonar/ceylon_aroma';
$out = [];
exec("cd $BASE && php artisan view:clear 2>&1", $out);
if (function_exists('opcache_reset')) { opcache_reset(); $out[] = "opcache_reset: ok"; }
exec("cd $BASE && php artisan view:cache 2>&1", $out);
header('Content-Type: text/plain');
echo implode("\n", $out) . "\n";
@unlink(__FILE__);
