<?php
session_start();

$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$randomString = substr(str_shuffle($characters), 0, 5);
$_SESSION['captcha'] = $randomString;

$width = 100;
$height = 60;

$image = imagecreatetruecolor($width, $height);

$bgColor = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $bgColor);

$textColor = imagecolorallocate($image, 0, 0, 0);

imagettftext($image, 20, 0, 10, 30, $textColor, '../font/samsungOne-400.ttf', $randomString);

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>
