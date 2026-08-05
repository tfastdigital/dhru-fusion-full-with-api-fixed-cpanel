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
    echo "debug: Default gateway required";
    exit;
}
if ($default == 1) {
    echo "error: Default gateway required";
    exit;
}
$ip = explode("\n", $ip);
$currect = false;
$buff = "";
foreach ($ip as $i) {
    $i = trim($i);
    if ($i) {
        if (preg_match("/^([0-9]{1,3}\\.){2}([0-9*]{1,3}\\.)[0-9*]{1,3}\$/", trim($i))) {
            $currect = true;
            $buff .= trim($i) . "\n";
        } else {
            echo "error:" . $i . " " . $LNG["wrongip"];
            exit;
        }
    }
}
foreach ($gateway as $gat => $limit) {
    $Gat["default"] = 0;
    $Gat["gateway"] = $gat;
    $Gat["limit"] = $limit;
    $Gat["used"] = $used[$gat];
    if ($default == $gat) {
        $Gat["default"] = 1;
    }
    $Gateway[] = $Gat;
}
$DATA["aggregatorname"] = $aggregatorname;
$DATA["gateway"] = json_encode($Gateway);
$DATA["ip"] = trim($buff);
$db->update("tblPaymentAggregator", $DATA, "aggregatorid='" . $aggregatorid . "'");
echo "success: Aggregator updated successfully";

?>