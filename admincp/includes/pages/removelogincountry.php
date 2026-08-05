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
if (!$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h3>Session expired. <a style=\"color: #666;\" href=\"index.php?main2redirect=true\">Please relogin</a></h3></div>";
    $_SESSION["admin_afterlogin_re"] = $_SERVER["REQUEST_URI"];
    exit;
}
if ($country && $userid) {
    $U = mysqli_fetch_assoc(dquery("select allowedcountry from tblUsers\r\nwhere id='" . $userid . "'"));
    echo $U["allowedcountry"];
    $cntr = json_decode($U["allowedcountry"], true);
    $NewArr = [];
    foreach ($cntr as $c) {
        if ($c != $country) {
            $NewArr[$c] = $c;
        }
    }
    $cntr = json_encode($NewArr);
    dquery("update tblUsers set \r\n    allowedcountry='" . $cntr . "' where id='" . $userid . "'");
}
$fileverioncheck = "6.1.0";

?>