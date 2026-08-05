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
if ($aggregatorname && 0 < count($gateway)) {
    $g = explode(",", $gatewaylist);
    $Gateway = [];
    foreach ($gateway as $gat => $limit) {
        $Gat["gateway"] = $gat;
        $Gat["limit"] = $limit;
        $Gateway[] = $Gat;
    }
    $DATA["aggregatorname"] = $aggregatorname;
    $DATA["gateway"] = json_encode($Gateway);
    $DATA["apikey"] = getuiid(20);
    $newsid = $db->insert("tblPaymentAggregator", $DATA);
    echo "callfunction:editpaymentaggregator:" . $newsid;
} else {
    echo "error: Required field should not blank";
}
function getUIID($n)
{
    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randomString = "";
    for ($i = 1; $i <= $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
        if ($i % 4 == 0) {
            $randomString .= "-";
        }
    }
    return trim($randomString, "-");
}

?>