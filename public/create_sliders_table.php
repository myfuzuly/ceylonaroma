<?php
/**
 * Ceylon Aroma — Create & seed sliders table
 * Run once via browser, then delete this file.
 */

// Block after first run
$lockFile = dirname(__DIR__) . '/ceylon_aroma/storage/app/.sliders_migrated';
if (file_exists($lockFile)) {
    http_response_code(404);
    die('Already run.');
}

require dirname(__DIR__) . '/ceylon_aroma/vendor/autoload.php';
$app = require dirname(__DIR__) . '/ceylon_aroma/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

$log = [];

// 1. Create table
if (!Schema::hasTable('sliders')) {
    Schema::create('sliders', function (Blueprint $table) {
        $table->id();
        $table->string('title', 200)->nullable();
        $table->string('subtitle', 300)->nullable();
        $table->string('image');
        $table->string('link', 500)->nullable();
        $table->unsignedTinyInteger('sort_order')->default(0);
        $table->boolean('status')->default(true);
        $table->timestamps();
    });
    $log[] = '✅ Table <strong>sliders</strong> created.';
} else {
    $log[] = 'ℹ️ Table <strong>sliders</strong> already exists — skipping create.';
}

// 2. Seed from existing files in storage/app/public/slider/
$sliderDir = storage_path('app/public/slider');
$existing  = DB::table('sliders')->count();

if ($existing === 0 && is_dir($sliderDir)) {
    $files = glob($sliderDir . '/*.{jpg,jpeg,png,webp,gif}', GLOB_BRACE);
    sort($files);
    $order = 0;
    foreach ($files as $file) {
        $filename = basename($file);
        // Derive a human title from filename
        $title = ucwords(str_replace(['-', '_'], ' ', pathinfo($filename, PATHINFO_FILENAME)));
        $title = preg_replace('/\s+\d+$/', '', $title); // strip trailing numbers

        DB::table('sliders')->insert([
            'title'      => $title ?: null,
            'subtitle'   => null,
            'image'      => 'slider/' . $filename,
            'link'       => null,
            'sort_order' => $order++,
            'status'     => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $log[] = "  → Seeded: <code>slider/{$filename}</code> (order {$order})";
    }
    $log[] = '✅ Seeded <strong>' . $order . '</strong> slide(s) from storage.';
} elseif ($existing > 0) {
    $log[] = "ℹ️ Table already has {$existing} row(s) — skipping seed.";
} else {
    $log[] = 'ℹ️ No files found in storage/app/public/slider/ — nothing seeded.';
}

// 3. Write lock file
file_put_contents($lockFile, date('Y-m-d H:i:s'));
$log[] = '🔒 Lock file written. This script will return 404 on next request.';

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sliders Migration</title>
<style>
body{font-family:monospace;background:#0e1117;color:#e2e8f0;padding:2rem;line-height:1.8}
h1{color:#C6862A;margin-bottom:1.5rem}
li{list-style:none;padding:.25rem 0}
code{background:#1e293b;padding:.1rem .4rem;border-radius:3px;font-size:.85em}
</style>
</head>
<body>
<h1>Ceylon Aroma — Sliders Migration</h1>
<ul>
<?php foreach ($log as $line) echo "<li>{$line}</li>\n"; ?>
</ul>
<p style="margin-top:2rem;color:#64748b">Done. You can now delete this file from the server.</p>
</body>
</html>
