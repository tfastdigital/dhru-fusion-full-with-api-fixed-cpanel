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
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
if (!isset($_SESSION["uid"])) {
    exit;
}
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$service = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $service);
if ($service == "imei") {
    $uid = $_SESSION["uid"];
    $sid = $id;
    $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM tblUsers WHERE id='" . $uid . "'"));
    $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days \n    FROM tbl_services_imei where id='" . $sid . "'"));
    $table = "tbl_services_imei";
    $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
    echo $price . "|" . $serv["subscribe_days"];
}
if ($service == "file") {
    $uid = $_SESSION["uid"];
    $sid = $id;
    $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM tblUsers WHERE id='" . $uid . "'"));
    $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days \n    FROM tbl_services_file where id='" . $sid . "'"));
    $table = "tbl_services_file";
    $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
    echo $price . "|" . $serv["subscribe_days"];
}
if ($service == "server") {
    $uid = $_SESSION["uid"];
    $sid = $id;
    $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM tblUsers WHERE id='" . $uid . "'"));
    $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days \n    FROM tbl_server_log where id='" . $sid . "'"));
    $table = "tbl_server_log";
    $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
    echo $price . "|" . $serv["subscribe_days"];
}
if ($service == "shop") {
    $uid = $_SESSION["uid"];
    $sid = $id;
    $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM tblUsers WHERE id='" . $uid . "'"));
    $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days \n    FROM tbl_products where id='" . $sid . "'"));
    $table = "tbl_products";
    $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
    echo $price . "|" . $serv["subscribe_days"];
}

?>