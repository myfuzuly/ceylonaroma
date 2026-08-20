<?php
set_time_limit(300);
error_reporting(E_ALL);
ini_set('display_errors', 1);

$appRoot  = dirname(__DIR__) . '/ceylon_aroma';
$pubRoot  = __DIR__;
$step     = $_GET['step'] ?? 'check';

// Prefer CLI php over CGI
function phpBin() {
    $candidates = ['/usr/local/bin/php', '/usr/bin/php', PHP_BINARY];
    foreach ($candidates as $c) {
        if (is_executable($c) && strpos($c, 'cgi') === false) return $c;
    }
    return PHP_BINARY; // fallback to whatever PHP we have
}

function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES); }

function runCmd($cmd, &$out = '') {
    $result = '';
    if (function_exists('exec')) {
        exec($cmd . ' 2>&1', $lines, $code);
        $result = implode("\n", $lines);
    } elseif (function_exists('shell_exec')) {
        $result = shell_exec($cmd . ' 2>&1') ?? '';
        $code = 0;
    } elseif (function_exists('proc_open')) {
        $desc = [['pipe','r'],['pipe','w'],['pipe','w']];
        $proc = proc_open($cmd, $desc, $pipes);
        fclose($pipes[0]);
        $result = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
        fclose($pipes[1]); fclose($pipes[2]);
        $code = proc_close($proc);
    } else {
        $result = 'No exec function available';
        $code   = -1;
    }
    $out = $result;
    return $code ?? 0;
}

function box($title, $content, $ok = true) {
    $c = $ok ? '#22c55e' : '#f87171';
    echo "<div style='margin:.75rem 0;border:1px solid rgba(255,255,255,.1);border-radius:8px;overflow:hidden'>";
    echo "<div style='background:rgba(255,255,255,.06);padding:.5rem 1rem;font-weight:600;font-size:.82rem;color:$c'>$title</div>";
    echo "<pre style='margin:0;padding:.75rem 1rem;font-size:.77rem;line-height:1.5;overflow-x:auto;white-space:pre-wrap;word-break:break-all;background:#0f172a;color:#94a3b8'>" . h($content) . "</pre>";
    echo "</div>";
}

