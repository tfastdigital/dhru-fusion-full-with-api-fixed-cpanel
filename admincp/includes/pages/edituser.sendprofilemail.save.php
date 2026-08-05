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
include ROOTDIR . "/includes/mail.fun.php";
if ($imeiordermail) {
    $email_merge_fields["servicetype"] = "IMEI";
    $OrderDtl = mysqli_fetch_assoc(dquery("SELECT `order_id`,server\n    (select service_name from tbl_services_imei where id=service_id) as service_name,imei,reply,`comments`\n    FROM `tbl_order_imei` WHERE order_id='" . $id . "'"));
    if ($OrderDtl["server"] == 1) {
        $email_merge_fields["servicetype"] = "Server";
    }
    $email_merge_fields["orderid"] = $OrderDtl["order_id"];
    $email_merge_fields["service"] = $OrderDtl["service_name"];
    $email_merge_fields["reply"] = $OrderDtl["reply"];
    $email_merge_fields["reason"] = $OrderDtl["reply"];
    $email_merge_fields["imei"] = $OrderDtl["imei"];
    $email_merge_fields["comments"] = $OrderDtl["comments"];
    sendMail($imeiordermail, $uid, $id, $email_merge_fields, true, "", "", "", "", "", true);
    echo "success:" . $LNG["email"] . " " . $LNG["send"] . " " . $LNG["successfully"];
} else {
    if ($fileordermail) {
        $email_merge_fields["servicetype"] = "File";
        $OrderDtl = mysqli_fetch_assoc(dquery("SELECT `order_id`,\n    (select service_name from tbl_services_file where id=service_id) as service_name,reply,`comments`\n    FROM `tbl_order_file` WHERE order_id='" . $id . "'"));
        $email_merge_fields["orderid"] = $OrderDtl["order_id"];
        $email_merge_fields["service"] = $OrderDtl["service_name"];
        $email_merge_fields["reply"] = $OrderDtl["reply"];
        $email_merge_fields["reason"] = $OrderDtl["reply"];
        $email_merge_fields["comments"] = $OrderDtl["comments"];
        sendMail($fileordermail, $uid, $id, $email_merge_fields, true, "", "", "", "", "", true);
        echo "success:" . $LNG["email"] . " " . $LNG["send"] . " " . $LNG["successfully"];
    } else {
        if ($productordermail) {
            $email_merge_fields["servicetype"] = "Product";
            $OrderDtl = mysqli_fetch_assoc(dquery("SELECT `order_id`,gatway,\n    (select service_name from tbl_products where id=service_id) as service_name,reply,`comments`\n    FROM `tbl_order_product` WHERE order_id='" . $id . "'"));
            $email_merge_fields["orderid"] = $OrderDtl["order_id"];
            $email_merge_fields["service"] = $OrderDtl["service_name"];
            $email_merge_fields["reply"] = $OrderDtl["reply"];
            $email_merge_fields["reason"] = $OrderDtl["reply"];
            $email_merge_fields["trackingid"] = $OrderDtl["reply"];
            $gatwaydetail = mysqli_fetch_assoc(dquery("select `trackingurl`,`value` from tbl_shipping_services where `id`='" . $OrderDtl["gatway"] . "'"));
            $email_merge_fields["trackingurl"] = $gatwaydetail["trackingurl"];
            $email_merge_fields["shipping_gatway"] = $gatwaydetail["value"];
            $email_merge_fields["comments"] = $OrderDtl["comments"];
            sendMail($productordermail, $uid, $id, $email_merge_fields, true, "", "", "", "", "", true);
            echo "success:" . $LNG["email"] . " " . $LNG["send"] . " " . $LNG["successfully"];
        } else {
            if ($serverordermail) {
                $email_merge_fields["servicetype"] = "Server";
                $OrderDtl = mysqli_fetch_assoc(dquery("SELECT `order_id`,\n        (select service_name from tbl_server_log where id=service_id) as service_name,reply,`comments`\n         FROM `tbl_order_server` WHERE order_id='" . $id . "'"));
                $email_merge_fields["orderid"] = $OrderDtl["order_id"];
                $email_merge_fields["service"] = $OrderDtl["service_name"];
                $email_merge_fields["reply"] = $OrderDtl["reply"];
                $email_merge_fields["reason"] = $OrderDtl["reply"];
                $email_merge_fields["comments"] = $OrderDtl["comments"];
                sendMail($serverordermail, $uid, $id, $email_merge_fields, true, "", "", "", "", "", true);
                echo "success:" . $LNG["email"] . " " . $LNG["send"] . " " . $LNG["successfully"];
            } else {
                if ($profilemail2) {
                    sendMail($profilemail2, $id, "", "", true, "", "", "", "", "", true);
                    echo "success:" . $LNG["email"] . " " . $LNG["send"] . " " . $LNG["successfully"];
                } else {
                    if ($profilemail) {
                        sendMail($profilemail, $id, "", "", true, "", "", "", "", "", true);
                        echo "success:" . $LNG["email"] . " " . $LNG["send"] . " " . $LNG["successfully"];
                    } else {
                        if ($invoicemail) {
                            $inv = mysqli_fetch_assoc(dquery("select * from tbl_invoices where id='" . $invoiceid . "'"));
                            if ($inv["status"] == "Unpaid") {
                                $invoicenum = "P/" . $inv["mask"];
                            } else {
                                $invoicenum = "I/" . $inv["mask"];
                            }
                            $email_merge_fields["invoiceid"] = $invoicenum;
                            $email_merge_fields["invid"] = $invoiceid;
                            $email_merge_fields["invoice"] = $invoiceid;
                            sendMail($invoicemail, $uid, "", $email_merge_fields, true, "", "", "", "", "", true);
                            echo "success:" . $LNG["email"] . " " . $LNG["send"] . " " . $LNG["successfully"];
                        } else {
                            echo "error:" . $LNG["select_"] . " " . $LNG["email"];
                        }
                    }
                }
            }
        }
    }
}

?>