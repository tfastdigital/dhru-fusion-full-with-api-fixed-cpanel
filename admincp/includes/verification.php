<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

session_name("DHRUFUSION");
session_set_cookie_params(0, "/", NULL, false, true);
session_start();
$alphanum = "ABCDEFGHJKLMNPQRSTUVWXYZ123456789";
$length = 5;
$position_x = 20;
$position_y = 5;
$text_color_red = 0;
$text_color_green = 0;
$text_color_blue = 0;
$font = "../../widget/captcha.ttf";
$rand = substr(str_shuffle($alphanum), 0, $length);
$_SESSION["varifyfailed"] = md5($rand);

// Check if GD library is available
if (!function_exists('imagecreatefromjpeg')) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-type: image/svg+xml");
    
    echo '<?xml version="1.0" standalone="no"?>
    <svg width="150" height="60" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <rect width="100%" height="100%" fill="#f0f0f0"/>
        <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="24" fill="black" dominant-baseline="middle" text-anchor="middle">'.$rand.'</text>
        <text x="50%" y="80%" font-family="Arial, sans-serif" font-size="10" fill="red" dominant-baseline="middle" text-anchor="middle">GD Missing</text>
    </svg>';
    exit;
}

$bgNum = rand(1, 4);
$image = imagecreatefromjpeg("../../images/verify" . $bgNum . ".jpg");
$textColor = imagecolorallocate($image, $text_color_red, $text_color_green, $text_color_blue);
imagettftext($image, 55, 0, 30, 60, $textColor, $font, $rand);
$noiceDots = 20;
for ($i = 0; $i < $noiceDots; $i++) {
    imagefilledellipse($image, mt_rand(0, 250), mt_rand(0, 70), 3, 3, $textColor);
}
$noiceLines = 20;
for ($i = 0; $i < $noiceLines; $i++) {
    imageline($image, mt_rand(0, 300), mt_rand(0, 300), mt_rand(0, 100), mt_rand(0, 100), $textColor);
}
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-type: image/jpeg");
imagejpeg($image);
imagedestroy($image);

?>