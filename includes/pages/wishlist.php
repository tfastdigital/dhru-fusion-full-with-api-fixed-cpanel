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
$currentpage = "cart_wishlist";
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$viewmode = preg_replace("/[^a-z]/i", "", $viewmode);
$wishlist = preg_replace("/[^0-9a-zA-Z]/i", "", $wishlist);
$rem = preg_replace("/[^0-9a-zA-Z]/i", "", $rem);
if ($viewmode != "") {
    $_SESSION["viewmode"] = $viewmode;
}
if ($_SESSION["viewmode"]) {
    $tempalte_ver["viewmode"] = $viewmode;
}
if ($_SESSION["uid"]) {
    $pagetitle = $lng_languag["wishlist"] . " " . $lng_languag["item"];
    $_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["home"] . "</a> / " . "<a href=\"" . _url("wishlist") . "\">" . $lng_languag["wishlist"] . "</a>";
    $templatefile = "cart_wishlist";
    $pageicon = "";
    $user = mysqli_fetch_assoc(dquery("select wishlist from tblUsers where id='" . $_SESSION["uid"] . "'"));
    $listdata = unserialize($user["wishlist"]);
    if ($wishlist) {
        $sql = mysqli_fetch_assoc(dquery("select id from tbl_products where md5(id)='" . $wishlist . "'"));
        if ($sql["id"]) {
            $listdata[$sql["id"]] = $sql["id"];
        }
        $listdata2 = serialize($listdata);
        dquery("UPDATE tblUsers SET wishlist='" . $listdata2 . "' where id='" . $_SESSION["uid"] . "'");
    }
    if ($rem) {
        $sql = mysqli_fetch_assoc(dquery("select id from tbl_products where md5(id)='" . $rem . "'"));
        if ($sql["id"]) {
            unset($listdata[$sql["id"]]);
        }
        $listdata2 = serialize($listdata);
        dquery("UPDATE tblUsers SET wishlist='" . $listdata2 . "' where id='" . $_SESSION["uid"] . "'");
    }
    if (count($listdata) <= 0) {
        header("Location: " . _url("index"));
    }
    if ($listdata) {
        $list = implode(",", $listdata);
    }
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    require_once ROOTDIR . "/includes/products.fun.php";
    if ($list) {
        $tempalte_ver["productitems"] = getProducts("", "", $_SESSION["uid"], "", "", "", "", "", "", "", "", "", $list);
    }
} else {
    $_SESSION["afterloginredirect"] = $_SERVER["REQUEST_URI"];
    include ROOTDIR . "/includes/login.inc.php";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
}
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>