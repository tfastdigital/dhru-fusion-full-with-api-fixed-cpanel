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
if ($purchase) {
    foreach ($purchase as $k => $v) {
        if ($v) {
            if (mysqli_num_rows(dquery("select id from tbl_purchase_cost \n                where cid='" . $k . "' and sid='" . $id . "' and type='imei'"))) {
                $data["price"] = $v;
                $db->update("tbl_purchase_cost", $data, "sid='" . $id . "' and type='imei' and cid='" . $k . "'");
                $data = NULL;
            } else {
                $data["price"] = $v;
                $data["cid"] = $k;
                $data["sid"] = $id;
                $data["type"] = "imei";
                $db->insert("tbl_purchase_cost", $data);
                $data = NULL;
            }
        }
    }
}
$data["purchase_cost"] = formatCurrency2($purchasecost);
$data["stock"] = $currentstock;
$data["stock_allow"] = $calculation;
$data["lastupdatedtime"] = time();
if ($db->update("tbl_services_imei", $data, "id=" . $id)) {
    echo "success:" . $LNG["datasavesuccessfully"];
} else {
    echo "error:" . $LNG["datanotsave"];
}
echo " ";

?>