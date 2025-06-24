<?php
session_start();

if (!isset($_SESSION['preview_dir']) || !file_exists($_SESSION['preview_dir'])) {
    die('No previews available for download');
}

$previewDir = $_SESSION['preview_dir'];
$zipFile = $previewDir . '.zip';

// Create zip file
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
    die('Could not create zip file');
}

// Add all preview images to zip
$files = glob($previewDir . '/*.jpg');
foreach ($files as $file) {
    $zip->addFile($file, basename($file));
}
$zip->close();

// Set headers for download
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="previews.zip"');
header('Content-Length: ' . filesize($zipFile));

// Output zip file
readfile($zipFile);

// Clean up
unlink($zipFile);
array_map('unlink', glob($previewDir . '/*.jpg'));
rmdir($previewDir);
unset($_SESSION['preview_dir']); 