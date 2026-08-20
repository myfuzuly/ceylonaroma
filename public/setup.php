<?php
/**
 * Ceylon Aroma — One-click server setup script
 * DELETE THIS FILE after setup is complete!
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

$step = $_GET['step'] ?? 'check';
$appRoot = dirname(__DIR__) . '/ceylon_aroma';
$publicRoot = __DIR__;

function run($cmd) {
    ob_flush(); flush();
    $out = shell_exec($cmd . ' 2>&1');
    echo '<pre style="background:#111;color:#0f0;padding:.75rem;border-radius:4px;font-size:.8rem;overflow-x:auto">' . htmlspecialchars(trim($out ?: '(no output)')) . '</pre>';
    return $out;
}

function ok($msg) { echo '<p style="color:#22c55e">✅ '.$msg.'</p>'; }
function warn($msg) { echo '<p style="color:#f59e0b">⚠️ '.$msg.'</p>'; }
function err($msg)  { echo '<p style="color:#ef4444">❌ '.$msg.'</p>'; }
function heading($h) { echo '<h3 style="margin:1.5rem 0 .5rem;color:#e2e8f0">'.$h.'</h3>'; }

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Ceylon Aroma — Server Setup</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,sans-serif;background:#0f172a;color:#cbd5e1;padding:2rem;line-height:1.6}
.card{background:#1e293b;border-radius:12px;padding:2rem;max-width:800px;margin:0 auto}
h1{color:#c6862a;font-size:1.5rem;margin-bottom:1.5rem}
p{margin:.5rem 0}
a.btn{display:inline-block;background:#c6862a;color:#fff;padding:.6rem 1.5rem;border-radius:6px;text-decoration:none;margin:.25rem .25rem 0 0;font-weight:600}
a.btn:hover{background:#dfa84c}
.divider{border:none;border-top:1px solid rgba(255,255,255,.1);margin:1.5rem 0}
</style>
</head>
<body>
<div class="card">
<h1>Ceylon Aroma — Server Setup</h1>

<?php

// ── Step: EXTRACT ──────────────────────────────────────────────
if ($step === 'extract') {
    heading('Extracting ceylon_aroma.zip…');
    $zip = dirname(__DIR__) . '/ceylon_aroma.zip';
    if (!file_exists($zip)) {
        err('ceylon_aroma.zip not found at ' . $zip);
    } else {
        $z = new ZipArchive;
        if ($z->open($zip) === true) {
            $z->extractTo(dirname(__DIR__));
            $z->close();
            ok('Extracted to ' . dirname(__DIR__));
        } else {
            err('Failed to open ZIP');
        }
    }
    echo '<hr class="divider"><a class="btn" href="?step=composer">Next: Install Composer</a>';
}

// ── Step: COMPOSER ────────────────────────────────────────────
elseif ($step === 'composer') {
    heading('Downloading & running Composer…');
    if (!file_exists($appRoot)) {
        err('App root not found: ' . $appRoot . '. Run Extract step first.');
    } else {
        // Download composer
        if (!file_exists($appRoot . '/composer.phar')) {
            run("curl -sS https://getcomposer.org/installer | php -- --install-dir={$appRoot} --filename=composer.phar");
        }
        ok('Composer ready');
        heading('Installing dependencies (may take 2-3 minutes)…');
        run("cd {$appRoot} && php composer.phar install --no-dev --no-interaction --optimize-autoloader");
        ok('Dependencies installed');
    }
    echo '<hr class="divider"><a class="btn" href="?step=artisan">Next: Run Artisan Setup</a>';
}

// ── Step: ARTISAN ─────────────────────────────────────────────
elseif ($step === 'artisan') {
    heading('Running Laravel setup commands…');
    if (!file_exists($appRoot . '/vendor/autoload.php')) {
        err('vendor/ not found. Run Composer step first.');
    } else {
        heading('Generating APP_KEY…');
        run("cd {$appRoot} && php artisan key:generate --force");

        heading('Running migrations…');
        run("cd {$appRoot} && php artisan migrate --force");

        heading('Seeding database…');
        run("cd {$appRoot} && php artisan db:seed --force");

        heading('Clearing caches…');
        run("cd {$appRoot} && php artisan config:clear && php artisan route:clear && php artisan view:clear");

        heading('Setting permissions…');
        run("chmod -R 775 {$appRoot}/storage {$appRoot}/bootstrap/cache");
        ok('Storage writable');

        heading('Creating storage symlink…');
        $target = "{$publicRoot}/storage";
        if (!file_exists($target)) {
            symlink("{$appRoot}/storage/app/public", $target);
            ok("Symlink created: {$target} → {$appRoot}/storage/app/public");
        } else {
            warn("Storage symlink already exists");
        }
    }
    echo '<hr class="divider"><a class="btn" href="?step=done">Finish</a>';
}

// ── Step: DONE ────────────────────────────────────────────────
elseif ($step === 'done') {
    ok('Setup complete!');
    echo '<p style="margin-top:1rem">🚀 Your Ceylon Aroma site should now be live.</p>';
    echo '<p>🔑 Admin panel: <a href="/admin" style="color:#c6862a">/admin</a></p>';
    echo '<p style="color:#ef4444;margin-top:1rem"><strong>⚠️ IMPORTANT: Delete this setup.php file now!</strong></p>';
    echo '<p>Run: <code style="background:#0f172a;padding:.25rem .5rem;border-radius:4px">rm ' . __FILE__ . '</code></p>';
}

// ── Step: CHECK (default) ─────────────────────────────────────
else {
    heading('Environment Check');

    // PHP version
    $phpVer = PHP_VERSION;
    if (version_compare($phpVer, '8.2', '>=')) ok('PHP ' . $phpVer);
    else err('PHP ' . $phpVer . ' — requires 8.2+');

    // Extensions
    foreach (['pdo_mysql','mbstring','openssl','tokenizer','xml','ctype','json','fileinfo','gd'] as $ext) {
        if (extension_loaded($ext)) ok("Extension: {$ext}");
        else warn("Extension missing: {$ext}");
    }

    // ZIP
    if (class_exists('ZipArchive')) ok('ZipArchive available');
    else err('ZipArchive not available — cannot extract ZIP');

    // shell_exec
    if (function_exists('shell_exec')) ok('shell_exec available');
    else warn('shell_exec disabled — Composer step may fail. Use SSH instead.');

    // App root
    echo '<hr class="divider">';
    heading('Paths');
    echo '<p>App root: <code>' . $appRoot . '</code></p>';
    echo '<p>Public root: <code>' . $publicRoot . '</code></p>';
    $zipExists = file_exists(dirname(__DIR__) . '/ceylon_aroma.zip');
    if ($zipExists) ok('ceylon_aroma.zip found');
    else warn('ceylon_aroma.zip not found — upload it to ' . dirname(__DIR__));

    echo '<hr class="divider">';
    heading('Run Setup Steps');
    echo '<a class="btn" href="?step=extract">1. Extract ZIP</a>';
    echo '<a class="btn" href="?step=composer">2. Install Composer</a>';
    echo '<a class="btn" href="?step=artisan">3. Run Artisan Setup</a>';
    echo '<a class="btn" href="?step=done">4. Done</a>';
}
?>

</div>
</body>
</html>
