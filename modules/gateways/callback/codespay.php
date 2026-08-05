<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
include "../../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
include ROOTDIR . "/includes/gateway.fun.php";
include ROOTDIR . "/includes/invoice.fun.php";
$GATEWAY = loadGatewayModule("codespay");
$orgipn = "";
foreach ($_POST as $key => $value) {
    $orgipn .= "" . $key . " => " . $value . " ";
}
if ($cp_status != "VERIFIED") {
    logTransaction("codespay", $orgipn, $cp_status);
} else {
    logTransaction("codespay", $orgipn, "Verified");
    if (strtolower(trim($cp_business)) != strtolower(trim($GATEWAY["business"]))) {
        logTransaction("codespay", $orgipn, "Wrong Business Email");
        exit;
    }
    if (mysqli_num_rows(dquery("select id from tbl_invoices where\r\n     id='" . $cp_custom1 . "'   and status='Unpaid'"))) {
        $amount = mysqli_fetch_assoc(dquery("select sum(amountin) as total\r\n        from tbl_transaction where invoiceid='" . $cp_custom1 . "'"));
        $inv = mysqli_fetch_assoc(dquery("select total,userid\r\n        from tbl_invoices where id='" . $cp_custom1 . "'"));
        $user = mysqli_fetch_assoc(dquery("select username,fraud_protection\r\n        from tbl_user where id='" . $inv["userid"] . "'"));
        if ($user["fraud_protection"]) {
            logTransaction("codespay", $orgipn, "Fraud Protection Enable");
            include_once ROOTDIR . "/includes/mail.fun.php";
            $adminmessage = "Client #ID " . $inv["userid"] . " (" . $user["username"] . ")\r\n            <br><Br> Paid invoice#" . $cp_custom1 . " . \r\n              <br><Br>  This client enable fraud protection so please\r\n               review payment and Pay invoice Manualy .";
            $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("edituser.editinvoice&id=" . $cp_custom1) . "&title=" . base64_encode("Edit Invoice #" . $cp_custom1) . "'>here</a>";
            $adminmessage .= "<br /> <br />\r\n            You can view invoice from " . $here . "\r\n            ";
            sendNotification("account", "Fraud protection [Manually process invoice #" . $cp_custom1 . "]", $adminmessage, "");
        } else {
            if ($amount["total"] < $inv["total"]) {
                logTransaction("codespay", $orgipn, "Successful");
                dquery("update tbl_invoices set businessid='" . $cp_business . "'\r\n                    where id='" . $cp_custom1 . "'");
                addPayment($cp_custom1, $cp_txn, $cp_amount, $cp_fee, "codespay");
            } else {
                logTransaction("codespay", $orgipn, "Invoice Payment Completed");
            }
        }
    } else {
        logTransaction("codespay", $orgipn, "Invoice already Paid");
    }
}

?>