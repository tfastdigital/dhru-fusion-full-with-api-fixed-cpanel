<?php
/*
 *after.com
 * @ Release: 13/06/2023
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