<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
dquery("update tbl_order_imei set fetchapitime='' where order_id='" . $id . "'");
dquery("DELETE FROM tbl_apilog where orderid='" . $id . "' and `result`='Sending'");
$Order = mysqli_fetch_assoc(dquery("select (select API from tbl_services_imei\nwhere id=service_id) as API from tbl_order_imei where order_id='" . $id . "'"));
$WHEREs = "";
if ($config["cron_password"]) {
    $WHEREs .= "&a=" . $config["cron_password"];
}
$SiteAddress = $config["site_address"];
if ($config["config_ssl_allow"]) {
    $SiteAddress = $config["config_ssl_allow"];
}
initCurl($SiteAddress . "/includes/cron.php?action=" . $Order["API"] . "_send&orderid=" . $id . $WHEREs);
echo "selfreload:" . $LNG["datasavesuccessfully"];

?>