<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$parameter = preg_replace("/[^-0-9a-zA-Z.]/i", "", $_POST["parameter"]);
$values = preg_replace("/[^0-9a-zA-Z.]/i", "", $_POST["values"]);
$user = explode("-", $parameter);
foreach ($user as $u) {
    $u = trim($u);
    if ($u) {
        if ($values == "REMOVE") {
            dquery("DELETE FROM tblUsers where username='" . $u . "'");
        } else {
            dquery("update tblUsers set userstatus='0' where username='" . $u . "'");
        }
    }
}
$reply["STATUS"] = "SUCCESS";
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>