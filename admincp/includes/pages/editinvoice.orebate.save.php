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
include_once ROOTDIR . "/includes/clients.fun.inc.php";
if ($invoiceid) {
    $inv = mysqli_fetch_assoc(dquery("select userid,subtotal,shippingtax,taxrate,total,mask,id from tbl_invoices\nwhere id='" . $invoiceid . "'"));
    if ($inv["total"] == 0 && 0 < $inv["subtotal"]) {
        $inv["total"] = $inv["subtotal"] + $inv["shippingtax"];
    }
    $Total = $inv["total"];
    $Tax = $inv["taxrate"];
    $Taxable = round($inv["subtotal"], 2);
    $admin_noter = "For Invoice P/" . $inv["mask"] . " Ref #" . $invoiceid;
    $iq = mysqli_fetch_assoc(dquery("select sum(amount) as amts from tbl_invoiceitems where invoiceid='" . $invoiceid . "'"));
    if (rebateCredit($inv["userid"], $Taxable, 1, "", $admin_noter, "", $invoiceid)) {
        dquery("update tbl_invoices set status='Cancel' where id='" . $invoiceid . "'");
    }
    echo "success:" . $LNG["status"] . " " . $LNG["changed"] . " " . $LNG["successfully"];
}

?>