<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$RETURN = deleteQntRange($pricingqntid, $productid);
function deleteQntRange($pricingqntid, $productid = "")
{
    global $conn;
    if ($pricingqntid && $productid) {
        $conn->query("DELETE from tbl_service_pricing\n        where pricingqntid='" . $pricingqntid . "'\n        and  serviceid='" . $productid . "'");
        $conn->query("DELETE from tbl_group_api_price\n        where pricingqntid='" . $pricingqntid . "'\n        and  service_id='" . $productid . "'");
        $RETURN["status"] = "success";
        $RETURN["msg"] = "Deleted successfully";
        $RETURN["status"] = "success";
    }
    return $RETURN;
}

?>