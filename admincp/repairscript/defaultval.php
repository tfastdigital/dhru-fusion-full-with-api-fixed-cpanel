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
$dq = dquery("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '" . $DB_NAME . "'");
while ($rq = mysqli_fetch_assoc($dq)) {
    if ($rq["TABLE_NAME"]) {
        $qc = dquery("SHOW COLUMNS FROM " . $rq["TABLE_NAME"]);
        while ($rc = mysqli_fetch_assoc($qc)) {
            if ($rc["Field"] && $rc["Null"] == "NO" && $rc["Default"] == NULL && $rc["Key"] != "PRI") {
                dquery("ALTER TABLE  " . $rq["TABLE_NAME"] . " CHANGE  `" . $rc["Field"] . "`  `" . $rc["Field"] . "` " . $rc["Type"] . "  NULL DEFAULT NULL");
            }
            if ($rc["Field"] && $rc["Null"] == "NO" && $rc["Default"] != NULL && $rc["Key"] != "PRI") {
                dquery("ALTER TABLE  " . $rq["TABLE_NAME"] . " CHANGE  `" . $rc["Field"] . "`  `" . $rc["Field"] . "` " . $rc["Type"] . "  NULL DEFAULT NULL");
            }
            if ($rc["Field"] && $rc["Null"] == "NO" && $rc["Default"] == 0 && $rc["Key"] != "PRI") {
                $typs = explode("(", $rc["Type"]);
                dquery("ALTER TABLE  " . $rq["TABLE_NAME"] . " CHANGE  `" . $rc["Field"] . "`  `" . $rc["Field"] . "` varchar(" . $typs[1] . " NOT NULL DEFAULT 0");
            }
        }
    }
}

?>