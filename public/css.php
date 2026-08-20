<?php
header('Content-Type: text/css; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('X-CSS-Version: 10');
$base = dirname(__DIR__) . '/ceylon_aroma/resources/css/';
foreach (['app-css1.css', 'app-css2.css', 'app-css3.css', 'app-css4.css', 'app-css5.css', 'app-css6.css', 'app-css7.css', 'app-css8.css', 'app-css9.css', 'app-css10.css'] as $f) {
    if (file_exists($base . $f)) readfile($base . $f);
    else echo "/* missing: $f */\n";
}
