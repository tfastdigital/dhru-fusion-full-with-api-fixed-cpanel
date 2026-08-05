<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
$sql = dquery("select id,name from tbl_emailtemplates where \r\n    (for_reseller='1' or name='Price update notification')\r\n    AND ( type='imeiorder' or type='fileorder' or type='serverorder' \r\n    or type='imeiorder' or type='product' )");
while ($r = mysqli_fetch_assoc($sql)) {
    $uq = dquery("select * from tblUsers");
    while ($ru = mysqli_fetch_assoc($uq)) {
        dquery("INSERT INTO tbl_disabledemail \r\n            (uid,tid) values ('" . $ru["id"] . "','" . $r["id"] . "')");
    }
}
$fileverioncheck = "6.1.0";

?>