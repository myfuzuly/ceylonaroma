<?php
$dir = dirname(__DIR__) . '/ceylon_aroma/storage/framework/views';
$count = 0;
if (is_dir($dir)) {
    foreach (glob("$dir/*.php") as $f) { unlink($f); $count++; }
}
echo "Cleared $count compiled views. Done.";
