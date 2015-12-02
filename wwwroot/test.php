<?php

$image = new Imagick();
$draw = new ImagickDraw();

/* Make gradient */
$image->newPseudoImage(570, 80, 'gradient:red-black' );

/* White text */
$draw->setFillColor('white');

/* Font properties */
$draw->setFont('Candara');
$draw->setFontSize(50);

/* Create text */
$image->annotateImage($draw, 10, 45, 0, 'Do you believe in Magick?');

/* Set output format */
$image->setImageFormat('png');

/* Output the image with headers */
header('Content-type: image/png');
echo $image;

?>
