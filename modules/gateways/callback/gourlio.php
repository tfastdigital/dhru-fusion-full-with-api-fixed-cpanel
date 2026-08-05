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
$GATEWAY = loadGatewayModule("gourlio");
$cryptobox_private_keys = [$GATEWAY["private_key"]];
define("CRYPTOBOX_PRIVATE_KEYS", implode("^", $cryptobox_private_keys));
require_once ROOTDIR . "/modules/gateways/gourl/gourl.class.php";
$valid_key = false;
if (isset($_POST["private_key_hash"]) && strlen($_POST["private_key_hash"]) == 128 && preg_replace("/[^A-Za-z0-9]/", "", $_POST["private_key_hash"]) == $_POST["private_key_hash"]) {
    $keyshash = [];
    $arr = explode("^", CRYPTOBOX_PRIVATE_KEYS);
    foreach ($arr as $v) {
        $keyshash[] = strtolower(hash("sha512", $v));
    }
    if (in_array(strtolower($_POST["private_key_hash"]), $keyshash)) {
        $valid_key = true;
    }
}
if (!$valid_key && isset($_POST["json"]) && $_POST["json"] == "1") {
    $data_hash = $boxID = "";
    if (isset($_POST["data_hash"]) && strlen($_POST["data_hash"]) == 128 && preg_replace("/[^A-Za-z0-9]/", "", $_POST["data_hash"]) == $_POST["data_hash"]) {
        $data_hash = strtolower($_POST["data_hash"]);
        unset($_POST["data_hash"]);
    }
    if (isset($_POST["box"]) && is_numeric($_POST["box"]) && 0 < $_POST["box"]) {
        $boxID = intval($_POST["box"]);
    }
    if ($data_hash && $boxID) {
        $private_key = "";
        $arr = explode("^", CRYPTOBOX_PRIVATE_KEYS);
        foreach ($arr as $v) {
            if (strpos($v, $boxID . "AA") === 0) {
                $private_key = $v;
            }
        }
        if ($private_key) {
            $data_hash2 = strtolower(hash("sha512", $private_key . json_encode($_POST) . $private_key));
            if ($data_hash == $data_hash2) {
                $valid_key = true;
            }
        }
        unset($private_key);
    }
    if (!$valid_key) {
        exit("Error! Invalid Json Data sha512 Hash!");
    }
}
if ($_POST) {
    foreach ($_POST as $k => $v) {
        if (is_string($v)) {
            $_POST[$k] = trim($v);
        }
    }
}
if (isset($_POST["plugin_ver"]) && !isset($_POST["status"]) && $valid_key) {
    echo "cryptoboxver_" . (CRYPTOBOX_WORDPRESS ? "wordpress_" . GOURL_VERSION : "php_" . CRYPTOBOX_VERSION);
    exit;
}
if (isset($_POST["status"]) && in_array($_POST["status"], ["payment_received", "payment_received_unrecognised"]) && $_POST["box"] && is_numeric($_POST["box"]) && 0 < $_POST["box"] && $_POST["amount"] && is_numeric($_POST["amount"]) && 0 < $_POST["amount"] && $valid_key) {
    foreach ($_POST as $k => $v) {
        if ($k == "datetime") {
            $mask = "/[^0-9\\ \\-\\:]/";
        } else {
            if (in_array($k, ["err", "date", "period"])) {
                $mask = "/[^A-Za-z0-9\\.\\_\\-\\@\\ ]/";
            } else {
                $mask = "/[^A-Za-z0-9\\.\\_\\-\\@]/";
            }
        }
        if ($v && preg_replace($mask, "", $v) != $v) {
            $_POST[$k] = "";
        }
    }
    if (!$_POST["amountusd"] || !is_numeric($_POST["amountusd"])) {
        $_POST["amountusd"] = 0;
    }
    if (!$_POST["confirmed"] || !is_numeric($_POST["confirmed"])) {
        $_POST["confirmed"] = 0;
    }
    $dt = gmdate("Y-m-d H:i:s");
    $obj = run_sql("select paymentID, txConfirmed from crypto_payments where boxID = " . intval($_POST["box"]) . " && orderID = '" . addslashes($_POST["order"]) . "' && userID = '" . addslashes($_POST["user"]) . "' && txID = '" . addslashes($_POST["tx"]) . "' && amount = " . floatval($_POST["amount"]) . " && addr = '" . addslashes($_POST["addr"]) . "' limit 1");
    $paymentID = $obj ? $obj->paymentID : 0;
    $txConfirmed = $obj ? $obj->txConfirmed : 0;
    if (!$paymentID) {
        $sql = "INSERT INTO crypto_payments (boxID, boxType, orderID, userID, countryID, coinLabel, amount, amountUSD, unrecognised, addr, txID, txDate, txConfirmed, txCheckDate, recordCreated)\n\t\t\t\tVALUES (" . intval($_POST["box"]) . ", '" . addslashes($_POST["boxtype"]) . "', '" . addslashes($_POST["order"]) . "', '" . addslashes($_POST["user"]) . "', '" . addslashes($_POST["usercountry"]) . "', '" . addslashes($_POST["coinlabel"]) . "', " . floatval($_POST["amount"]) . ", " . floatval($_POST["amountusd"]) . ", " . ($_POST["status"] == "payment_received_unrecognised" ? 1 : 0) . ", '" . addslashes($_POST["addr"]) . "', '" . addslashes($_POST["tx"]) . "', '" . addslashes($_POST["datetime"]) . "', " . intval($_POST["confirmed"]) . ", '" . $dt . "', '" . $dt . "')";
        $paymentID = run_sql($sql);
        $box_status = "cryptobox_newrecord";
    } else {
        if ($_POST["confirmed"] && !$txConfirmed) {
            $sql = "UPDATE crypto_payments SET txConfirmed = 1, txCheckDate = '" . $dt . "' WHERE paymentID = " . intval($paymentID) . " LIMIT 1";
            run_sql($sql);
            $box_status = "cryptobox_updated";
        } else {
            $box_status = "cryptobox_nochanges";
        }
    }
    if (in_array($box_status, ["cryptobox_newrecord", "cryptobox_updated"]) && function_exists("cryptobox_new_payment")) {
        cryptobox_new_payment($paymentID, $_POST, $box_status);
    }
} else {
    $box_status = "Only POST Data Allowed";
}
echo $box_status;

?>