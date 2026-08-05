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
if (1) {
    $where = "";
    if ($group != "") {
        $where .= " and client_group in (" . $group . ")";
    }
    if ($statuss != "") {
        $where .= " and userstatus in (" . $statuss . ")";
    }
    if ($types != "") {
        $where .= " and usertype in (" . $types . ")";
    }
    if ($resellers != "") {
        $where .= " and reseller_id in (" . $resellers . ")";
    }
    if ($countrys) {
        $countrys = str_replace(",", "','", $countrys);
        $countrys = "'" . $countrys . "'";
        $where .= " and country in (" . $countrys . ")";
    }
    $where .= " order by username asc";
    $query = dquery("select * from tblUsers where 1=1 " . $where);
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr><td><input type=\"checkbox\"   name=\"users[]\" value=\"" . $row["id"] . "\"/>&nbsp;&nbsp;&nbsp;&nbsp;<label>" . $row["username"] . "</label></td><td>" . $row["email"] . "</td><td>" . $row["credit_left"] . "</td><td></td></tr>";
    }
}
$fileverioncheck = "6.1.0";

?>