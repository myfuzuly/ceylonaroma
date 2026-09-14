<?php
/**
 * Ceylon Aroma — Commodity Prices migration + seed
 * Upload to server root and run once via browser, then delete.
 */

// ── DB connection (reads Laravel .env) ────────────────────────────
$envPath = __DIR__ . '/.env';
$env = [];
if (file_exists($envPath)) {
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $env[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
    }
}

$host   = $env['DB_HOST']     ?? '127.0.0.1';
$port   = $env['DB_PORT']     ?? '3306';
$dbname = $env['DB_DATABASE'] ?? '';
$user   = $env['DB_USERNAME'] ?? '';
$pass   = $env['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (Exception $e) {
    die('DB connect failed: ' . $e->getMessage());
}

$log = [];

// ── 1. Create table ───────────────────────────────────────────────
$pdo->exec("
CREATE TABLE IF NOT EXISTS commodity_prices (
    id           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    commodity    VARCHAR(120)    NOT NULL,
    grade        VARCHAR(120)    NOT NULL,
    price_lkr    DECIMAL(10,2)   NULL,
    price_usd    DECIMAL(10,4)   NULL,
    price_date   DATE            NOT NULL,
    sort_order   INT             NOT NULL DEFAULT 0,
    created_at   TIMESTAMP       NULL,
    updated_at   TIMESTAMP       NULL,
    UNIQUE KEY uq_commodity_grade_date (commodity, grade, price_date),
    INDEX idx_price_date (price_date),
    INDEX idx_sort_order (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
$log[] = '✅ Table commodity_prices created (or already exists)';

// ── 2. Seed initial data (today's date) ──────────────────────────
$today = date('Y-m-d');

$commodities = [
    // [commodity, grade, price_lkr, price_usd, sort_order]
    // ── Cinnamon ──────────────────────────────────────────────────
    ['Cinnamon', 'Alba',                         3100,  9.5,   10],
    ['Cinnamon', 'C5 Special',                   2650,  8.1,   20],
    ['Cinnamon', 'C5',                           2500,  7.6,   30],
    ['Cinnamon', 'M5 Special',                   2200,  6.7,   40],
    ['Cinnamon', 'M5',                           2050,  6.25,  50],
    ['Cinnamon', 'H1 Special',                   1850,  5.65,  60],
    ['Cinnamon', 'H1',                           1700,  5.2,   70],
    ['Cinnamon', 'Hamburg',                      1450,  4.4,   80],
    ['Cinnamon', 'Mexican',                      1250,  3.8,   90],
    ['Cinnamon', 'Quillings',                    1100,  3.35, 100],
    ['Cinnamon', 'Featherings',                   850,  2.6,  110],
    ['Cinnamon', 'Chips',                         750,  2.3,  120],
    ['Cinnamon', 'Dust',                          600,  1.85, 130],

    // ── Pepper ────────────────────────────────────────────────────
    ['Pepper', 'Black Pepper (Garbled)',         1650,  5.05, 210],
    ['Pepper', 'Black Pepper (Ungarbled)',       1450,  4.4,  220],
    ['Pepper', 'White Pepper',                   2800,  8.5,  230],
    ['Pepper', 'Green Pepper (Dried)',           1900,  5.8,  240],

    // ── Cloves ───────────────────────────────────────────────────
    ['Cloves', 'Clove Buds (Grade 1)',           4200, 12.8,  310],
    ['Cloves', 'Clove Buds (Grade 2)',           3800, 11.6,  320],
    ['Cloves', 'Clove Stems',                    1200,  3.65, 330],

    // ── Cardamom ──────────────────────────────────────────────────
    ['Cardamom', 'Green Cardamom (Extra Bold)',  9500, 29.0,  410],
    ['Cardamom', 'Green Cardamom (Bold)',        8800, 26.8,  420],
    ['Cardamom', 'Green Cardamom (Medium)',      7500, 22.9,  430],
    ['Cardamom', 'Bleached Cardamom',            7000, 21.3,  440],

    // ── Nutmeg & Mace ─────────────────────────────────────────────
    ['Nutmeg & Mace', 'Nutmeg (Sound)',          3200,  9.75, 510],
    ['Nutmeg & Mace', 'Nutmeg (BWP)',            2400,  7.3,  520],
    ['Nutmeg & Mace', 'Mace (1st Quality)',      5500, 16.75, 530],
    ['Nutmeg & Mace', 'Mace (2nd Quality)',      4500, 13.7,  540],

    // ── Turmeric ─────────────────────────────────────────────────
    ['Turmeric', 'Turmeric Fingers',              850,  2.6,  610],
    ['Turmeric', 'Turmeric Powder',               900,  2.75, 620],

    // ── Ginger ───────────────────────────────────────────────────
    ['Ginger', 'Dried Ginger',                   1100,  3.35, 710],
    ['Ginger', 'Ginger Powder',                  1250,  3.8,  720],

    // ── Tea ──────────────────────────────────────────────────────
    ['Tea', 'BOP (Broken Orange Pekoe)',          950,  2.9,  810],
    ['Tea', 'BOPF (Broken Orange Pekoe Fannings)', 900, 2.75, 820],
    ['Tea', 'OP (Orange Pekoe)',                 1050,  3.2,  830],
    ['Tea', 'OPA (Orange Pekoe A)',              1150,  3.5,  840],
    ['Tea', 'Dust No.1',                          800,  2.45, 850],
    ['Tea', 'PD (Pekoe Dust)',                    750,  2.3,  860],
    ['Tea', 'Green Tea (Special)',               1800,  5.5,  870],

    // ── Coffee ───────────────────────────────────────────────────
    ['Coffee', 'Arabica (Parchment)',            2200,  6.7,  910],
    ['Coffee', 'Arabica (Cherry)',               1800,  5.5,  920],
    ['Coffee', 'Robusta (Parchment)',            1600,  4.9,  930],
    ['Coffee', 'Roasted & Ground',               2800,  8.5,  940],

    // ── Coconut ──────────────────────────────────────────────────
    ['Coconut', 'Desiccated Coconut (Fine)',      650,  1.98, 1010],
    ['Coconut', 'Desiccated Coconut (Medium)',    620,  1.89, 1020],
    ['Coconut', 'Virgin Coconut Oil (VCO)',      1200,  3.65, 1030],
    ['Coconut', 'Coconut Oil (RBD)',              950,  2.9,  1040],
    ['Coconut', 'Coconut Cream (Canned)',         480,  1.46, 1050],
    ['Coconut', 'Coconut Milk Powder',            750,  2.3,  1060],
    ['Coconut', 'Copra',                          380,  1.16, 1070],

    // ── Essential Oils ────────────────────────────────────────────
    ['Essential Oils', 'Cinnamon Bark Oil',     85000, 259.0, 1110],
    ['Essential Oils', 'Cinnamon Leaf Oil',     18000,  54.9, 1120],
    ['Essential Oils', 'Clove Bud Oil',         22000,  67.1, 1130],
    ['Essential Oils', 'Nutmeg Oil',            28000,  85.4, 1140],
    ['Essential Oils', 'Cardamom Oil',          65000, 198.2, 1150],
    ['Essential Oils', 'Lemongrass Oil',         5500,  16.8, 1160],
    ['Essential Oils', 'Citronella Oil',         4200,  12.8, 1170],

    // ── Herbs ─────────────────────────────────────────────────────
    ['Herbs', 'Moringa Leaf Powder',             1400,  4.27, 1210],
    ['Herbs', 'Ashwagandha Root Powder',         3200,  9.75, 1220],
    ['Herbs', 'Turmeric Extract (95% Curcumin)', 9500, 28.97, 1230],
    ['Herbs', 'Gotukola (Dried)',                 650,  1.98, 1240],
    ['Herbs', 'Gotukola Powder',                  800,  2.44, 1250],

    // ── Rice ──────────────────────────────────────────────────────
    ['Rice', 'Samba (White)',                     185,  0.56, 1310],
    ['Rice', 'Basmati (Long Grain)',              320,  0.98, 1320],
    ['Rice', 'Red Rice (Kakuluhaal)',             240,  0.73, 1330],
    ['Rice', 'Black Rice',                        480,  1.46, 1340],
];

$stmt = $pdo->prepare("
    INSERT INTO commodity_prices (commodity, grade, price_lkr, price_usd, price_date, sort_order, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
    ON DUPLICATE KEY UPDATE price_lkr=VALUES(price_lkr), price_usd=VALUES(price_usd), sort_order=VALUES(sort_order), updated_at=NOW()
");

$inserted = 0;
foreach ($commodities as $row) {
    $stmt->execute([$row[0], $row[1], $row[2], $row[3], $today, $row[4]]);
    $inserted++;
}
$log[] = "✅ Seeded $inserted commodity rows for $today";

// ── 3. Done ───────────────────────────────────────────────────────
echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Migration</title>
<style>body{font-family:sans-serif;max-width:680px;margin:3rem auto;padding:0 1.5rem}
h2{color:#1A2A20}.ok{color:#16a34a}.err{color:#dc2626}</style></head><body>';
echo '<h2>Ceylon Aroma — Commodity Prices Migration</h2><ul>';
foreach ($log as $l) echo "<li class='ok'>$l</li>";
echo '</ul><p><strong>Done.</strong> Delete this file from the server immediately.</p></body></html>';
