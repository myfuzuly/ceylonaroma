<?php
$appRoot = dirname(__DIR__) . '/ceylon_aroma';
$pubRoot = __DIR__;
echo '<pre style="font-family:monospace;font-size:.82rem;background:#0f172a;color:#94a3b8;padding:1.5rem;margin:0;min-height:100vh">';

// Check uploaded files exist and their sizes
$checks = [
    "$pubRoot/build/manifest.json"                   => 'manifest.json',
    "$pubRoot/build/assets/app-B4qLdKed.css"         => 'app-B4qLdKed.css (new)',
    "$pubRoot/build/assets/app-2rpYJR_A.css"         => 'app-2rpYJR_A.css (old)',
    "$appRoot/resources/views/layouts/app.blade.php" => 'app.blade.php',
    "$appRoot/resources/views/home.blade.php"        => 'home.blade.php',
];
echo "=== File sizes ===\n";
foreach ($checks as $path => $label) {
    if (file_exists($path)) {
        echo "✅ $label — " . number_format(filesize($path)) . " bytes\n";
    } else {
        echo "❌ $label — NOT FOUND\n";
    }
}

// Show what manifest says
echo "\n=== manifest.json ===\n";
echo file_get_contents("$pubRoot/build/manifest.json") . "\n";

// Clear compiled views
echo "\n=== Clearing views cache ===\n";
$viewsDir = "$appRoot/storage/framework/views";
$count = 0;
foreach (glob("$viewsDir/*.php") as $f) { unlink($f); $count++; }
echo "Deleted $count compiled view(s)\n";

echo "\n<a href='/' style='color:#c6862a'>→ Visit site</a>\n";
echo '</pre>';
