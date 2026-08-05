<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

checkDemoMode();
define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require_once "../../../comm.php";
require_once "../../../includes/fun.inc.php";
require_once "../../../includes/clients.fun.inc.php";
echo "\n";
dquery("update tbl_admin set notes='" . $_POST["note"] . "' WHERE id='" . $_SESSION["adminid"] . "'");

?>