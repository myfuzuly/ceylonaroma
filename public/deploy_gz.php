<?php
// Deploy compressed blade files — run once, then delete
$base = dirname(__DIR__);

$jobs = [
    __DIR__ . '/home_p1.blade.php.gz' => $base . '/ceylon_aroma/resources/views/home-p1.blade.php',
];

foreach ($jobs as $gz => $target) {
    if (!file_exists($gz)) { echo "MISSING gz: $gz<br>"; continue; }
    $content = file_get_contents("compress.zlib://$gz");
    if ($content === false) { echo "FAIL decompress: $gz<br>"; continue; }
    if (file_put_contents($target, $content) === false) {
        echo "FAIL write: $target<br>";
    } else {
        echo "OK: wrote " . strlen($content) . " bytes → " . basename($target) . "<br>";
        unlink($gz); // clean up gz
    }
}
echo "Done. Delete this file.";
