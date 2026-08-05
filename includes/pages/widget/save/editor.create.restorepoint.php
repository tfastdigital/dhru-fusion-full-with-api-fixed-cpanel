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
error_reporting(0);
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if ($_SESSION["adminid"] || $_SESSION["storeowneredit"]) {
    $restorepoint = "../../" . $restorepoint . "/restorepoint/";
    if ($_SESSION["storeowneredit"]) {
        $restorepoint = $restorepoint . $_SESSION["storeowneredit"] . "/";
    }
    if (!is_dir($restorepoint) && mkdir($restorepoint, 511, true)) {
        $notfound = "true";
    }
    $time = time();
    krsort($templatePath);
    if ($templatePath) {
        foreach ($templatePath as $key => $cssfile) {
            $tmpFile = "../../" . $cssfile;
            $cssfilenamesplit = explode("/", $cssfile);
            $cssfilename = $cssfilenamesplit[count($cssfilenamesplit) - 1];
            $ext = substr($cssfile, strrpos($cssfile, ".") + 1);
            if ($notfound == "true" && $ext == "css") {
                $default = file_get_contents($tmpFile);
                $createfile = $restorepoint . $cssfilename;
                $handle_tmpFile = fopen($createfile, "w");
                fwrite($handle_tmpFile, $default);
                unset($default);
            }
            $ext = substr($tmpFile, strrpos($tmpFile, ".") + 1);
            if (strpos($ext, "css") !== false && file_exists($tmpFile)) {
                $rp = $time . "_" . $cssfilename;
                $style = file_get_contents($tmpFile);
                $createfile = $restorepoint . $rp;
                $handle_tmpFile = fopen($createfile, "w");
                fwrite($handle_tmpFile, $style);
                echo "success:" . $lng_languag["save"] . " " . $lng_languag["successfully"];
            }
        }
    }
}

?>