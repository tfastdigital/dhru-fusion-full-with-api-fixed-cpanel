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
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if (!function_exists("getCustomFields")) {
    require ROOTDIR . "/includes/customfield.fun.inc.php";
}
if ($gateway == "offlinepayments") {
    $gateway = "gateway";
}
$customfields = getCustomFields($gateway, "", "", "on");
foreach ($customfields as $c => $v) {
    echo "    <tr><td class=\"fieldlabel\">";
    echo $v["name"];
    echo "</td><td class=\"fieldarea\">\n    ";
    echo $v["input"];
    echo " ";
    echo $v["required"];
    echo " ";
    echo $v["description"];
    echo "    </td></tr>\n";
}
$q = dquery("select * from tbl_paymentgateways where gateway='" . $gateway . "'");
while ($r = mysqli_fetch_assoc($q)) {
    $Gateways[$r["setting"]] = $r["value"];
}
if ($Gateways["apiusername"] && $Gateways["apipassword"] && $Gateways["apisignature"]) {
    echo "____auto";
}
$fileverioncheck = "6.1.0";

?>