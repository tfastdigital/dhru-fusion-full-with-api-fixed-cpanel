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
$Status = "new";
$q = dquery("select service_id,group_concat(order_id) as oids from tbl_order_product where invoiceid='" . $orderid . "'\ngroup by service_id order by order_id asc");
while ($r = mysqli_fetch_assoc($q)) {
    if ($itemtype[$r["service_id"]] == 3) {
        dquery("update tbl_order_product set mep='3' where service_id='" . $r["service_id"] . "'\nand invoiceid='" . $orderid . "'");
        $orders = explode(",", $r["oids"]);
        foreach ($orders as $orderd) {
            $DATA["tracking"] = $tracking[$r["service_id"]][$orderd];
            $DATA["status"] = $orderstatus[$r["service_id"]][$orderd];
            $DATA["note"] = $usernotes[$r["service_id"]][$orderd];
            $DATA["shipped_by"] = $currier[$r["service_id"]][$orderd];
            $db->update("tbl_order_product", $DATA, " order_id='" . $orderd . "' and  service_id='" . $r["service_id"] . "' and invoiceid='" . $orderid . "'");
        }
    } else {
        dquery("update tbl_order_product set mep='1' where service_id='" . $r["service_id"] . "'\nand invoiceid='" . $orderid . "'");
        $DATA["tracking"] = $trackings[$r["service_id"]];
        $DATA["status"] = $orderstatuss[$r["service_id"]];
        $DATA["note"] = $usernotess[$r["service_id"]];
        $DATA["shipped_by"] = $curriers[$r["service_id"]];
        $db->update("tbl_order_product", $DATA, " service_id='" . $r["service_id"] . "' and invoiceid='" . $orderid . "'");
    }
}
unset($DATA);
updateRetailOrderStatusbyOrderID("", $orderid);
$DATA["notes"] = $notes;
$db->update("tbl_invoices", $DATA, "id='" . $orderid . "'");
unset($DATA);
echo "success: Order Updated";

?>