<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function getAcceptedServer($start = 0, $limit = 20)
{
    $sql = dquery("SELECT \r\n        order_id,date,server,CONCAT(credit-discount) as total,user_can_c, \r\n        CONCAT((SELECT prefix FROM tbl_currencies where id=tblUsers.default_currency),' ',(credit-discount)) AS curtotal,\r\n        (SELECT `service_name` FROM `tbl_server_log` WHERE `id`=tbl_order_server.service_id) as service,\r\n        (SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_server.user_id) as username\r\n        FROM `tbl_order_server` LEFT OUTER JOIN tblUsers ON\r\n        `tbl_order_server`.user_id = tblUsers.id where user_can_c='1'\r\n        limit " . $start . "," . $limit);
    while ($r = mysqli_fetch_assoc($sql)) {
        $_OUT[] = $r;
    }
    return $_OUT;
}
function getNewServer($start = 0, $limit = 20)
{
    $sql = dquery("SELECT \r\n        order_id,date,server,CONCAT(credit-discount) as total,user_can_c, \r\n        CONCAT((SELECT prefix FROM tbl_currencies where id=tblUsers.default_currency),' ',(credit-discount)) AS curtotal,\r\n        (SELECT `service_name` FROM `tbl_server_log` WHERE `id`=tbl_order_server.service_id) as service,\r\n        (SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_server.user_id) as username\r\n        FROM `tbl_order_server` LEFT OUTER JOIN tblUsers ON\r\n        `tbl_order_server`.user_id = tblUsers.id where user_can_c='0'\r\n        limit " . $start . "," . $limit);
    while ($r = mysqli_fetch_assoc($sql)) {
        $_OUT[] = $r;
    }
    return $_OUT;
}
function getAcceptedFile($start = 0, $limit = 20)
{
    $sql = dquery("SELECT order_id,date,user_can_c, file,CONCAT(credit-discount) as total,\r\n     CONCAT((SELECT prefix FROM tbl_currencies where id=tblUsers.default_currency),' ',(credit-discount)) AS curtotal,\r\n    (SELECT `service_name` FROM `tbl_services_file` WHERE `id`=tbl_order_file.service_id) as service,\r\n    (SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_file.user_id) as username\r\n     FROM `tbl_order_file` LEFT OUTER JOIN tblUsers ON\r\n    `tbl_order_file`.user_id = tblUsers.id where user_can_c='1'\r\n    limit " . $start . "," . $limit);
    while ($r = mysqli_fetch_assoc($sql)) {
        $_OUT[] = $r;
    }
    return $_OUT;
}
function getNewFile($start = 0, $limit = 20)
{
    $sql = dquery("SELECT order_id,user_can_c, date,file,CONCAT(credit-discount) as total,\r\n     CONCAT((SELECT prefix FROM tbl_currencies where id=tblUsers.default_currency),' ',(credit-discount)) AS curtotal,\r\n    (SELECT `service_name` FROM `tbl_services_file` WHERE `id`=tbl_order_file.service_id) as service,\r\n    (SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_file.user_id) as username\r\n     FROM `tbl_order_file` LEFT OUTER JOIN tblUsers ON\r\n    `tbl_order_file`.user_id = tblUsers.id where user_can_c='0'\r\n    limit " . $start . "," . $limit);
    while ($r = mysqli_fetch_assoc($sql)) {
        $_OUT[] = $r;
    }
    return $_OUT;
}
function getAcceptedIMEI($start = 0, $limit = 20)
{
    $sql = dquery("select order_id,user_can_c, ebay,service_id,imei,(select service_name\r\n    from tbl_services_imei where id=service_id) as service,\r\n    date,credit,discount,(select username from tblUsers where id=user_id) as username from \r\n    tbl_order_imei where user_can_c='1' ORDER BY order_id DESC \r\n     limit " . $start . "," . $limit);
    while ($r = mysqli_fetch_assoc($sql)) {
        $_OUT[] = $r;
    }
    return $_OUT;
}
function getNewIMEI($start = 0, $limit = 20)
{
    $sql = dquery("SELECT \r\n            order_id,date,user_can_c, \r\n            IF(tmp_status=9,concat('[App] ',imei),imei) as imei,\r\n            CONCAT(credit-discount) as total,\r\n            CONCAT((credit-discount),' ',(SELECT code FROM tbl_currencies where id=tblUsers.default_currency)) AS curtotal,\r\n            (SELECT `service_name` FROM `tbl_services_imei` WHERE `id`=tbl_order_imei.service_id) as service,\r\n            (SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_imei.user_id) as username\r\n            FROM `tbl_order_imei` LEFT OUTER JOIN tblUsers ON\r\n            `tbl_order_imei`.user_id = tblUsers.id where user_can_c='0'\r\n             limit " . $start . "," . $limit);
    while ($r = mysqli_fetch_assoc($sql)) {
        $_OUT[] = $r;
    }
    return $_OUT;
}
function rebateAdminCredit($uid, $rebatecredit, $rebatesellcredit = "")
{
    include_once ROOTDIR . "/includes/clients.fun.inc.php";
    include_once ROOTDIR . "/includes/invoice.fun.php";
    global $LNG;
    global $precision;
    $clientDetails = getClientsDetails($uid);
    $success = "";
    $error = "";
    $sellcreditlimit = round($sell, $precision);
    $rebatecredit = round($rebatecredit, $precision);
    if ($rebatecredit && 0 < $rebatecredit) {
        $admn = mysqli_fetch_assoc(dquery("select credit from\r\n          tbl_admin where id='" . $aid . "'"));
        $flager = false;
        if (rebateCredit($uid, $rebatecredit, $sendmailcr, "", $admin_noter, $user_noter, $invoice)) {
            if ($_SESSION["system_default_currency"]["id"] != $clientDetails["currency"]["id"]) {
                $convtrtc = convertCurrency($rebatecredit, $clientDetails["currency"]["id"], $_SESSION["system_default_currency"]["id"]);
            } else {
                $convtrtc = $rebatecredit;
            }
            if (0 < $convtrtc && $admin["credit"] != "") {
                $flager = true;
            }
            if ($flager) {
                dquery("update tbl_admin set credit=credit+" . $convtrtc . " where id='" . $aid . "'");
            }
            if ($invoice) {
                dquery("update tbl_invoiceitems set amount=amount-" . $rebatecredit . " \r\n                where invoiceid='" . $invoice . "' and type='AddFunds by Admin'");
                updateInvoiceTotal($invoice);
            }
            $_OUT["MSG"] = $rebatecredit . " " . $LNG["creditsuccessfullyrebate"];
            $_OUT["STATUS"] = "SUCCESS";
        } else {
            $_OUT["MSG"] = (string) $LNG["creditnotrebate"];
            $_OUT["STATUS"] = "ERROR";
        }
    } else {
        if (!$rebatesellcredit) {
            $_OUT["MSG"] = (string) $LNG["creditnotrebate"];
            $_OUT["STATUS"] = "ERROR";
        }
    }
    if ($rebatesellcredit) {
        if (rebateSellCredit($uid, $rebatesellcredit, $sendmailsr)) {
            $_OUT["MSG"] = $rebatesellcredit . " " . $LNG["sellcreditlimitsuccessfullyrebate"];
            $_OUT["STATUS"] = "SUCCESS";
        } else {
            $_OUT["MSG"] = (string) $LNG["sellcreditlimitnotadded"];
            $_OUT["STATUS"] = "ERROR";
        }
    }
    return $_OUT;
}
function addAdminCredit($uid, $credit, $sell = "", $geninvoice = false, $paid = false)
{
    include_once ROOTDIR . "/includes/clients.fun.inc.php";
    include_once ROOTDIR . "/includes/invoice.fun.php";
    global $LNG;
    global $precision;
    $clientDetails = getClientsDetails($uid);
    $success = "";
    $error = "";
    $sellcreditlimit = round($sell, $precision);
    $creditleft = round($credit, $precision);
    if ($sellcreditlimit) {
        if (addSellCredit($uid, $sellcreditlimit, $sendmailsa)) {
            $_OUT["msg"] .= "<li>" . $sellcreditlimit . " " . $LNG["sellcreditlimitsuccessfullyadded"] . "</li>";
        } else {
            $_OUT["msg"] = "<li>" . $sellcreditlimit . " " . $LNG["sellcreditlimitnotadded"] . "</li>";
            $_OUT["STATUS"] = "ERROR";
        }
    }
    if ($creditleft && 0 < $creditleft) {
        $flager = false;
        if ($_SESSION["system_default_currency"]["id"] != $clientDetails["currency"]["id"]) {
            $convtrtc = convertCurrency($creditleft, $clientDetails["currency"]["id"], $_SESSION["system_default_currency"]["id"]);
        } else {
            $convtrtc = $creditleft;
        }
        if (0 < $convtrtc && $admin["credit"] != "") {
            if ($admin["credit"] < $convtrtc) {
                $_OUT["MSG"] = $LNG["notengouthcredit"];
                $_OUT["STATUS"] = "ERROR";
            } else {
                $flager = true;
            }
        }
        if (addCredit($uid, $creditleft, $sendmailca, "", $admin_notea, $user_note)) {
            if ($flager) {
                dquery("update tbl_admin set credit=credit-" . $convtrtc . " where \r\n                id='" . $aid . "'");
            }
            if ($geninvoice) {
                insert_query("tbl_invoiceitems", ["userid" => $uid, "type" => "AddFunds by Admin", "relid" => "", "description" => "+ Add Funds", "amount" => $creditleft, "taxed" => "0", "duedate" => "now()", "paymentmethod" => $paymentmethod]);
                $invoiceid = generateInvoice($uid);
                if ($paid) {
                    processInvoicetoPaid($invoiceid);
                }
            }
            $_OUT["MSG"] .= "<li>" . $creditleft . " " . $LNG["creditsuccessfullyadded"] . "</li>";
            $_OUT["STATUS"] = "SUCCESS";
        } else {
            $_OUT["MSG"] = (string) $LNG["creditnotadded"];
            $_OUT["STATUS"] = "ERROR";
            $success = false;
        }
    } else {
        if (!$sellcreditlimit) {
            $_OUT["MSG"] = (string) $LNG["creditnotadded"];
            $_OUT["STATUS"] = "ERROR";
            $success = false;
        }
    }
    if ($success) {
        $_OUT["MSG"] .= "<strong>" . $LNG["financial"] . "</strong><br>" . $success;
    }
    if ($error) {
        $_OUT["MSG"] = $error;
        $_OUT["STATUS"] = "ERROR";
    }
    return $_OUT;
}
function getLogin($username, $password)
{
    $password = md5(md5($password) . "9486");
    if (mysqli_num_rows(dquery("select id from tbl_admin where username='" . $username . "'\r\n            and password='" . $password . "' and status=0"))) {
        $u = mysqli_fetch_assoc(dquery("select tbl_admin.id,tbl_admin.email,tbl_admin.firstname,\r\n        tbl_admin.lastname,tbl_admin_access_group.access\r\n        from tbl_admin,tbl_admin_access_group where username='" . $username . "'\r\n        and password='" . $password . "' and tbl_admin.group_id=tbl_admin_access_group.id"));
        $access = explode(",", $u["access"]);
        if (!in_array(55, $access)) {
            $_OUT["STATUS"] = "ERROR";
            $_OUT["MSG"] = "You are not alloweded";
        } else {
            $_OUT["EMAIL"] = md5(strtolower(trim($u["email"])));
            $_OUT["FIRST"] = $u["firstname"] ? $u["firstname"] : "";
            $_OUT["LAST"] = $u["lastname"] ? $u["lastname"] : "";
            $_OUT["CID"] = $_SESSION["system_default_currency"]["id"];
            $_OUT["CODE"] = $_SESSION["system_default_currency"]["code"];
            $_OUT["AID"] = $u["id"];
            $_OUT["STATUS"] = "SUCCESS";
            $_OUT["MSG"] = "Server add successfully";
        }
    } else {
        $_OUT["STATUS"] = "ERROR";
        $_OUT["MSG"] = "Wrong Username Or Password";
    }
    return $_OUT;
}

?>