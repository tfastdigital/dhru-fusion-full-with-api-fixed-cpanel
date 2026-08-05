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
if ($credit && $payment) {
    $fees = 0;
    if ($config["taxtype"] == "Exclusive") {
        $tax = mysqli_fetch_assoc(dquery("select taxrate from \r\ntbl_tax where gateway='" . $payment . "'"));
        if ($tax["taxrate"]) {
            $fees = round($credit * $tax["taxrate"] / 100, 2);
        }
    }
    echo $fees;
}

?>