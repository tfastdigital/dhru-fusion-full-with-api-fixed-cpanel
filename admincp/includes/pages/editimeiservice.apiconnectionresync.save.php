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
include_once ROOTDIR . "/includes/apiserver.fun.php";
$updateonlyserviceprice = 1;
$api = dquery("select distinct(api_server) as api_server\r\n    from tbl_services_imei_api where sid='" . $id . "'");
while ($rapi = mysqli_fetch_assoc($api)) {
    $gateway = $rapi["api_server"];
    if ($gateway == $defaultapi) {
        unset($defaultapi);
    }
    if ($gateway != "" && mysqli_num_rows(dquery("select * from tbl_apiservers\r\nwhere gateway='" . $gateway . "' and setting='username'"))) {
        $apisaveddetails = loadApiModule($gateway, false);
        require_once ROOTDIR . "/modules/apiserver/" . $gateway . ".php";
        syncApi($gateway, false, "services", "");
    }
}
if ($defaultapi && mysqli_num_rows(dquery("select * from tbl_apiservers\r\nwhere gateway='" . $defaultapi . "' and setting='username'"))) {
    $apisaveddetails = loadApiModule($defaultapi, false);
    require_once ROOTDIR . "/modules/apiserver/" . $defaultapi . ".php";
    syncApi($defaultapi, false, "services", "");
}
echo "reload: Data save successfully";

?>