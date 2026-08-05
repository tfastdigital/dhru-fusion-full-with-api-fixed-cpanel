<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$currentpage = "placeorderimei";
$_nav = "<a href=\"main.php\">" . $lng_languag["dashboard"] . "</a> / ";
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$status = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $status);
$flag = false;
$pagetitle = $lng_languag["placeorderimei"];
$_nav .= "<a href='resellerplaceorder.php?action=imei' >" . $lng_languag["placeorderimei"] . "</a> / ";
$templatefile = "client_directorder_imei";
$pageicon = "";
installclient($pagetitle, $pageicon, $breadcrumbnav);
if (base64_decode($config["directorderinfo"])) {
    $tempalte_ver["orderinfo"] = nl2br(base64_decode($config["directorderinfo"]));
}
if ($id) {
    require_once "includes/imeiservices.fun.php";
    $tempalte_ver["imeiservicelist"] = getIMEIServices($group, "", "", true, "", "", "", "", "", "", "", "", 999999);
    $tempalte_ver["actionlink"] = "includes/getdata/placedirectimei.php";
    $tempalte_ver["uid"] = $id;
    $s = dquery("select * from tbl_private_order where \n        CONCAT(MD5(SHA1(uid)))='" . $id . "' and qnt>0");
    if (isset($_SESSION["uid"])) {
        $d = mysqli_fetch_assoc($s);
        $tempalte_ver["charge"] = $d["chargeable"];
        $_ClientsDetails = getClientsDetails($_SESSION["uid"]);
        if ($_ClientsDetails["email"] != $d["email"]) {
            $templatefile = "client_accessdenied";
            $tempalte_ver["rightmenu"] = false;
            $tempalte_ver["notification"]["error"] = "Invalid User Account";
        }
        if ($_ClientsDetails["access"]["alow_imeiservices"] == "") {
        }
    }
    if (mysqli_num_rows($s) != 1) {
        $flag = true;
    } else {
        $s = dquery("select *,(select useasserver from tbl_services_imei\nwhere id=sid) as server from tbl_private_order where \n            CONCAT(MD5(SHA1(uid)))='" . $id . "' and status='0'");
        $d = mysqli_fetch_assoc($s);
        if ($d["server"]) {
            $tempalte_ver["servicetype"] = "server";
        } else {
            $tempalte_ver["servicetype"] = "imei";
        }
        $tempalte_ver["charge"] = $d["chargeable"];
        $tempalte_ver["md5id"] = md5($d["sid"]);
        $s = mysqli_fetch_assoc(dquery("select service_name,retail \n            from tbl_services_imei where id='" . $d["sid"] . "'"));
        if (!$s["service_name"]) {
            $flag = true;
        }
        $ui = mysqli_fetch_assoc(dquery("select imei_services from \n            tblUsers where email='" . $d["email"] . "'"));
        if ($ui["imei_services"] == "") {
        }
        $tempalte_ver["nos"] = $d["qnt"];
        $tempalte_ver["service"] = $s["service_name"];
        $tempalte_ver["mdservice"] = md5($d["sid"]);
    }
} else {
    $flag = true;
}
if ($flag) {
    $templatefile = "client_accessdenied";
    $tempalte_ver["rightmenu"] = false;
    $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
}
$tempalte_ver["directorder"] = 1;
$tempalte_ver["token"] = generate_token("form");
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>