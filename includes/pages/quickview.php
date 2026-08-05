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
require_once "includes/fun.inc.php";
require_once "includes/client.area.inc.php";
require_once "includes/clients.fun.inc.php";
require_once "includes/products.fun.php";
if (!function_exists("getCustomFields")) {
    require_once ROOTDIR . "/includes/customfield.fun.inc.php";
}
if ($item) {
    $item = descape($item);
}
$tempalte_ver["addtocartlink"] = _url("widget/save/cart");
$tempalte_ver["wishlistlink"] = _url("wishlist/wishlist/" . $item);
$tempalte_ver["cartsignuplink"] = _url("widget/save/cart/action/signup");
$pagetitle = $lng_languag["cart"];
$pageicon = "";
$templatefile = "cart_quick_view";
$_nav .= "<a >" . $lng_languag["quick"] . " " . $lng_languag["view"] . "</a> ";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$item = preg_replace("/[^0-9a-zA-Z-]/i", "", $item);
$serviceDetails = getProducts("", $item, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "FRIWH");
if ($serviceDetails["id"]) {
    if ($customfields = getCustomFields("product", $serviceDetails["id"], "", "on", "", "", true, $_SESSION["system_default_currency"])) {
        foreach ($customfields as $value) {
            $tempalte_ver["customfields"][$value["name"]] = $value;
        }
    }
    $tempalte_ver["servicedtl"] = $serviceDetails;
    $tempalte_ver["item"] = $serviceDetails["id"];
    $tempalte_ver["mitem"] = $item;
    $tempalte_ver["wholesaleprice"] = getWholesalePrice($tempalte_ver["servicedtl"]["id"], $_SESSION["system_default_currency"]);
    echo processSingleTemplate($templatefile);
}
chkMd5sumsubpage();
class no
{
}

?>