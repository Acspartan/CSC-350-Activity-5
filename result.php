<?php
include 'data.inc.php';

// Check if a painting was selected
if (!isset($_GET['file']) || $_GET['file'] === '') {
    http_response_code(400);
    exit("No painting selected.");
}

// Get filename from URL
$requestedFile = basename((string) $_GET['file']);

// Remove .jpg if it was included
$filename = pathinfo($requestedFile, PATHINFO_FILENAME);

// Validate against the supplied painting data
$validFiles = array_map(
    fn($painting) => pathinfo(
        $painting['filename'],
        PATHINFO_FILENAME
    ),
    $paintings
);

if (!in_array($filename, $validFiles, true)) {
    http_response_code(400);
    exit("Invalid painting selected.");
}

// Locate the image
$imagePath = __DIR__ . "/images/" . $filename . ".jpg";

if (!is_file($imagePath)) {
    http_response_code(404);
    exit("Painting image not found.");
}

// Load JPEG
$img = imagecreatefromjpeg($imagePath);

if ($img === false) {
    http_response_code(500);
    exit("Unable to load painting.");
}

// Read form inputs
$text1 = (string) ($_GET['text1'] ?? '');
$text2 = (string) ($_GET['text2'] ?? '');

$size1 = (int) ($_GET['size1'] ?? 24);
$size2 = (int) ($_GET['size2'] ?? 48);

$size1 = max(12, min(64, $size1));
$size2 = max(12, min(48, $size2));

// Font
$font = __DIR__ . "/font/Lato-Medium.ttf";

// Original dimensions
$imageWidth = imagesx($img);
$imageHeight = imagesy($img);

// Add text only if the font exists
if (is_file($font)) {
    $white = imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);

    // Center a caption horizontally
    $drawCaption = function ($text, $size, $y)
    use ($img, $font, $white, $black, $imageWidth) {

        if ($text === '') {
            return;
        }

        $bounds = imagettfbbox($size, 0, $font, $text);

        if ($bounds === false) {
            return;
        }

        $textWidth = $bounds[2] - $bounds[0];
        $x = max(10, (int) (($imageWidth - $textWidth) / 2));

        // Black shadow for readability
        imagettftext(
            $img, $size, 0,
            $x + 2, $y + 2,
            $black, $font, $text
        );

        // White caption
        imagettftext(
            $img, $size, 0,
            $x, $y,
            $white, $font, $text
        );
    };

    // Top caption
    $drawCaption($text1, $size1, $size1 + 25);

    // Bottom caption
    $drawCaption($text2, $size2, $imageHeight - 30);
}

// Resize only if width was supplied
if (isset($_GET['width'])) {
    $width = (int) $_GET['width'];
    $width = max(1, min(2000, $width));

    // Square image as required by assignment
    $newImg = imagescale($img, $width, $width);

    if ($newImg === false) {
        imagedestroy($img);
        http_response_code(500);
        exit("Unable to resize painting.");
    }

    imagedestroy($img);
    $img = $newImg;
}

// Send the image to the browser
header('Content-Type: image/jpeg');

imagejpeg($img, null, 90);
imagedestroy($img);
