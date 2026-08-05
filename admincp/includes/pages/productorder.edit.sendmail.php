<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
include "../../../comm.php";
include ROOTDIR . "/includes/mail.fun.php";
require_once "../../../includes/fun.inc.php";
require_once "../../includes/fun.inc.php";
if ($productordermail) {
    $email_merge_fields["servicetype"] = "Product";
    $OrderDtl = mysqli_fetch_assoc(dquery("SELECT `order_id`,gatway,\n        (select service_name from tbl_products where id=service_id) as service_name,reply,`comments`\n         FROM `tbl_order_product` WHERE order_id='" . $id . "'"));
    $email_merge_fields["orderid"] = $OrderDtl["order_id"];
    $email_merge_fields["service"] = $OrderDtl["service_name"];
    $email_merge_fields["reply"] = $OrderDtl["reply"];
    $email_merge_fields["reason"] = $OrderDtl["reply"];
    $email_merge_fields["trackingid"] = $OrderDtl["reply"];
    $gatwaydetail = mysqli_fetch_assoc(dquery("select `trackingurl`,`value` from tbl_shipping_services where `id`='" . $OrderDtl["gatway"] . "'"));
    $email_merge_fields["trackingurl"] = str_replace("[TID]", $OrderDtl["reply"], $gatwaydetail["trackingurl"]);
    $email_merge_fields["shipping_gatway"] = $gatwaydetail["value"];
    $email_merge_fields["comments"] = $OrderDtl["comments"];
    sendMail($productordermail, $uid, $id, $email_merge_fields, true, "", "", "", "", "", true);
    echo "success:" . $LNG["email"] . " " . $LNG["send"] . " " . $LNG["successfully"];
} else {
    echo "error:" . $LNG["select_"] . " " . $LNG["email"];
}
$fileverioncheck = "6.1.0";

?>