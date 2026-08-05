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
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$validator = NULL;
if ($fastclient) {
    $u = explode("@", $email);
    $username = $u[0];
    $validator["username"] = [$u[0], true];
} else {
    $validator["username"] = [$username, true];
}
if (!$password) {
    $password = generatePassword();
    $link = " Password is - " . $password . " <br />";
}
$admn = mysqli_fetch_assoc(dquery("select credit from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
$flager = false;
if ($_SESSION["system_default_currency"]["id"] != $currency) {
    $convtrtc = convertCurrency($creditleft, $currency, $_SESSION["system_default_currency"]["id"]);
} else {
    $convtrtc = $creditleft;
}
if (0 < $convtrtc && $admn["credit"] != "") {
    if ($admn["credit"] < $convtrtc) {
        echo "error: " . $LNG["notengouthcredit"];
        exit;
    }
    $flager = true;
}
$validator["password"] = [$password, true];
$validator["email"] = [$email, true];
$validator["first_name"] = [$firstname, false];
$validator["last_name"] = [$lastname, false];
$validator["usertype"] = [$type, false];
$validator["credit_transfer"] = [$allowtransfer, false];
$validator["userstatus"] = [$status, false];
$validator["imei_service_access"] = [$imeiaccess, false];
$validator["file_service_access"] = [$fileaccess, false];
$validator["server_log_access"] = [$serveraccess, false];
$validator["shop_service_access"] = [$shopaccess, false];
$validator["alow_remoteservices"] = [$remoteaccess, false];
$validator["company"] = [$company, false];
$validator["contact"] = [$contact, false];
$validator["address1"] = [$address, false];
$validator["address2"] = [$address2, false];
$validator["state"] = [$state, false];
$validator["city"] = [$city, false];
$validator["zip"] = [$zip, false];
$validator["country"] = [$country, false];
$validator["phonenumber"] = [$phonenumber, false];
$validator["default_theme"] = [$template, false];
$validator["language"] = [$language, false];
$validator["currency"] = [$currency, false];
$validator["news_letter"] = [$newsletter, false];
$validator["admin_id"] = [$_SESSION["adminid"], false];
$validator["clientgroup"] = [$clientgroup, false];
$validator["is_registered"] = ["1", false];
if ($paymentgatway) {
    $paymentgatways = implode(",", $paymentgatway);
}
$validator["auto_recharge"] = [$paymentgatways, false];
if ($error = validateProfiles($validator)) {
    echo "error: " . $error;
    exit;
}
if ($error = addNewUser($validator, "", "ADMIN")) {
    echo "error: " . $error;
    exit;
}
$success = "";
$success .= "<li> " . $LNG["datasavesuccessfully"] . "</li>";
$result = dquery("select id from tblUsers where username='" . $username . "'");
$row = mysqli_fetch_assoc($result);
saveCustomFields($row["id"], $customfield);
if ($creditleft != "0") {
    if ($flager) {
        dquery("update tbl_admin set \n        credit=credit-" . $convtrtc . " where id='" . $_SESSION["adminid"] . "'");
    }
    if ($geninvoice) {
        insert_query("tbl_invoiceitems", ["userid" => $row["id"], "type" => "AdminAddFunds", "relid" => "", "description" => $LNG["addfund"], "amount" => $creditleft, "taxed" => "0", "duedate" => "now()", "paymentmethod" => $paymentmethod]);
        require ROOTDIR . "/includes/invoice.fun.php";
        $invoiceid = generateInvoice($row["id"]);
        if ($invpaid) {
            processInvoicetoPaid($invoiceid);
        }
    }
    if (addCredit($row["id"], $creditleft, $sendmail)) {
        $success .= "<li>" . $LNG["creditsuccessfullyadded"] . "</li>";
    }
    if ($type == "1" && addSellCredit($row["id"], $creditleft, $sendmail)) {
        $success .= "<li>" . $LNG["creditsuccessfullyadded"] . "</li>";
    }
}
echo "success: " . $link . " " . $success;
function generatePassword($length = 8)
{
    $password = "";
    $possible = "123456789ABCDFGHJKLMNPQRTVWXYZ";
    $maxlength = strlen($possible);
    if ($maxlength < $length) {
        $length = $maxlength;
    }
    $i = 0;
    while ($i < $length) {
        $char = substr($possible, mt_rand(0, $maxlength - 1), 1);
        if (!strstr($password, $char)) {
            $password .= $char;
            $i++;
        }
    }
    return $password;
}

?>