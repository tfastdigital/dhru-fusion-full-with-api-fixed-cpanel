<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

session_start();
if (!isset($_SESSION["wysiwyg_image_uploading"]) || !$_SESSION["wysiwyg_image_uploading"]) {
    echo "Access Is Denied!";
    exit;
}
$is_demo = false;
$imagebasedir = "images";
$imagebaseurl = "images";
$browsedirs = true;
$allowuploads = true;
$overwrite = false;
$supportedextentions = ["gif", "png", "jpeg", "jpg", "bmp"];
$filetypes = ["png" => "jpg.gif", "jpeg" => "jpg.gif", "bmp" => "jpg.gif", "jpg" => "jpg.gif", "gif" => "gif.gif", "psd" => "psd.gif"];

?>