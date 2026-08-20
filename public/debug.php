<?php
$appRoot = dirname(__DIR__) . '/ceylon_aroma';
echo '<pre style="font-family:monospace;font-size:.82rem;background:#0f172a;color:#94a3b8;padding:1.5rem;margin:0;min-height:100vh">';

// Latest log — last 80 lines
$logs = glob("$appRoot/storage/logs/*.log");
if ($logs) {
    $log   = end($logs);
    $lines = file($log);
    $tail  = array_slice($lines, -80);
    echo "=== " . basename($log) . " (last 80 lines) ===\n";
    echo htmlspecialchars(implode('', $tail));
} else {
    echo "No log files found\n";
}

// Check bootstrap/cache
echo "\n\n=== bootstrap/cache ===\n";
$bc = "$appRoot/bootstrap/cache";
$files = is_dir($bc) ? array_diff(scandir($bc), ['.','..']) : [];
echo $files ? implode(', ', $files) : '(empty)';

// Check key classes exist
echo "\n\n=== Key files ===\n";
$check = [
    'app/Http/Controllers/Controller.php',
    'app/Http/Middleware/AdminAuth.php',
    'app/Models/Product.php',
    'app/Providers/AppServiceProvider.php',
    'routes/web.php',
    'resources/views/home.blade.php',
    'resources/views/layouts/app.blade.php',
];
foreach ($check as $f) {
    echo (file_exists("$appRoot/$f") ? '✅' : '❌') . " $f\n";
}

echo '</pre>';
