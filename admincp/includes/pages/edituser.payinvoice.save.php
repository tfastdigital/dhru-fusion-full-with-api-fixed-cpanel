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
require ROOTDIR . "/includes/invoice.fun.php";
if (!$amount) {
    echo "error:<li>" . $LNG["amount"] . " " . $LNG["must"] . " " . $LNG["required"] . "</li>";
} else {
    if ($amount <= $applied) {
        global $adminAddPayment;
        $adminAddPayment = true;
        addPayment($invoiceid, $transId, $amount, $fees, $gateway, $sendmail);
        echo "success:<li>" . $LNG["add"] . " " . $LNG["payment"] . " " . $LNG["successfully"] . "</li>";
    } else {
        echo "error:<li>" . $LNG["youcantpaymore"] . "</li>";
    }
}

?>