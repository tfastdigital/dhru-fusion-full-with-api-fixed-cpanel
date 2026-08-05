<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$parameter = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["parameter"]);
$search = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["search"]);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='config'"));
$config = unserialize($sql["value"]);
if ($search == "MAINTENANCE") {
    $config["config_is_under_maintanance"] = $parameter;
}
if ($search == "SUPPORT") {
    $config["supportticketservice"] = $parameter;
}
$config = serialize($config);
$reply["STATUS"] = "SUCCESS";
$reply["MESSAGE"] = "Settings saved successfully";
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>