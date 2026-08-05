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
dquery("update tbl_order_server set qnt=1 where qnt=0");
$u = dquery("select * from tblUsers");
while ($r = mysqli_fetch_assoc($u)) {
    $i = mysqli_fetch_assoc(dquery("select sum(credit) as c,sum(discount) as d from \r\n    tbl_order_imei where user_id='" . $r["id"] . "' and user_can_c<2"));
    $f = mysqli_fetch_assoc(dquery("select sum(credit) as c,sum(discount) as d from \r\n    tbl_order_file where user_id='" . $r["id"] . "' and user_can_c<2"));
    $s = mysqli_fetch_assoc(dquery("select sum(credit*qnt) as c,sum(discount*qnt) as d from \r\n    tbl_order_server where user_id='" . $r["id"] . "' and user_can_c<2"));
    $locked = $i["c"] - $i["d"] + $f["c"] - $f["d"] + $s["c"] - $s["d"];
    dquery("UPDATE tblUsers SET \r\n    credit_inprocess=round(" . $locked . " ,2) where id='" . $r["id"] . "'");
}

?>