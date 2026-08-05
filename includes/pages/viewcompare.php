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
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
require ROOTDIR . "/includes/features.fun.php";
$currentpage = "compare";
$pagetitle = $lng_languag["compare"];
$_nav = "<a href=\"index.php\">" . $lng_languag["home"] . "</a>";
$_nav .= " / <a href=\"viewcompare.php\">" . $lng_languag["compare"] . "</a>";
$templatefile = "compareproduct";
$pageicon = "";
installclient($pagetitle, $pageicon, $_nav);
$clear = preg_replace("/[^0-9]/i", "", $clear);
if ($clear) {
    unset($_SESSION["COMPARE"][$clear]);
    unset($_SESSION["COMPLIST"][$clear]);
}
if ($clearall) {
    unset($_SESSION["COMPARE"]);
    unset($_SESSION["COMPLIST"]);
    header("Location: cart.php");
}
if (1 < count($_SESSION["COMPARE"])) {
    foreach ($_SESSION["COMPARE"] as $pid) {
        if ($pid) {
            $sql = getProducts("", md5($pid), "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "RF");
            $PRODUCT[$pid] = $sql;
            $ALLFEATURES[$pid] = getFeatures("features", "", $pid);
            foreach ($ALLFEATURES[$pid] as $f) {
                if ($f["value"]) {
                    $features[$f["name"]][$pid] = $f["value"];
                } else {
                    $features[$f["name"]][$pid] = "-";
                }
            }
        }
    }
    foreach ($features as $key => $val) {
        $cnt = 0;
        foreach ($val as $v) {
            if ($v == "-") {
                $cnt++;
            }
            if ($cnt == count($_SESSION["COMPARE"])) {
                unset($features[$key]);
            }
        }
    }
}
$tempalte_ver["products"] = $PRODUCT;
$tempalte_ver["features"] = $features;
chkMd5sumsubpage();
$fileverioncheck = "6.1.0";
DisplayOutput($templatefile);
class no
{
}

?>