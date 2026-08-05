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
include ROOTDIR . "/includes/mail.fun.php";
$postipn = "cmd=_notify-validate";
$orgipn = "";
if (count($_POST)) {
    $sandbox = false;
    $postipn = "cmd=_notify-validate";
    $orgipn = "";
    foreach ($_POST as $key => $value) {
        $orgipn .= "" . $key . " => " . $value . " ";
        $postipn .= "&" . $key . "=" . urlencode(stripslashes($value));
    }
    if (!$sandbox && stripos($postipn, "sandbox") !== false) {
        logTransaction("paypal ebay", $orgipn, "Sandbox Not Allowed");
        exit;
    }
    if ($sandbox) {
        $_paypal_link = "https://ipnpb.sandbox.paypal.com/cgi-bin/webscr";
    } else {
        $_paypal_link = "https://ipnpb.paypal.com/cgi-bin/webscr";
    }
    $ch = curl_init($_paypal_link);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postipn);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Connection: Close"]);
    $reply = curl_exec($ch);
    curl_close($ch);
    if ($reply) {
        $payment_status = $_POST["payment_status"];
        if (stripos($payment_status, "Completed") !== false) {
            if (!$_POST["item_number1"] && !$_POST["item_number"]) {
                exit;
            }
            if (deregi("Refunded", $reply) || deregi("refund", $reply) || $_POST["payment_status"] == "Refunded" || $_POST["payment_status"] == "refunded") {
                logTransaction("paypal ebay", $orgipn, "Refunded");
                exit;
            }
            if (deregi("Reversed", $reply) || $_POST["payment_status"] == "Reversed" || $_POST["payment_status"] == "Reversed") {
                logTransaction("paypal ebay", $orgipn, "Reversed");
                exit;
            }
            if (deregi("dispute", $orgipn)) {
                logTransaction("paypal ebay", $orgipn, "Dispute found");
                exit;
            }
            if (mysqli_num_rows(dquery("SELECT * FROM tbl_transaction WHERE  transid LIKE '%" . $_POST["txn_id"] . "%'"))) {
                logTransaction("paypal ebay", $orgipn, "txn found again");
                exit;
            }
            if (stripos($reply, "VERIFIED") !== false || stripos($reply, "verified") !== false) {
                logTransaction("paypal", $orgipn, "Verified", "invoice", $TmpInvoiceNo);
                logTransaction("paypal ebay", $orgipn, "four");
                $payment_status = $_POST["payment_status"];
                $subscr_id = $_POST["subscr_id"];
                $txn_type = $_POST["txn_type"];
                $txn_id = $_POST["txn_id"];
                $mc_gross = $_POST["mc_gross"];
                $mc_fee = $_POST["mc_fee"];
                $idnumber = $_POST["custom"];
                $paypalcurrency = $_REQUEST["mc_currency"];
                $item_number = $_POST["item_number"];
                $newarr = [];
                for ($i = 1; $i <= 11; $i++) {
                    if (${"item_number" . $i}) {
                        $e = ${"item_number" . $i};
                        $s = mysqli_fetch_assoc(dquery("select id,service_name from tbl_services_imei \n            where ebay_code LIKE '" . $e . "' OR ebay_code LIKE '" . $e . ",%' OR\n            ebay_code LIKE '%," . $e . "' OR ebay_code LIKE '%," . $e . ",%'"));
                        if ($s["id"]) {
                            if ($newarr[$s["id"]]) {
                                $newarr[$s["id"]] = $newarr[$s["id"]] + ${"quantity" . $i};
                            } else {
                                $newarr[$s["id"]] = ${"quantity" . $i};
                            }
                        }
                    }
                }
                if (!isset($_POST["item_number1"])) {
                    $e = trim($item_number);
                    if ($e) {
                        $s = mysqli_fetch_assoc(dquery("select id,service_name from\n                tbl_services_imei where ebay_code LIKE '" . $e . "' OR \n                ebay_code LIKE '" . $e . ",%' OR ebay_code LIKE '%," . $e . "' OR\n                ebay_code LIKE '%," . $e . ",%'"));
                        if ($s["id"]) {
                            if ($newarr[$s["id"]]) {
                                $newarr[$s["id"]] = $newarr[$s["id"]] + ($quantity ? $quantity : 1);
                            } else {
                                $newarr[$s["id"]] = $quantity ? $quantity : 1;
                            }
                        }
                    }
                }
                if ($newarr) {
                    foreach ($newarr as $k => $qnt) {
                        $payer_email = $_POST["payer_email"];
                        if (!trim($payer_email) && $config["ebaypaypaluser"] && $config["ebaypaypalpass"] && $config["ebaypaypalsignature"]) {
                            if ($sandbox) {
                                $url = "https://api-3t.sandbox.paypal.com/nvp";
                            } else {
                                $url = "https://api-3t.paypal.com/nvp";
                            }
                            $postfields = [];
                            $postfields["VERSION"] = "3.0";
                            $postfields["METHOD"] = urlencode("GetTransactionDetails");
                            $postfields["USER"] = urlencode(trim($config["ebaypaypaluser"]));
                            $postfields["PWD"] = urlencode(trim($config["ebaypaypalpass"]));
                            $postfields["SIGNATURE"] = urlencode(trim($config["ebaypaypalsignature"]));
                            $postfields["TransactionID"] = urlencode(trim($txn_id));
                            $result = initCurl($url, $postfields);
                            $resultsarray2 = explode("&", $result);
                            $resultsarray = [];
                            foreach ($resultsarray2 as $line) {
                                $line = explode("=", $line);
                                $resultsarray[$line[0]] = urldecode(trim($line[1]));
                            }
                            logTransaction("paypal ebay", json_encode($resultsarray), "Get Payer email", "ebay", $pid);
                            $payer_email = $resultsarray["EMAIL"];
                        }
                        if ($payer_email) {
                            $s = mysqli_fetch_assoc(dquery("select id,service_name \n            from tbl_services_imei where id='" . $k . "'"));
                            $uni = str_replace(",", "", $item_number) . rand(999, 99999);
                            $data["email"] = $payer_email;
                            $data["sid"] = $s["id"];
                            $data["cid"] = $paypalcurrency;
                            $data["uid"] = $uni;
                            $data["qnt"] = $qnt;
                            $data["date"] = date("Y-m-d");
                            $pid = $db->insert("tbl_private_order", $data);
                            $toemails[] = ["to" => $payer_email];
                            $email_merge_fields["service"] = $s["service_name"];
                            $email_merge_fields["link"] = ($config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"]) . "\\directorder.php?id=" . md5(sha1($uni));
                            sendMail(68, "", "", $email_merge_fields, true, "", "", "", $toemails);
                            $logs = "\n            Email : " . $payer_email . " \n            Transaction ID : " . $txn_id . "\n            Date :" . date("Y-m-d H:i:s") . "\n            PID  : " . $pid . "            \n            Link : " . $email_merge_fields["link"];
                            logTransaction("paypal ebay", $logs, "Link Generated", "ebay", $pid);
                        } else {
                            logTransaction("paypal ebay", "No Payer Email Found", "Link Not Generated", "ebay", $pid);
                        }
                    }
                }
            } else {
                if (!$config["directunverified"]) {
                }
                logTransaction("paypal ebay", $reply, "third");
                if (deregi("INVALID", $reply)) {
                    logTransaction("paypal ebay", $orgipn, "Invalid");
                    exit;
                }
                if (deregi("unverified", $reply)) {
                    logTransaction("paypal ebay", $orgipn, "Unverified");
                    exit;
                }
                logTransaction("paypal ebay", $orgipn, "Not Verified");
                exit;
            }
        } else {
            logTransaction("paypal ebay", $orgipn, "Payment Status " . $payment_status);
            exit;
        }
    } else {
        logTransaction("paypal ebay", "Unable to verify IPN", "Error");
    }
} else {
    logTransaction("paypal ebay", "No IPN data found", "Error");
    exit;
}

?>