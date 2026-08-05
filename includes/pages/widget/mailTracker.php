<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require_once "../comm.php";
if ($t) {
    dquery("update tbl_campaign_users set opencount=opencount+1 where md5id='" . $t . "'");
    $image = imagecreate(1, 1);
    imagefilledellipse($image, mt_rand(0, 250), mt_rand(0, 70), 3, 3, "ffffff");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Content-type: image/jpeg");
    imagejpeg($image);
    imagedestroy($image);
}

?>