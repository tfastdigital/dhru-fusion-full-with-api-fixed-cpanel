<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$UID = $UserDetails["id"];
if (!$start) {
    $start = 0;
}
if (!$limit) {
    $limit = 10;
}
$ACCOUNT["cnt"] = mysqli_num_rows(dquery("select pointid from tbl_statement_points \nwhere uid='" . $UID . "' "));
$q = dquery("select cr,dr,orderid,date,time from tbl_statement_points\nwhere uid='" . $UID . "' order by pointid desc limit " . $start . "," . $limit);
while ($r = mysqli_fetch_assoc($q)) {
    $r["time"] = date("h:i A", $r["time"]);
    $OUT[] = $r;
}
$Bal = mysqli_fetch_assoc(dquery("select sum(cr) as crs,sum(dr) as drs from\ntbl_statement_points where uid='" . $UID . "'"));
$CR = $Bal["crs"];
$DR = $Bal["drs"];
$ACCOUNT["balance"] = $DR < $CR ? $CR - $DR . "CR" : $DR - $CR . "DR";
$apiresults["SUCCESS"][] = ["message" => "Reward point statement", "data" => $OUT, "account" => $ACCOUNT];

?>