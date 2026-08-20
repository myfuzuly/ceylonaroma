<?php
$gz = __DIR__ . '/app-css9.css.gz';
$t  = dirname(__DIR__) . '/ceylon_aroma/resources/css/app-css9.css';
$c  = file_get_contents("compress.zlib://$gz");
file_put_contents($t, $c); unlink($gz);
echo 'OK: '.strlen($c).'B';
