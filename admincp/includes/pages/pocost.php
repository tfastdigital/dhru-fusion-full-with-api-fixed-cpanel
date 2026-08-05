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
if ($po) {
    $c = dquery("select id,code from tbl_currencies where `default`=0");
    $OUT = "";
    while ($rc = mysqli_fetch_assoc($c)) {
        $price = convertCurrency($po, $_SESSION["system_default_currency"]["id"], $rc["id"]);
        $price = round($price, 2);
        $OUT .= $rc["code"] . "=" . $price . "_";
    }
}
echo trim($OUT, "_");

?>