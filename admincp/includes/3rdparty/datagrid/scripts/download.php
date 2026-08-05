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
$dir = isset($_SESSION["datagrid_export_dir"]) && $_SESSION["datagrid_export_dir"] != NULL ? $_SESSION["datagrid_export_dir"] : "";
$file = isset($_SESSION["datagrid_export_file"]) && $_SESSION["datagrid_export_file"] != NULL ? $_SESSION["datagrid_export_file"] : "";
$debug = isset($_SESSION["datagrid_debug"]) && $_SESSION["datagrid_debug"] != NULL ? $_SESSION["datagrid_debug"] : "";
$file_path = "../../../../" . $dir . $file;
unset($_SESSION["datagrid_export_dir"]);
unset($_SESSION["datagrid_export_file"]);
unset($_SESSION["datagrid_debug"]);
if (preg_match("/0/", $file) || preg_match("/0/", $dir)) {
    echo "Can not find export file! Turn on debug mode to see more info.";
}
if (($file == "export.xml" || $file == "export.csv" || $file == "export.pdf") && @file_exists($file_path)) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/force-download");
    header("Content-Disposition: inline; filename=\"" . $file . "\"");
    header("Content-Transfer-Encoding: Binary");
    header("Content-length: " . filesize($file_path));
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . $file . "\"");
    readfile($file_path);
} else {
    if ($debug) {
        echo "Can not find such path: " . $file_path . "! Also, check please you have added session_start(); command in your code";
    } else {
        echo "Can not find export file! Turn on debug mode to get more info.";
    }
}
exit(0);

?>