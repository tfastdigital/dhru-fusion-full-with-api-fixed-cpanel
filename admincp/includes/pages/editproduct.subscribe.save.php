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
if ($_POST["status"]) {
    $status = 1;
} else {
    $status = 0;
}
if ($credit && $days) {
    $data["subscribe"] = $status;
    $data["subscribe_credit"] = formatCurrency2($credit);
    $data["subscribe_days"] = $days;
    $data["subscriptionorderlimit"] = $subscriptionorderlimit;
    if ($db->update("tbl_products", $data, "id=" . $id)) {
        echo "success:<li>" . $LNG["datasavesuccessfully"] . "</li><li>" . $success . "</li>";
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["datanotsave"];
}
echo " ";

?>