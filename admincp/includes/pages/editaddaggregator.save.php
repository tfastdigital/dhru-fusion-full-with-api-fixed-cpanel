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
if (!$default) {
    echo "error: Please select any one gateway as a default gateway";
    exit;
}
$Gateway = [];
foreach ($gateway as $gat => $limits) {
    if ($default == $gat) {
        $Gat["default"] = 1;
    } else {
        $Gat["default"] = 0;
    }
    if ($gatewayname == $gat) {
        echo "error: Gateway already exist";
        exit;
    }
    $Gat["gateway"] = $gat;
    $Gat["limit"] = $limits;
    $Gat["used"] = $used[$gat];
    $Gateway[] = $Gat;
}
if ($gatewayname && $limit) {
    $Gat["default"] = 0;
    $Gat["gateway"] = $gatewayname;
    $Gat["limit"] = $limit;
    $Gat["used"] = 0;
    if ($default == 1) {
        $Gat["default"] = 1;
    }
    $Gateway[] = $Gat;
    $gateway = json_encode($Gateway);
    dquery("update tblPaymentAggregator set gateway='" . $gateway . "' where aggregatorid='" . $aggregatorid . "'");
    echo "callfunction:editpaymentaggregator:" . $aggregatorid;
} else {
    echo "error: All field required";
}

?>