function ok($m)   { echo "<p class='ok'>✅ $m</p>"; }
function warn($m) { echo "<p class='warn'>⚠️ $m</p>"; }
function fail($m) { echo "<p class='err'>❌ $m</p>"; }
function hd($t)   { echo "<h3>$t</h3>"; }

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Ceylon Aroma — Installer</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:system-ui,sans-serif;background:#0f172a;color:#cbd5e1;padding:1.5rem;line-height:1.6}
.card{background:#1e293b;border-radius:12px;padding:1.75rem;max-width:900px;margin:0 auto}
h1{color:#c6862a;font-size:1.25rem;margin-bottom:1.5rem}
h3{color:#e2e8f0;font-size:.82rem;margin:1.25rem 0 .5rem;text-transform:uppercase;letter-spacing:.06em;border-bottom:1px solid rgba(255,255,255,.08);padding-bottom:.35rem}
a.btn{display:inline-block;padding:.55rem 1.1rem;border-radius:6px;text-decoration:none;font-weight:600;font-size:.82rem;margin:.2rem .2rem 0 0;color:#fff}
.btn-gold{background:#c6862a}.btn-blue{background:#3b82f6}.btn-green{background:#16a34a}.btn-red{background:#dc2626}.btn-purple{background:#7c3aed}
p{margin:.4rem 0;font-size:.855rem}
.ok{color:#22c55e}.warn{color:#f59e0b}.err{color:#f87171}
hr{border:none;border-top:1px solid rgba(255,255,255,.08);margin:1.25rem 0}
code{background:#0f172a;padding:.1rem .35rem;border-radius:3px;font-size:.8rem}
</style>
</head>
<body>
<div class="card">
<h1>Ceylon Aroma — Installer</h1>

<?php

/* ── DIAGNOSTICS ─────────────────────────────────────────────── */
if ($step === 'check') {
    hd('Environment');
    echo "<p class='" . (is_dir($appRoot) ? 'ok' : 'err') . "'>" . (is_dir($appRoot) ? '✅' : '❌') . " App root: <code>$appRoot</code></p>";
    echo "<p class='" . (file_exists("$appRoot/composer.json") ? 'ok' : 'err') . "'>" . (file_exists("$appRoot/composer.json") ? '✅' : '❌') . " composer.json</p>";
    echo "<p class='" . (is_dir("$appRoot/vendor") ? 'ok' : 'warn') . "'>" . (is_dir("$appRoot/vendor") ? '✅' : '⚠️') . " vendor/ " . (is_dir("$appRoot/vendor") ? 'present' : 'missing') . "</p>";
    echo "<p class='" . (is_dir("$appRoot/storage") ? 'ok' : 'warn') . "'>" . (is_dir("$appRoot/storage") ? '✅' : '⚠️') . " storage/ " . (is_dir("$appRoot/storage") ? 'present' : 'missing (will be created)') . "</p>";
    echo "<p>✅ PHP " . PHP_VERSION . " | CLI bin: <code>" . h(phpBin()) . "</code></p>";
    $zipFile = dirname(__DIR__) . '/ceylon_aroma.zip';
    echo "<p class='" . (file_exists($zipFile) ? 'ok' : 'warn') . "'>" . (file_exists($zipFile) ? '✅' : '⚠️') . " ceylon_aroma.zip " . (file_exists($zipFile) ? round(filesize($zipFile)/1024) . ' KB' : 'not found') . "</p>";
    if (is_dir($appRoot)) {
        $items = array_diff(scandir($appRoot), ['.','..']);
        box('App root contents', implode('   ', $items));
    }
}

/* ── DOWNLOAD COMPOSER ───────────────────────────────────────── */
if ($step === 'download') {
    hd('Downloading composer.phar');
    $pharDest = "$appRoot/composer.phar";
    if (file_exists($pharDest)) {
        ok('composer.phar already exists (' . round(filesize($pharDest)/1024) . ' KB)');
    } else {
        $downloaded = false;
        if (function_exists('curl_init')) {
            $ch = curl_init('https://getcomposer.org/composer-stable.phar');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_TIMEOUT => 120,
                CURLOPT_USERAGENT => 'PHP',
            ]);
            $data = curl_exec($ch);
            $err  = curl_error($ch);
            curl_close($ch);
            if ($data && strlen($data) > 10000) {
                file_put_contents($pharDest, $data);
                ok('Downloaded via curl (' . round(strlen($data)/1024) . ' KB)');
                $downloaded = true;
            } else {
                fail("curl download failed: $err");
            }
        }
        if (!$downloaded && ini_get('allow_url_fopen')) {
            $ctx  = stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]);
            $data = @file_get_contents('https://getcomposer.org/composer-stable.phar', false, $ctx);
            if ($data && strlen($data) > 10000) {
                file_put_contents($pharDest, $data);
                ok('Downloaded via file_get_contents (' . round(strlen($data)/1024) . ' KB)');
                $downloaded = true;
            } else {
                fail('file_get_contents also failed');
            }
        }
        if (!$downloaded) {
            fail('Could not download composer.phar. Upload it manually to: ' . h($pharDest));
        }
    }
}

/* ── INSTALL PACKAGES ────────────────────────────────────────── */
if ($step === 'install') {
    hd('Running composer install');
    $pharPath = "$appRoot/composer.phar";
    $php      = phpBin();

    if (!file_exists($pharPath)) {
        fail('composer.phar not found — run Download Composer first');
    } else {
        // COMPOSER_HOME must be set when running from a web process (no $HOME)
        $composerHome = "$appRoot/composer_home";
        if (!is_dir($composerHome)) mkdir($composerHome, 0775, true);
        $env  = "COMPOSER_HOME=" . escapeshellarg($composerHome) . " HOME=" . escapeshellarg($composerHome);
        $cmd  = "cd " . escapeshellarg($appRoot) . " && $env $php composer.phar install --no-dev --no-interaction --optimize-autoloader --no-scripts --no-security-blocking 2>&1";
        echo "<p>Running: <code>" . h($cmd) . "</code></p>";
        flush(); ob_flush();
        $code = runCmd($cmd, $out);
        box("Output (exit: $code)", $out ?: '(empty)', $code === 0);

        if (is_dir("$appRoot/vendor")) ok('vendor/ created ✨');
        else fail('vendor/ still missing after install');
    }
}

/* ── CREATE STORAGE DIRS ─────────────────────────────────────── */
if ($step === 'storage' || $step === 'artisan') {
    hd('Creating storage directories');
    $dirs = [
        "$appRoot/storage",
        "$appRoot/storage/app",
        "$appRoot/storage/app/public",
        "$appRoot/storage/framework",
        "$appRoot/storage/framework/cache",
        "$appRoot/storage/framework/cache/data",
        "$appRoot/storage/framework/sessions",
        "$appRoot/storage/framework/testing",
        "$appRoot/storage/framework/views",
        "$appRoot/storage/logs",
        "$appRoot/bootstrap/cache",
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
            ok('Created: ' . str_replace($appRoot, '', $dir));
        } else {
            echo "<p style='color:#64748b'>✓ Exists: " . str_replace($appRoot, '', $dir) . "</p>";
        }
        @chmod($dir, 0775);
    }
    // .gitkeep in logs
    if (!file_exists("$appRoot/storage/logs/.gitkeep")) {
        file_put_contents("$appRoot/storage/logs/.gitkeep", '');
    }
}

/* ── ARTISAN ─────────────────────────────────────────────────── */
if ($step === 'artisan') {
    $php  = phpBin();
    $home = "$appRoot/composer_home";
    if (!is_dir($home)) mkdir($home, 0775, true);
    $env  = "COMPOSER_HOME=" . escapeshellarg($home) . " HOME=" . escapeshellarg($home);

    if (!is_dir("$appRoot/vendor")) {
        hd('Artisan Setup');
        fail('vendor/ not found — run Install Packages first');
    } else {
        hd('Generating APP_KEY');
        $code = runCmd("cd " . escapeshellarg($appRoot) . " && $env $php artisan key:generate --force", $out);
        box("key:generate (exit: $code)", $out, $code === 0);

        hd('Running Migrations');
        $code = runCmd("cd " . escapeshellarg($appRoot) . " && $env $php artisan migrate --force", $out);
        box("migrate (exit: $code)", $out, $code === 0);

        if ($code === 0) {
            hd('Seeding Database');
            $code = runCmd("cd " . escapeshellarg($appRoot) . " && $env $php artisan db:seed --force", $out);
            box("db:seed (exit: $code)", $out, $code === 0);
        }

        hd('Cache Clear');
        runCmd("cd " . escapeshellarg($appRoot) . " && $env $php artisan config:clear && $env $php artisan view:clear && $env $php artisan route:clear", $out);
        echo "<p>$out</p>";

        hd('Storage Symlink');
        $link = "$pubRoot/storage";
        $target = "$appRoot/storage/app/public";
        if (is_link($link)) {
            ok('Symlink already exists: ' . h($link));
        } elseif (file_exists($link)) {
            warn('Something already exists at ' . h($link) . ' — skipping symlink');
        } else {
            $ok = @symlink($target, $link);
            if ($ok) ok('Symlink created: public_html/storage → storage/app/public');
            else {
                fail('symlink() failed — trying artisan storage:link');
                $code = runCmd("cd " . escapeshellarg($appRoot) . " && $php artisan storage:link 2>&1", $out);
                box("storage:link (exit: $code)", $out, $code === 0);
            }
        }

        hd('Done');
        ok('<strong>Setup complete!</strong>');
        echo "<p>🌐 Visit: <a href='/' style='color:#c6862a'>http://procare.lk</a></p>";
        echo "<p>🔑 Admin: <a href='/admin' style='color:#c6862a'>http://procare.lk/admin</a></p>";
        echo "<p class='warn'>⚠️ Delete this file when done!</p>";
    }
}

/* ── DELETE ──────────────────────────────────────────────────── */
if ($step === 'delete') {
    @unlink(__FILE__);
    @unlink(dirname(__DIR__) . '/public_html/setup.php');
    ok('Files deleted. You\'re all set!');
}

?>

<hr>
<p style="font-size:.8rem;color:#475569;margin-bottom:.75rem">Run steps in order:</p>
<a class="btn btn-blue" href="?step=check">🔍 Diagnostics</a>
<a class="btn btn-gold" href="?step=download">⬇️ 1. Download Composer</a>
<a class="btn btn-gold" href="?step=install">📦 2. Install Packages</a>
<a class="btn btn-green" href="?step=artisan">⚡ 3. Artisan Setup</a>
<hr>
<a class="btn btn-red" href="?step=delete" onclick="return confirm('Delete installer files?')">🗑️ Delete This File</a>

</div>
</body>
</html>
