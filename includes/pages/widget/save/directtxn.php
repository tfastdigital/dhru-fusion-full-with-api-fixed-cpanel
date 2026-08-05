<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
require_once ROOTDIR . "/includes/invoice.fun.php";
require_once ROOTDIR . "/includes/gateway.fun.php";
if (!isset($_SESSION["uid"])) {
    echo "error: Something Wrong #99821";
    exit;
}
global $lang;
if ($resend && isset($_SESSION["directotp"]) && isset($_SESSION["directemail"])) {
    include_once ROOTDIR . "/includes/mail.fun.php";
    $mailfield["otp"] = $_SESSION["directotp"];
    $mailfield["username"] = $_SESSION["username"];
    $toemails[] = ["to" => $_SESSION["directemail"]];
    sendMail(82, "", "", $mailfield, "", "", "", "", $toemails);
    echo "success: OTP resend";
    exit;
}
if ($directpaypal && $txnid) {
    $txnid = trim($txnid);
    if ($otp && $otp != $_SESSION["directotp"]) {
        echo "error: OTP not match";
        exit;
    }
    if (!mysqli_num_rows(dquery("select id from tbl_transaction where transid like '%" . $txnid . "%'"))) {
        $transactionid = $txnid;
        if (isset($transactionid)) {
            $_apiusername = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='apiusername' and gateway='" . $directpaypal . "' "));
            $_apiusername = $_apiusername["value"];
            $_apipassword = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='apipassword' and gateway='" . $directpaypal . "'"));
            $_apipassword = $_apipassword["value"];
            $_apisignature = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='apisignature' and gateway='" . $directpaypal . "'"));
            $_apisignature = $_apisignature["value"];
            $paypalaccount = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='payto' and gateway='" . $directpaypal . "'"));
            $paypalaccount = $paypalaccount["value"];
            $transactionvalidate = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='transactionvalidationdays' and gateway='" . $directpaypal . "'"));
            $transactionvalidate = $transactionvalidate["value"];
            $convertto = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='convertto' and gateway='" . $directpaypal . "'"));
            $convertto = $convertto["value"];
            $normalpayment = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='normalpayment' and gateway='" . $directpaypal . "'"));
            $normalpayment = $normalpayment["value"];
            $masspay = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='masspay' and gateway='" . $directpaypal . "'"));
            $masspay = $masspay["value"];
            $currencycode = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies`\r\n         WHERE `id` = '" . $convertto . "'"));
            $currencycode = $currencycode["code"];
            $postfields = [];
            $postfields["VERSION"] = "76.0";
            $postfields["METHOD"] = "GetTransactionDetails";
            $postfields["USER"] = trim($_apiusername);
            $postfields["PWD"] = trim($_apipassword);
            $postfields["SIGNATURE"] = trim($_apisignature);
            $postfields["TransactionID"] = trim($transactionid);
            $resultsarray = paypalapi($postfields);
            logTransaction($directpaypal, json_encode($resultsarray), "API RESULT");
            if (strtoupper($resultsarray["ACK"]) == "SUCCESS") {
                if (strtolower($resultsarray["PAYMENTSTATUS"]) == strtolower("Completed") && stripos($resultsarray["PAYERSTATUS"], "verified") !== false) {
                    if ($resultsarray["TRANSACTIONID"] != $transactionid) {
                        $postfields["TRANSACTIONID"] = $resultsarray["TRANSACTIONID"];
                        $result = inCurltxn($url, $postfields);
                        $resultsarray2 = explode("&", $result);
                        foreach ($resultsarray2 as $line) {
                            $line = explode("=", $line);
                            $resultsarray[$line[0]] = urldecode($line[1]);
                        }
                    }
                    $bid = mysqli_fetch_assoc(dquery("select id from tbl_currencies where `default`='1'"));
                    $min = convertCurrency($config["AddFundsMinimum"], $bid["id"], $_ClientsDetails["currency_id"]);
                    $max = convertCurrency($config["AddFundsMaximum"], $bid["id"], $_ClientsDetails["currency_id"]);
                    $maxbal = convertCurrency($config["AddFundsMaximumBalance"], $bid["id"], $_ClientsDetails["currency_id"]);
                    $USERCURRENCYCODE = $_SESSION["currency"]["code"];
                    $tras = mysqli_fetch_assoc(dquery("select * from tbl_transaction\r\n                 where transid='" . $resultsarray["TRANSACTIONID"] . "'"));
                    if (isset($tras["id"])) {
                        echo "error: Sorry this " . $lng_languag["invoicestransid"] . " already " . $lng_languag["used"];
                    } else {
                        if (strtolower($resultsarray["RECEIVERBUSINESS"]) == strtolower($paypalaccount)) {
                            if ($resultsarray["CURRENCYCODE"] == $USERCURRENCYCODE) {
                                if (!$transactionvalidate) {
                                    $transactionvalidate = "1";
                                }
                                if (strtotime("-" . $transactionvalidate . " days") <= strtotime($resultsarray["ORDERTIME"])) {
                                    $amount = $resultsarray["AMT"];
                                    $postfields = [];
                                    $postfields["VERSION"] = "76.0";
                                    $postfields["METHOD"] = "GetTransactionDetails";
                                    $postfields["USER"] = trim($_apiusername);
                                    $postfields["PWD"] = trim($_apipassword);
                                    $postfields["SIGNATURE"] = trim($_apisignature);
                                    $postfields["TransactionID"] = trim($resultsarray["TRANSACTIONID"]);
                                    $resultsarray2 = paypalapi($postfields);
                                    $isMasspay = false;
                                    $isNormal = false;
                                    if (isset($resultsarray2["FEEAMT"])) {
                                        $isNormal = true;
                                        $amount = $amount - $resultsarray2["FEEAMT"];
                                    } else {
                                        $isMasspay = true;
                                    }
                                    if ($normalpayment && $isNormal || $masspay && $isMasspay) {
                                        $txnid = $resultsarray["TRANSACTIONID"];
                                        $mc_fee = 0;
                                        logTransaction($directpaypal, urldecode($result), "Successful");
                                        $totalcredit = $_ClientsDetails["credit"]["credit"] + $amount;
                                        if ($errormessage) {
                                            echo "error:  " . $errormessage;
                                        } else {
                                            $user = mysqli_fetch_assoc(dquery("select otpfordirect from tblUsers\r\n                                            where id='" . $_SESSION["uid"] . "'"));
                                            if (!$config["otpfordirectfund"] && !$user["otpfordirect"] && !$otp) {
                                                $otp = rand(123456, 999999);
                                                $_SESSION["directotp"] = $otp;
                                                $_SESSION["directemail"] = $resultsarray["EMAIL"];
                                                include_once ROOTDIR . "/includes/mail.fun.php";
                                                $mailfield["otp"] = $otp;
                                                $mailfield["username"] = $_SESSION["username"];
                                                $toemails[] = ["to" => $resultsarray["EMAIL"]];
                                                sendMail(82, "", "", $mailfield, "", "", "", "", $toemails);
                                                echo "showdiv:.otps:OTP Sent to your paypal email [" . obfuscate_email($resultsarray["EMAIL"]) . "]. Enter below OTP box.";
                                                exit;
                                            }
                                            unset($_SESSION["directotp"]);
                                            $taxed = 0;
                                            if ($config["AddFunds_taxenabled"]) {
                                                $taxed = 1;
                                            }
                                            dquery("DELETE from tbl_invoiceitems\r\n                                            where invoiceid='0' and userid='" . $_SESSION["uid"] . "'");
                                            insert_query("tbl_invoiceitems", ["userid" => $_SESSION["uid"], "type" => "AddFunds", "relid" => "", "description" => $lng_languag["addfund"], "amount" => $amount, "taxed" => $taxed, "duedate" => "now()", "paymentmethod" => $directpaypal]);
                                            require_once ROOTDIR . "/includes/invoice.fun.php";
                                            $invoiceid = generateInvoice($_SESSION["uid"], "", "", "", $notes);
                                            addPayment($invoiceid, $txnid, $amount, $mc_fee, $directpaypal);
                                            echo "success: " . $lng_languag["addfunds"] . " " . $lng_languag["successful"] . " " . $lng_languag["with"] . " " . $lng_languag["amount"] . " " . $amount . ". " . $lng_languag["invoice"] . " #" . $invoiceid . ":otpbox,btnr";
                                        }
                                    } else {
                                        echo "error: Payment Type ";
                                        if ($normalpayment && !$isNormal) {
                                            echo "Mass";
                                        } else {
                                            if ($masspay && !$isMasspay) {
                                                echo "Normal";
                                            } else {
                                                echo " Mass and Normal ";
                                            }
                                        }
                                        echo " not allowed";
                                    }
                                } else {
                                    logTransaction($directpaypal, "Can not accept more than " . $transactionvalidate . " days old transactions, Contact us for manual process for this transaction #" . $_POST["invoiceid"] . urldecode($result), "Error");
                                    echo "error: Can not accept old transaction more than " . $transactionvalidate . " days.";
                                }
                            } else {
                                logTransaction($directpaypal, "invalid currency, Contact us for manual process for this transaction " . urldecode($result), "Error");
                                echo "error: Invalid Currency";
                            }
                        } else {
                            logTransaction($directpaypal, "Receiver mail and your gateway mail not match" . json_encode($resultsarray), "Error");
                            echo "error: Sorry we did not received any payment on " . $paypalaccount;
                        }
                    }
                } else {
                    logTransaction($directpaypal, "The transaction id is not valid  #Error ID : 38820" . urldecode($result), "Error");
                    echo "error: The transaction id is not valid Or Pending";
                }
            } else {
                if (stripos($resultsarray["L_LONGMESSAGE0"], "transaction id is not valid") !== false) {
                    logTransaction($directpaypal, "The transaction id is not valid #Error ID :023832 #" . urldecode($result), "Error");
                    echo "error: The transaction id is not valid ";
                }
                echo "error: Failed to add fund " . urldecode($resultsarray["L_LONGMESSAGE0"]);
                logTransaction($directpaypal, urldecode($result), "Error");
            }
        }
    } else {
        echo "error: " . $lng_languag["invoicestransid"] . " " . $lng_languag["used"];
    }
} else {
    echo "error: " . $lng_languag["filefield"];
}
function paypalapi($postfields, $sendbox = false)
{
    if ($sendbox) {
        $url = "https://api-3t.sandbox.paypal.com/nvp";
    } else {
        $url = "https://api-3t.paypal.com/nvp";
    }
    $result = inCurltxn($url, $postfields);
    $resultsarray2 = explode("&", $result);
    $resultsarray = [];
    foreach ($resultsarray2 as $line) {
        $line = explode("=", $line);
        $transactionArray[$line[0]] = urldecode(trim($line[1]));
    }
    return $transactionArray;
}
function inCurltxn($url, $postfields = [], $curlopts = [])
{
    global $debug_output;
    $curlopts["CURLOPT_TIMEOUT"] = 1000;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($postfields) {
        $fieldstring = $postfields;
        if (is_array($fieldstring)) {
            $fieldstring = "";
            foreach ($postfields as $k => $v) {
                $fieldstring .= "" . $k . "=" . urlencode($v) . "&";
            }
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldstring);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $curlopts["CURLOPT_TIMEOUT"]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    if ($curlopts["HEADER"]) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $curlopts["HEADER"]);
    }
    $retval = curl_exec($ch);
    return $retval;
}
function obfuscate_email($email)
{
    $em = explode("@", $email);
    $name = implode(array_slice($em, 0, count($em) - 1), "@");
    $len = floor(strlen($name) / 2);
    return substr($name, 0, $len) . str_repeat("*", $len) . "@" . end($em);
}

?>