<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (isset($_GET["login"])) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    echo createVerification("login", false);
    exit;
}
if (isset($_GET["onregistration"])) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-type: image/jpeg");
    echo createVerification("onregistration", false);
    exit;
}
if (isset($_GET["news"])) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-type: image/jpeg");
    echo createVerification("news", false);
    exit;
}
if (isset($_GET["reg"])) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-type: image/jpeg");
    echo createVerification("reg", false);
    exit;
}
if (isset($_GET["review"])) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-type: image/jpeg");
    echo createVerification("review", false);
    exit;
}
if (isset($_GET["fromreg"])) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-type: image/jpeg");
    echo createVerification("fromreg", false);
    exit;
}
if (isset($_GET["res"])) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-type: image/jpeg");
    echo createVerification("res", false);
    exit;
}
if (isset($_GET["forget"])) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-type: image/jpeg");
    echo createVerification("forget", false);
    exit;
}
function createVerification($sessionfor, $base = true)
{
    ob_start();
    $alphanum = "ABCDEFGHJKLMNPQRSTUVWXYZ123456789";
    $length = 5;
    $position_x = 20;
    $position_y = 5;
    $text_color_red = 0;
    $text_color_green = 0;
    $text_color_blue = 0;
    $font = "./includes/pages/widget/captcha.ttf";
    $rand = substr(str_shuffle($alphanum), 0, $length);
    if (isset($_GET["login"]) || $sessionfor == "login") {
        $_SESSION["fromlogin"] = md5($rand);
    } else {
        if (isset($_GET["fromreg"]) || $sessionfor == "fromreg") {
            $_SESSION["fromreg"] = md5($rand);
        } else {
            if (isset($_GET["onregistration"]) || $sessionfor == "onregistration") {
                $_SESSION["registervarify"] = md5($rand);
            } else {
                if (isset($_GET["forget"]) || $sessionfor == "forget") {
                    $_SESSION["forgetcaptcha"] = md5($rand);
                } else {
                    if (isset($_GET["review"]) || $sessionfor == "review") {
                        $_SESSION["reviewcaptcha"] = md5($rand);
                    } else {
                        $_SESSION["varify"] = md5($rand);
                    }
                }
            }
        }
    }
    
    // Check if GD library is available
    if (!function_exists('imagecreatefromjpeg')) {
        // Override content type header if it was set previously
        if (!$base) {
            header("Content-type: image/svg+xml");
        }
        
        $svg = '<?xml version="1.0" standalone="no"?>
        <svg width="150" height="60" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <rect width="100%" height="100%" fill="#f0f0f0"/>
            <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="24" fill="black" dominant-baseline="middle" text-anchor="middle">'.$rand.'</text>
            <text x="50%" y="80%" font-family="Arial, sans-serif" font-size="10" fill="red" dominant-baseline="middle" text-anchor="middle">GD Missing</text>
        </svg>';
        
        ob_end_clean(); // Clean any previous buffer
        if ($base) {
            return base64_encode($svg);
        }
        return $svg;
    }

    $bgNum = rand(1, 4);
    $image = imagecreatefromjpeg("./includes/pages/widget/verificationimage/verify" . $bgNum . ".jpg");
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
    imagejpeg($image);
    $data = ob_get_contents();
    ob_end_clean();
    if ($base) {
        return base64_encode($data);
    }
    return $data;
}

?>