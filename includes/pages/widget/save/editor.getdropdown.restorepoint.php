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
$path = preg_replace("/[^0-9\\-a-zA-Z]/i", "/", $_GET["path"]);
echo "<select id=\"restorepointdropdown\" name=\"restorepointdropdown\">\n    <option value=\"\">Select</option> \n        ";
$restorepoint = "../../" . $path . "/restorepoint";
if ($_SESSION["storeowneredit"]) {
    $restorepoint = $restorepoint . "/" . $_SESSION["storeowneredit"] . "/";
}
if ($handle = opendir($restorepoint)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $time = explode("_", $entry);
            preg_match("/^[0-9]*_/", $entry, $match);
            if ($match[0] != "") {
                $date[] = $time[0];
            }
        }
    }
    closedir($handle);
    if ($date) {
        $date = array_unique($date);
        sort($date);
        foreach ($date as $value) {
            echo "<option value=" . $value . ">" . date("d-m-Y h:i:s", $value) . "</option>";
        }
    }
}
echo "</select> \n    ";

?>