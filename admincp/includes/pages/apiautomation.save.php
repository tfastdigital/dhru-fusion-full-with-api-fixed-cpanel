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
foreach ($priceincrease as $group => $val) {
    if (!$val["price"]) {
        echo "error: All price required";
        exit;
    }
}
$i = 0;
$q = dquery("select * from tbl_services_imei where API='" . $apiid . "'");
while ($r = mysqli_fetch_assoc($q)) {
    $credit = mysqli_fetch_assoc(dquery("select credits from tbl_apiserversservices\r\n    WHERE gateway='" . $r["API"] . "' and id='" . $r["API_ID"] . "'"));
    if ($credit["credits"]) {
        $DATA["autoapi"] = 1;
        $db->update("tbl_services_imei", $DATA, "id='" . $r["id"] . "'");
        $i++;
        unset($DATA);
        foreach ($priceincrease as $group => $val) {
            saveAPIIncreament($r["id"], $group, $val["price"], $val["increaseby"], 0);
        }
    }
}
saveAPiSettings($apiid, "priceincrease", json_encode($priceincrease));
echo "success: Automation save and applied on <b>" . $i . "</b> services";
function saveAPIIncreament($serviceid, $group, $price = "", $increaseby, $pricingqntid = 0)
{
    global $db;
    $q = dquery("select id from tbl_group_api_price\r\n    where service_id='" . $serviceid . "' and group_id='" . $group . "'\r\n    and pricingqntid='" . $pricingqntid . "'");
    $row = mysqli_fetch_assoc($q);
    if (0 < $row["id"]) {
        if (!$price) {
            dquery("DELETE from  tbl_group_api_price where id='" . $row["id"] . "'");
        } else {
            $DATA["price"] = $price;
            $DATA["increaseby"] = $increaseby;
            $db->update("tbl_group_api_price", $DATA, "id='" . $row["id"] . "'");
            $LASTTIME["lastupdatedtime"] = time();
            $db->update("tbl_services_imei", $LASTTIME, " id='" . $serviceid . "'");
        }
    } else {
        if ($price != "") {
            $DATA["service_id"] = $serviceid;
            $DATA["group_id"] = $group;
            $DATA["price"] = $price;
            $DATA["increaseby"] = $increaseby;
            $DATA["pricingqntid"] = $pricingqntid;
            $db->insert("tbl_group_api_price", $DATA);
            $LASTTIME["lastupdatedtime"] = time();
            $LASTTIME["prev_price"] = 1;
            $db->update("tbl_services_imei", $LASTTIME, " id='" . $serviceid . "'");
        }
    }
}

?>