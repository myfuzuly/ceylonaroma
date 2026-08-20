<?php
set_time_limit(180);
$appRoot = dirname(__DIR__) . '/ceylon_aroma';
$php     = '/usr/local/bin/php';
$artisan = "$appRoot/artisan";
$home    = "$appRoot/composer_home";
$env     = "COMPOSER_HOME=$home HOME=$home";

echo '<pre style="font-family:monospace;font-size:.82rem;background:#0f172a;color:#94a3b8;padding:1.5rem;margin:0;min-height:100vh">';

function run($label, $cmd) {
    echo "\n=== $label ===\n";
    exec($cmd . ' 2>&1', $out, $code);
    echo htmlspecialchars(implode("\n", $out));
    echo "\n(exit: $code)\n";
    return $code;
}

// Verify artisan exists
echo "artisan: " . (file_exists($artisan) ? "✅ found\n" : "❌ MISSING\n");
echo "php bin: " . (is_executable($php) ? "✅ $php\n" : "❌ not executable, trying fallback\n");

if (!is_executable($php)) $php = PHP_BINARY;

$base = "cd " . escapeshellarg($appRoot) . " && $env $php " . escapeshellarg($artisan);

run('migrate --force', "$base migrate --force");
run('db:seed --force', "$base db:seed --force");
run('config:clear',   "$base config:clear");
run('view:clear',     "$base view:clear");

echo "\n<a href='/' style='color:#c6862a'>→ Visit site</a>  ";
echo "<a href='/admin' style='color:#5D8A6C'>→ Admin panel</a>\n";
echo '</pre>';
