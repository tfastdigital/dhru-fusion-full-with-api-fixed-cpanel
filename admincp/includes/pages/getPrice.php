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
if ($type) {
    if ($type == "imei") {
        $sql = dquery("select * from tbl_services_imei where active='1'\n        and useasserver=0");
        echo "            <option value=\"\">";
        echo $LNG["select"];
        echo "</option>\n        ";
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "            <option value=\"";
            echo $row["id"];
            echo "\">";
            echo $row["service_name"] . " - " . $row["credit"];
            echo "</option>\n            ";
        }
    }
    if ($type == "file") {
        $sql = dquery("select * from tbl_services_file where active='1'");
        echo "            <option value=\"\">";
        echo $LNG["select"];
        echo "</option>\n        ";
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "            <option value=\"";
            echo $row["id"];
            echo "\">";
            echo $row["service_name"] . " - " . $row["credit"];
            echo "</option>\n            ";
        }
    }
    if ($type == "server") {
        $sql = dquery("select * from tbl_services_imei where active='1'\n        and useasserver=1");
        echo "            <option value=\"\">";
        echo $LNG["select"];
        echo "</option>\n        ";
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "            <option value=\"";
            echo $row["id"];
            echo "\">";
            echo $row["service_name"] . " - " . $row["credit"];
            echo "</option>\n            ";
        }
    }
    if ($type == "remote") {
        $sql = dquery("select * from tbl_services_imei where active='1'\n        and useasserver=2");
        echo "        <option value=\"\">";
        echo $LNG["select"];
        echo "</option>\n        ";
        while ($row = mysqli_fetch_assoc($sql)) {
            echo "            <option value=\"";
            echo $row["id"];
            echo "\">";
            echo $row["service_name"] . " - " . $row["credit"];
            echo "</option>\n            ";
        }
    }
    exit;
}
if (isset($_POST["id"])) {
    $sid = $_POST["id"];
    if ($st == "server") {
        $table1 = "tbl_services_imei";
        $table2 = "tbl_imei_credit";
    } else {
        if ($st == "file") {
            $table1 = "tbl_services_file";
            $table2 = "tbl_file_credit";
        } else {
            if ($st == "imei") {
                $table1 = "tbl_services_imei";
                $table2 = "tbl_imei_credit";
            }
        }
    }
    $serv = mysqli_fetch_assoc(dquery("select credit from " . $table1 . " where id='" . $sid . "'"));
    $buf = "";
    $def = mysqli_fetch_assoc(dquery("select id from tbl_currencies where `default`='1'"));
    $curs = dquery("select prefix,suffix,id,code from tbl_currencies");
    while ($pre = mysqli_fetch_assoc($curs)) {
        $sql = dquery("select * from " . $table2 . " where service_id='" . $sid . "' and currency_id='" . $pre["id"] . "'");
        $row = mysqli_fetch_assoc($sql);
        if (!$row["credit"]) {
            $row["credit"] = convertCurrency($serv["credit"], $def["id"], $pre["id"]);
        }
        $buf .= "|" . $pre["id"] . "=" . $pre["code"] . " " . $row["credit"];
    }
    echo $buf = trim($buf, "|");
}

?>