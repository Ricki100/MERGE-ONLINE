<?php
header('Content-Type: application/json');
$fontsDir = realpath(__DIR__ . '/../fonts');
$fonts = [];
if (is_dir($fontsDir)) {
    foreach (glob($fontsDir . '/*.ttf') as $file) {
        $base = basename($file, '.ttf');
        $fonts[] = $base;
    }
}
echo json_encode($fonts); 