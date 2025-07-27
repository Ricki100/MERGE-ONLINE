<?php
// Create a new image with white background
$width = 400;
$height = 120;
$image = imagecreatetruecolor($width, $height);

// Define colors
$white = imagecolorallocate($image, 255, 255, 255);
$blue = imagecolorallocate($image, 37, 99, 235); // #2563eb
$darkBlue = imagecolorallocate($image, 29, 78, 216); // #1d4ed8

// Fill background with white
imagefill($image, 0, 0, $white);

// Function to draw a hexagon
function drawHexagon($image, $x, $y, $size, $color) {
    $points = array();
    for ($i = 0; $i < 6; $i++) {
        $angle = $i * 60 - 30;
        $rad = deg2rad($angle);
        $points[] = $x + $size * cos($rad);
        $points[] = $y + $size * sin($rad);
    }
    imagefilledpolygon($image, $points, 6, $color);
}

// Draw three stacked hexagons (layers)
// Bottom layer
drawHexagon($image, 80, 60, 25, $blue);
// Middle layer (slightly offset)
drawHexagon($image, 85, 55, 25, $blue);
// Top layer (more offset)
drawHexagon($image, 90, 50, 25, $blue);

// Add white outlines to create depth
drawHexagon($image, 80, 60, 25, $white);
drawHexagon($image, 85, 55, 25, $white);
drawHexagon($image, 90, 50, 25, $white);

// Redraw the blue hexagons slightly smaller
drawHexagon($image, 80, 60, 23, $blue);
drawHexagon($image, 85, 55, 23, $blue);
drawHexagon($image, 90, 50, 23, $blue);

// Add text "Font Merge"
$fontSize = 24;
$fontFile = __DIR__ . '/fonts/Arial.ttf';

// If Arial font is not available, use default
if (!file_exists($fontFile)) {
    // Use imagestring as fallback
    imagestring($image, 5, 150, 30, "Font", $blue);
    imagestring($image, 5, 150, 50, "Merge", $blue);
} else {
    // Use TrueType font
    imagettftext($image, $fontSize, 0, 150, 45, $blue, $fontFile, "Font");
    imagettftext($image, $fontSize, 0, 150, 75, $blue, $fontFile, "Merge");
}

// Output the image as PNG
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?> 