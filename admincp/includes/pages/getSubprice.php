<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../../../comm.php";
require "../fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($_GET["service"] == "imei") {
    $table = "tbl_services_imei";
} else {
    if ($_GET["service"] == "file") {
        $table = "tbl_services_file";
    } else {
        if ($_GET["service"] == "server") {
            $table = "tbl_server_log";
        } else {
            if ($_GET["service"] == "product") {
                $table = "tbl_products";
            }
        }
    }
}
if ($_GET["service"] == "imei") {
    $uid = $_GET["user"];
    $sid = $_GET["id"];
    $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM tblUsers WHERE id='" . $uid . "'"));
    $sql = mysqli_fetch_assoc(dquery("SELECT credit_subscribe FROM tbl_imei_credit where service_id='" . $sid . "' and currency_id='" . $cur["default_currency"] . "'"));
    $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days FROM tbl_services_imei where id='" . $sid . "'"));
    $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
    echo $price . "|" . $serv["subscribe_days"];
} else {
    if ($_GET["service"] == "file") {
        $uid = $_GET["user"];
        $sid = $_GET["id"];
        $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM tblUsers WHERE id='" . $uid . "'"));
        $sql = mysqli_fetch_assoc(dquery("SELECT credit_subscribe FROM tbl_file_credit where service_id='" . $sid . "' and currency_id='" . $cur["default_currency"] . "'"));
        $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days FROM tbl_services_file where id='" . $sid . "'"));
        $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
        echo $price . "|" . $serv["subscribe_days"];
    } else {
        if ($_GET["service"] == "server") {
            $uid = $_GET["user"];
            $sid = $_GET["id"];
            $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM tblUsers WHERE id='" . $uid . "'"));
            $sql = mysqli_fetch_assoc(dquery("SELECT credit_subscribe FROM tbl_server_credit where service_id='" . $sid . "' and currency_id='" . $cur["default_currency"] . "'"));
            $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days FROM tbl_server_log where id='" . $sid . "'"));
            $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
            echo $price . "|" . $serv["subscribe_days"];
        } else {
            if ($_GET["service"] == "product") {
                $uid = $_GET["user"];
                $sid = $_GET["id"];
                $cur = mysqli_fetch_assoc(dquery("SELECT default_currency FROM tblUsers WHERE id='" . $uid . "'"));
                $sql = mysqli_fetch_assoc(dquery("SELECT credit_subscribe FROM tbl_product_credit where service_id='" . $sid . "' and currency_id='" . $cur["default_currency"] . "'"));
                $serv = mysqli_fetch_assoc(dquery("SELECT subscribe_credit,subscribe_days FROM tbl_products where id='" . $sid . "'"));
                $price = subscribeCurrency($sid, $table, $cur["default_currency"]);
                echo $price . "|" . $serv["subscribe_days"];
            }
        }
    }
}

?>