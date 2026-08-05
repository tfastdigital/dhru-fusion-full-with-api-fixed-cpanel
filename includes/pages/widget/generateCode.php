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
require_once "../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
$bid = preg_replace("/[^0-9]/i", "", $banner);
if (!isset($_SESSION["uid"])) {
    exit;
}
installclient($pagetitle, $pageicon, $breadcrumbnav);
unset($sql);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_affiliate_banner where id='" . $bid . "'"));
$uid = md5($_SESSION["uid"]);
if ($sql["type"] == "imei" && $sql["service_id"]) {
    $link = "cart.php?group=" . $sql["group_id"] . "&item=" . md5($sql["service_id"]) . "&service=imei";
} else {
    if ($sql["type"] == "imei") {
        $link = "cart.php?group=" . $sql["group_id"] . "&service=imei";
    } else {
        if ($sql["type"] == "server" && $sql["service_id"]) {
            $link = "cart.php?group=" . $sql["group_id"] . "&item=" . md5($sql["service_id"]) . "&service=server";
        } else {
            if ($sql["type"] == "server") {
                $link = "cart.php?group=" . $sql["group_id"] . "&service=server";
            } else {
                if ($sql["type"] == "product" && $sql["service_id"]) {
                    $link = "cart.php?group=" . $sql["group_id"] . "&item=" . md5($sql["service_id"]) . "&service=product";
                } else {
                    if ($sql["type"] == "product") {
                        $link = "cart.php?group=" . $sql["group_id"] . "&service=product";
                    } else {
                        $link = "index.php?1=1";
                    }
                }
            }
        }
    }
}
echo "<p><label>Code</label><span>\n<textarea readonly='readonly' rows='5' cols='45' >";
echo htmlspecialchars("<a href='" . $config["site_address"] . $link . "&aid=" . $uid . "' target='_blank'><img src='" . $sql["banner"] . "' border='0' /></a>");
echo "</textarea></span></p>";
echo "<p><label>&nbsp;</label><span><a  target='_blank' href='" . $config["site_address"] . $link . "&aid=" . $uid . "'><img alt='" . $sql["alttag"] . "' src='" . $sql["banner"] . "' border='0' width='" . $sql["width"] . "'  width='" . $sql["height"] . "' /></a></span></p>";

?>