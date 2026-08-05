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
if ($amount) {
    $data["aid"] = $id;
    $data["amount"] = $amount;
    $data["ptype"] = $ptype;
    $data["time"] = time();
    $data["note"] = $note;
    $data["transactionid"] = $transactionid;
    if ($db->insert("tbl_affiliate_payout", $data)) {
        dquery("UPDATE tblUsers SET affiliate_payout=affiliate_payout+" . $amount . " where id='" . $id . "'");
        if ($ptype == "addtocredit") {
            include_once ROOTDIR . "/includes/clients.fun.inc.php";
            addCredit($id, $amount, true, "", $note);
        }
        echo "reload:" . $LNG["datasavesuccessfully"];
    } else {
        echo "error:" . $LNG["datanotsave"];
    }
} else {
    echo "error:" . $LNG["fieldblank"];
}

?>