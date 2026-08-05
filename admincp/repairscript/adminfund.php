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
dquery("UPDATE tbl_invoices\n             LEFT OUTER JOIN tbl_invoiceitems ON\n            `tbl_invoices`.id = tbl_invoiceitems.invoiceid\n             SET adminid='" . $_SESSION["adminid"] . "' WHERE tbl_invoices.adminid=''\n             AND tbl_invoices.id=tbl_invoiceitems.invoiceid and tbl_invoiceitems.type='AdminAddFunds'\n             ");

?>