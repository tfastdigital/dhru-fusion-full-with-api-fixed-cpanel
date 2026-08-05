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
require_once "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$OUT = [];
if (isset($_POST["clearall"])) {
    $nid = explode(",", $_POST["quicknew"]);
    if (isset($_COOKIE["ANNOUNCE"])) {
        $cook = $_COOKIE["ANNOUNCE"];
    } else {
        $cook = "";
    }
    foreach ($nid as $pid) {
        $cook = $cook . "," . $pid;
        dquery("INSERT  tbl_annoucement_disabled (annoucemnt,uid)\r\n         VALUES ('" . $pid . "','" . $_SESSION["uid"] . "')");
    }
    $OUT["status"] = "success";
    $OUT["message"] = "Announcement Cleared";
    $OUT["closemodal"] = true;
} else {
    $_POST[qid] = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_POST[qid]);
    dquery("INSERT  tbl_annoucement_disabled (annoucemnt,uid)\r\n         VALUES ('" . $_POST["qid"] . "','" . $_SESSION["uid"] . "')");
    $OUT["status"] = "success";
    $OUT["message"] = "Announcement Cleared";
    $OUT["hidediv"] = "#news_row_" . $_POST[qid];
}
echo _josnOUT($OUT);

?>