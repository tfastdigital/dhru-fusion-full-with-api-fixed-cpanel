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
require_once "../../comm.php";
error_reporting(1);
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($_SESSION["adminid"] || $_SESSION["storeowneredit"]) {
    krsort($templatePath);
    if ($templatePath) {
        foreach ($templatePath as $key => $cssfile) {
            $tmpFile = "../../" . $cssfile;
            $cssfilenamesplit = explode("/", $cssfile);
            $cssfilename = $cssfilenamesplit[count($cssfilenamesplit) - 1];
            $restorepoint = "../../" . $restorepoint . "/restorepoint/";
            if ($_SESSION["storeowneredit"]) {
                $restorepoint = $restorepoint . $_SESSION["storeowneredit"] . "/";
            }
            $restoreFile = $restorepoint . $cssfilename;
            $ext = substr($tmpFile, strrpos($tmpFile, ".") + 1);
            if (strpos($ext, "css") !== false && file_exists($tmpFile) && file_exists($restoreFile)) {
                $style = file_get_contents($restoreFile);
                $handle_tmpFile = fopen($tmpFile, "w+");
                fwrite($handle_tmpFile, $style);
                echo "reload:Please Wait Reload Page";
            }
        }
    }
}

?>