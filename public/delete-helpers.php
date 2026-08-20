<?php
$dir = __DIR__;
$scripts = [
    'debug.php','migrate.php','uploader.php','update-settings.php',
    'setup.php','fix.php','cleanup.php','composer.php',
    'css_debug.php','pathcheck.php','viewclear.php',
];
foreach ($scripts as $f) {
    $path = $dir . '/' . $f;
    if (file_exists($path)) {
        unlink($path) ? print("Deleted: $f<br>") : print("Failed: $f<br>");
    } else {
        print("Already gone: $f<br>");
    }
}
unlink(__FILE__);
echo "Done. All helper scripts removed.";
