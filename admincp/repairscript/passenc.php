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
$sql = dquery("select id,password from tblUsers");
while ($row = mysqli_fetch_assoc($sql)) {
    $enc = md5($row["password"] . "9486");
    dquery("UPDATE tblUsers SET password='" . $enc . "' WHERE id='" . $row["id"] . "'");
}
$sql = dquery("select id,password from tbl_admin");
while ($row = mysqli_fetch_assoc($sql)) {
    $enc = md5($row["password"] . "9486");
    dquery("UPDATE tbl_admin SET password='" . $enc . "' WHERE id='" . $row["id"] . "'");
}
$sql = dquery("select id,password from tbl_supplier");
while ($row = mysqli_fetch_assoc($sql)) {
    $enc = md5($row["password"] . "9486");
    dquery("UPDATE tbl_supplier SET password='" . $enc . "' WHERE id='" . $row["id"] . "'");
}

?>