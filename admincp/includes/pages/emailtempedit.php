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
if ($val) {
    echo "     <a href=\"javascript: load_subpage('main2.php?page=emailtemplate.edit&id=";
    echo $val;
    echo "','Edit Mail Template')\">\n    ";
    echo $LNG["edit"];
    echo " ";
    echo $LNG["mail"];
    echo " ";
    echo $LNG["template"];
    echo "</a>\n    ";
}
$fileverioncheck = "6.1.0";

?>