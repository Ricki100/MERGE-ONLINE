<?php
session_start();
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// Suppress warnings in production
error_reporting(E_ERROR | E_PARSE);

if (!isset($_FILES['template']) || !isset($_POST['csv_data']) || !isset($_POST['boxes'])) {
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

try {
    $timestamp = time();
    $uploadsDir = '../uploads';
    if (!file_exists($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }

    // Save template image
    $templateFile = $_FILES['template'];
    $templatePath = $uploadsDir . '/template_' . $timestamp . '_' . basename($templateFile['name']);
    move_uploaded_file($templateFile['tmp_name'], $templatePath);

    // Get CSV data and boxes
    $csvData = json_decode($_POST['csv_data'], true);
    $boxes = json_decode($_POST['boxes'], true);

    // Create previews directory
    $previewsDir = '../uploads/previews_' . $timestamp;
    mkdir($previewsDir, 0777, true);

    // Load template image
    $template = imagecreatefromstring(file_get_contents($templatePath));
    if (!$template) {
        throw new Exception('Could not load template image');
    }

    // Generate previews
    $previewUrls = [];
    $maxPreviews = min(count($csvData), 10); // Limit to 10 previews

    for ($i = 0; $i < $maxPreviews; $i++) {
        $row = $csvData[$i];
        
        // Create a copy of the template
        $image = imagecreatetruecolor(imagesx($template), imagesy($template));
        imagecopy($image, $template, 0, 0, 0, 0, imagesx($template), imagesy($template));

        // Process each box
        foreach ($boxes as $box) {
            $column = $box['column'];
            if (!isset($row[$column])) continue;
            $x = (int) round($box['x']);
            $y = (int) round($box['y']);
            $width = (int) round($box['width']);
            $height = (int) round($box['height']);
            $fontSize = (int) round($box['fontSize']);
            if ($box['type'] === 'text') {
                $text = $row[$column];
                // Font style selection
                $fontBase = strtolower(str_replace(' ', '', $box['fontFamily']));
                $fontFile = 'fonts/' . $fontBase . '.ttf';
                if (!empty($box['bold']) && !empty($box['italic'])) {
                    $fontFile = 'fonts/' . $fontBase . 'bolditalic.ttf';
                } elseif (!empty($box['bold'])) {
                    $fontFile = 'fonts/' . $fontBase . 'bold.ttf';
                } elseif (!empty($box['italic'])) {
                    $fontFile = 'fonts/' . $fontBase . 'italic.ttf';
                }
                if (!file_exists($fontFile)) {
                    echo json_encode(['error' => 'Font file not found: ' . $fontFile]);
                    exit;
                }
                $color = hex2rgb($box['color']);
                $textColor = imagecolorallocate($image, $color['r'], $color['g'], $color['b']);
                // Word wrap
                $lines = wrapText($text, $fontFile, $fontSize, $width);
                $lineHeight = $fontSize * 1.2;
                $yy = $y;
                foreach ($lines as $line) {
                    $bbox = imagettfbbox($fontSize, 0, $fontFile, $line);
                    $textHeight = abs($bbox[7] - $bbox[1]);
                    $textWidth = $bbox[2] - $bbox[0];
                    $xx = $x;
                    if ($box['align'] === 'center') {
                        $xx += ($width - $textWidth) / 2;
                    } elseif ($box['align'] === 'right') {
                        $xx += $width - $textWidth;
                    }
                    // Align to top of box
                    $baselineY = $yy + $textHeight;
                    imagettftext(
                        $image,
                        $fontSize,
                        0,
                        $xx,
                        $baselineY,
                        $textColor,
                        $fontFile,
                        $line
                    );
                    // Underline
                    if (!empty($box['underline'])) {
                        $underlineY = $baselineY + 2;
                        imageline($image, $xx, $underlineY, $xx + $textWidth, $underlineY, $textColor);
                    }
                    $yy += $lineHeight;
                }
                // Optionally, draw debug rectangle for the box
                // $rectColor = imagecolorallocatealpha($image, 255, 0, 0, 80);
                // imagerectangle($image, $x, $y, $x + $width, $y + $height, $rectColor);
            } else {
                // Handle image box
                $imageUrl = $row[$column];
                if (empty($imageUrl)) continue;

                // Load overlay image
                $overlay = imagecreatefromstring(file_get_contents($imageUrl));
                if (!$overlay) continue;

                // Resize overlay to fit box
                $overlayWidth = imagesx($overlay);
                $overlayHeight = imagesy($overlay);
                $scale = min($width / $overlayWidth, $height / $overlayHeight);
                $newWidth = (int) round($overlayWidth * $scale);
                $newHeight = (int) round($overlayHeight * $scale);

                $resizedOverlay = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled(
                    $resizedOverlay,
                    $overlay,
                    0, 0, 0, 0,
                    $newWidth, $newHeight,
                    $overlayWidth, $overlayHeight
                );

                // Copy overlay to main image
                imagecopy(
                    $image,
                    $resizedOverlay,
                    $x,
                    $y,
                    0, 0,
                    $newWidth,
                    $newHeight
                );

                imagedestroy($overlay);
                imagedestroy($resizedOverlay);
            }
        }

        // Save preview
        $previewPath = $previewsDir . '/preview_' . $i . '.jpg';
        imagejpeg($image, $previewPath, 85); // Save as high-quality JPEG
        imagedestroy($image);

        // Add URL to list
        $previewUrls[] = 'uploads/previews_' . $timestamp . '/preview_' . $i . '.jpg';
    }

    // Clean up template
    imagedestroy($template);
    unlink($templatePath);

    // Store preview directory in session
    $_SESSION['preview_dir'] = $previewsDir;

    echo json_encode([
        'preview_urls' => $previewUrls,
        'message' => 'Generated ' . count($previewUrls) . ' preview images'
    ]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

// Helper function to convert hex color to RGB
function hex2rgb($hex) {
    $hex = ltrim($hex, '#');
    return [
        'r' => hexdec(substr($hex, 0, 2)),
        'g' => hexdec(substr($hex, 2, 2)),
        'b' => hexdec(substr($hex, 4, 2))
    ];
}

// Word wrap helper
function wrapText($text, $fontFile, $fontSize, $maxWidth) {
    $words = explode(' ', $text);
    $lines = [];
    $currentLine = '';
    foreach ($words as $word) {
        $testLine = $currentLine ? $currentLine . ' ' . $word : $word;
        $bbox = imagettfbbox($fontSize, 0, $fontFile, $testLine);
        $lineWidth = $bbox[2] - $bbox[0];
        if ($lineWidth > $maxWidth && $currentLine) {
            $lines[] = $currentLine;
            $currentLine = $word;
        } else {
            $currentLine = $testLine;
        }
    }
    if ($currentLine) {
        $lines[] = $currentLine;
    }
    return $lines;
} 