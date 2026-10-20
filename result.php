<?php
header('Content-Type: image/jpeg');

if (isset($_GET['file'])) {
    $filename = $_GET['file'];
    $imagePath = "images/" . $filename . ".jpg";

    $img = imagecreatefromjpeg($imagePath);

    $font = realpath('font/Lato-Medium.ttf');  
    $color = imagecolorallocate($img, 255, 255, 255); 

    //gets text and sizes
    $text1 = isset($_GET['text1']) ? $_GET['text1'] : '';
    $text2 = isset($_GET['text2']) ? $_GET['text2'] : '';
    $size1 = isset($_GET['size1']) ? intval($_GET['size1']) : 24; // Default size
    $size2 = isset($_GET['size2']) ? intval($_GET['size2']) : 48; // Default size

    //adds text to image
    if (!empty($text1)) {
        imagettftext($img, $size1, 0, 10, 100, $color, $font, $text1);
    }
    if (!empty($text2)) {
        imagettftext($img, $size2, 0, 10, 900, $color, $font, $text2);
    }

    //gets width & sets default to 100
    $w = isset($_GET['width']) ? intval($_GET['width']) : 100;
    $newImg = imagescale($img, $w, $w);

    imagejpeg($newImg);
 }
?>