<?php
if(function_exists('opcache_reset')) opcache_reset();
$dirs = glob('/home/ceylonar/*/artisan') ?: glob('/home/*/artisan') ?: [];
if(!$dirs){ echo "artisan not found"; @unlink(__FILE__); exit; }
$artisan = $dirs[0];
$root = dirname($artisan);
chdir($root);
$out=[];
exec('php '.escapeshellarg($artisan).' view:clear 2>&1', $out);
exec('php '.escapeshellarg($artisan).' view:cache 2>&1', $out);
echo implode("\n",$out);
@unlink(__FILE__);
