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
require "../../comm.php";
require "../includes/fun.inc.php";
require "../../includes/fun.inc.php";
require "../includes/comm.inc.php";
if (!checkAdminlogin() || !$_SESSION["adminid"]) {
    echo "<div align=\"center\"><h2>Session expired. <a href=\"../index.php\">Please relogin</a></h2></div>";
    exit;
}
dquery("UPDATE tblUsers SET \ncredit_left=round(credit_left,2),\ncredit_used=round(credit_used,2),\ncredit_inprocess=round(credit_inprocess,2),\nsell_credit_limit=round(sell_credit_limit,2)\n");

?>