<?php
echo "__DIR__: " . __DIR__ . "\n";
echo "realpath: " . realpath(__DIR__) . "\n";
$appRoot = dirname(__DIR__) . '/ceylon_aroma';
echo "appRoot: $appRoot\n";
echo "appRoot realpath: " . realpath($appRoot) . "\n";
$pubRoot = __DIR__;
$css = "$pubRoot/build/assets/app-B4qLdKed.css";
echo "CSS path: $css\n";
echo "CSS exists: " . (file_exists($css) ? 'yes' : 'no') . "\n";
echo "CSS size: " . (file_exists($css) ? filesize($css) : 'N/A') . "\n";
// Also list build/assets
$dir = "$pubRoot/build/assets";
echo "build/assets contents:\n";
foreach (scandir($dir) as $f) {
    if ($f === '.' || $f === '..') continue;
    echo "  $f — " . filesize("$dir/$f") . " bytes\n";
}
