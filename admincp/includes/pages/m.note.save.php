<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

checkDemoMode();
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
dquery("update tbl_admin set notes='" . $note . "' where id='" . $_SESSION["adminid"] . "'");
echo "success: Notes updated";

?>