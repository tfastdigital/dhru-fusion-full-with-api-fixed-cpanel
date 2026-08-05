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
require "../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $serviceid);
if (!$serviceid) {
    exit;
}
$templatefile = "client_order_server_getservicedetails";
installclient($pagetitle, $pageicon, $breadcrumbnav);
require ROOTDIR . "/includes/serverservices.fun.php";
$tempalte_ver["smsgateway"] = $config["smsgateway"];
$tempalte_ver["ordernotes"] = $config["ordernotes"];
$tempalte_ver["ordercomments"] = $config["ordercomments"];
$tempalte_ver["orderemail"] = $config["orderemail"];
$tempalte_ver["orderno"] = $config["orderno"];
if ($cart) {
    $tempalte_ver["serverservice"] = getServerServices("", $serviceid, "", true, "", "", true);
} else {
    $tempalte_ver["serverservice"] = getServerServices("", $serviceid, $_SESSION["uid"], true);
}
if ($config["averagedeliverytime"] && $config["deliverycount"]) {
    $deliverycnt = $config["deliverycount"];
    $time = 0;
    $q = dquery("select time,reply_time from tbl_order_server where (user_can_c=3\n       or user_can_c=4) and md5(service_id)='" . $serviceid . "' order by order_id desc limit " . $deliverycnt);
    while ($r = mysqli_fetch_assoc($q)) {
        $time += $r["reply_time"] - $r["time"];
    }
    if (60 < $time) {
        $time = $time / mysqli_num_rows($q);
        $tempalte_ver["averagetime"] = secondsToTime($time);
    }
}
if ($tempalte_ver["serverservice"]["download_link"]) {
    $tempalte_ver["downloadlink"] = "<a  style='text-decoration:none;' href=" . $tempalte_ver["serverservice"]["download_link"] . " target='_blank'><img align='middle'  height='14' width='14' src='images/save.png' border='0'>&nbsp;&nbsp;" . $lng_languag["downloadsoftware"] . "</a>";
}
if ($tempalte_ver["serverservice"]["faq_id"]) {
    $tempalte_ver["knowledgebase"] = "<a  style='text-decoration:none;' href='knowledgebase.php?currentpage=knowledgebase&artical=" . $tempalte_ver["serverservice"]["faq_id"] . "' target='_blank'><img  height='14' width='14' align='middle' src='images/help.png' border='0'>&nbsp;&nbsp;" . $lng_languag["servicehelp"] . "</a>";
}
if (!function_exists("getCustomFields")) {
    require ROOTDIR . "/includes/customfield.fun.inc.php";
}
$customfields = getCustomFields("serviceserver", $tempalte_ver["serverservice"]["id"], "", "on");
foreach ($customfields as $value) {
    $tempalte_ver["customfields"][$value["name"]] = $value;
}
if ($_ClientsDetails["verified"]) {
    $tempalte_ver["responseno"] = $_ClientsDetails["phonenumber"];
}
$tempalte_ver["cart"] = $cart;
echo processSingleTemplate($templatefile);
unset($tempalte_ver);

?>