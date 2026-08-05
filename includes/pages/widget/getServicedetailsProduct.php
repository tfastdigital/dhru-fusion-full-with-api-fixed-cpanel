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
$serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $serviceid);
$templatefile = "client_order_product_getservicedetails";
installclient($pagetitle, $pageicon, $breadcrumbnav);
require_once ROOTDIR . "/includes/products.fun.php";
$tempalte_ver["products"] = getProducts("", $serviceid, $_SESSION["uid"], true);
$listing = $tempalte_ver["products"]["listing"];
if ($tempalte_ver["products"]["download_link"]) {
    $tempalte_ver["downloadlink"] = "<a  style='text-decoration:none;' href=" . $tempalte_ver["products"]["download_link"] . " target='_blank'><img align='middle'  height='14' width='14' src='images/save.png' border='0'>&nbsp;&nbsp;" . $lng_languag["downloadsoftware"] . "</a>";
}
if ($tempalte_ver["products"]["faq_id"]) {
    $tempalte_ver["knowledgebase"] = "<a  style='text-decoration:none;' href='knowledgebase.php?currentpage=knowledgebase&artical=" . $tempalte_ver["products"]["faq_id"] . "' target='_blank'><img  height='14' width='14' align='middle' src='images/help.png' border='0'>&nbsp;&nbsp;" . $lng_languag["servicehelp"] . "</a>";
}
if ($tempalte_ver["products"]["availability_date"]) {
    $date = $tempalte_ver["products"]["availability_date"];
    if (date("Y-m-d") < $date) {
        $tempalte_ver["futureproduct"] = $date;
    }
}
if (!function_exists("getCustomFields")) {
    require ROOTDIR . "/includes/customfield.fun.inc.php";
}
$tempalte_ver["cart"] = $cart;
$customfields = getCustomFields("product", $tempalte_ver["products"]["id"], "", "on", "", "", true, $_SESSION["currency"]);
foreach ($customfields as $value) {
    $tempalte_ver["customfields"][$value["name"]] = $value;
}
echo processSingleTemplate($templatefile);
unset($tempalte_ver);

?>