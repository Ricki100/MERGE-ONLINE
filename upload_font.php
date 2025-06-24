<?php
header('Content-Type: application/json');
$allowed = ['ttf', 'otf'];
$maxSize = 5 * 1024 * 1024; // 5MB
if (!isset($_FILES['font']) || $_FILES['font']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'No file uploaded.']);
    exit;
}
$file = $_FILES['font'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    echo json_encode(['success' => false, 'error' => 'Only .ttf and .otf files allowed.']);
    exit;
}
if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'error' => 'Font file too large (max 5MB).']);
    exit;
}
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);
$validMimes = [
    'font/ttf', 'application/x-font-ttf', 'application/octet-stream', 'font/otf', 'application/x-font-opentype',
    'application/font-sfnt', 'application/font-ttf', 'application/font-otf', 'application/vnd.ms-opentype',
    'application/x-font-truetype', 'application/x-font-otf', 'application/x-font-woff', 'application/x-font-woff2'
];
if (!in_array($mime, $validMimes)) {
    // Allow anyway if extension is correct, as some servers return generic octet-stream or unknown
    if ($ext !== 'ttf' && $ext !== 'otf') {
        echo json_encode(['success' => false, 'error' => 'Invalid font file.']);
        exit;
    }
}
$fontsDir = realpath(__DIR__ . '/../fonts');
if (!$fontsDir) $fontsDir = __DIR__ . '/../fonts';
$base = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
$target = $fontsDir . '/' . $base . '.' . $ext;
if (!move_uploaded_file($file['tmp_name'], $target)) {
    echo json_encode(['success' => false, 'error' => 'Failed to save font.']);
    exit;
}
echo json_encode(['success' => true]); 