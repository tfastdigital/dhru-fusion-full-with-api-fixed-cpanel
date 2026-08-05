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
if ($invoiceid) {
    if ($config["slack_directinvoicestatus"]) {
        $_cols[0]["titel"] = "INV #" . $invoiceid;
        $_cols[0]["text"] = "Cancel";
        SlackSendMsg($config["slack_directinvoicestatus"], "Direct Invoice Status Change", "danger", $_cols, true);
    }
    dquery("update tbl_invoices set status='Cancel' where id='" . $invoiceid . "'");
    echo "success:" . $LNG["status"] . " " . $LNG["changed"] . " " . $LNG["successfully"];
}

?>