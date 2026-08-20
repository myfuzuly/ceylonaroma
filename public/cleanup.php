<?php
function rrmdir($dir) {
    if (!is_dir($dir)) return;
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) rrmdir($path);
        else unlink($path);
    }
    rmdir($dir);
}
$target = __DIR__ . '/C:';
if (is_dir($target)) {
    rrmdir($target);
    echo "Deleted C: directory tree.";
} else {
    echo "C: directory not found (already clean).";
}
