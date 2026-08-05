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
$ACCOUNT["username"] = $_SESSION["username"];
$ACCOUNT["email"] = $UserDetails["email"];
$ACCOUNT["credit"] = round($UserDetails["credit"]["credit"], 2);
$ACCOUNT["currency"] = $UserDetails["currency"]["code"];
$ACCOUNT["cnt"] = mysqli_num_rows(dquery("select id from tbl_statement_user \nwhere uid='" . $UID . "' "));
$q = dquery("select stype,date,`type`,amount,balance,description from tbl_statement_user\nwhere uid='" . $UID . "' order by id desc limit " . $start . "," . $limit);
while ($r = mysqLi_fetch_assoc($q)) {
    $OUT[] = $r;
}
$apiresults["SUCCESS"][] = ["message" => "Statement", "statement" => $OUT, "account" => $ACCOUNT];

?>