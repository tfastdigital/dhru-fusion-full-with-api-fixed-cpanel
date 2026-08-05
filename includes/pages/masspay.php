<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require_once "comm.php";
require_once "includes/fun.inc.php";
require_once "includes/client.area.inc.php";
require_once "includes/mail.fun.php";
require_once "includes/gateway.fun.php";
require_once "includes/invoice.fun.php";
$_POST["dlfile"] = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_POST["dlfile"]);
$_POST["invoiceid"] = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_POST["invoiceid"]);
$_POST["payto"] = preg_replace("/[^0-9\\-a-zA-Z-_@.]/i", "", $_POST["payto"]);
$_POST["amount"] = preg_replace("/[^0-9\\-a-zA-Z-.]/i", "", $_POST["amount"]);
$_POST["currency"] = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_POST["currency"]);
$_POST["companyname"] = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_POST["companyname"]);
$_POST["companyname"] = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_POST["companyname"]);
$transactionid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $_POST["txnid"]);
if (isset($_GET["pay"]) && $_GET["pay"] == "cod") {
    if (isset($_SESSION["uid"])) {
        dquery("update tbl_order_product set user_can_c='0' where invoiceid='" . $_POST["invoiceid"] . "' and user_can_c='5'");
        $adminmessage = "New Order Processed By Cash On Delivery";
        $adminmessage .= "<br /> Invoice ID : " . $_POST["invoiceid"] . " \n        ";
        sendNotification("system", "Cash on Delivery Order", $adminmessage, $mailto);
        header("Location: viewinvoice.php?id=" . md5($_POST["invoiceid"]));
        echo "<script> location.href='viewinvoice.php?id=" . md5($_POST["invoiceid"]) . "'; </script>";
    }
} else {
    if (isset($_POST["submitdetails"])) {
        if (isset($transactionid)) {
            $_apiusername = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='apiusername' and gateway='paypal_mass_pay' "));
            $_apiusername = $_apiusername["value"];
            $_apipassword = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='apipassword' and gateway='paypal_mass_pay'"));
            $_apipassword = $_apipassword["value"];
            $_apisignature = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='apisignature' and gateway='paypal_mass_pay'"));
            $_apisignature = $_apisignature["value"];
            $paypalaccount = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='payto' and gateway='paypal_mass_pay'"));
            $paypalaccount = $paypalaccount["value"];
            $convertto = mysqli_fetch_assoc(dquery("SELECT value FROM `tbl_paymentgateways` where setting='convertto' and gateway='paypal_mass_pay'"));
            $convertto = $convertto["value"];
            $currencycode = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_currencies`\n         WHERE `id` = '" . $convertto . "'"));
            $currencycode = $currencycode["code"];
            $url = "https://api-3t.paypal.com/nvp";
            $postfields = [];
            $postfields["VERSION"] = "3.0";
            $postfields["METHOD"] = "GetTransactionDetails";
            $postfields["USER"] = trim($_apiusername);
            $postfields["PWD"] = trim($_apipassword);
            $postfields["SIGNATURE"] = trim($_apisignature);
            $postfields["TransactionID"] = trim($transactionid);
            $result = inCurl11($url, $postfields);
            $resultsarray2 = explode("&", $result);
            $resultsarray = [];
            foreach ($resultsarray2 as $line) {
                $line = explode("=", $line);
                $resultsarray[$line[0]] = urldecode(trim($line[1]));
            }
            if (strtoupper($resultsarray["ACK"]) == "SUCCESS") {
                if ($resultsarray["PAYMENTSTATUS"] == "Completed" && stripos($resultsarray["PAYERSTATUS"], "verified") !== false) {
                    if ($resultsarray["TRANSACTIONID"] != $transactionid) {
                        $postfields["TRANSACTIONID"] = $resultsarray["TRANSACTIONID"];
                        $result = inCurl11($url, $postfields);
                        $resultsarray2 = explode("&", $result);
                        foreach ($resultsarray2 as $line) {
                            $line = explode("=", $line);
                            $resultsarray[$line[0]] = urldecode($line[1]);
                        }
                    }
                    $tras = mysqli_fetch_assoc(dquery("select * from tbl_transaction\n                 where transid='" . $resultsarray["TRANSACTIONID"] . "'"));
                    if (isset($tras["id"])) {
                        logTransaction("paypalmasspay", "Transaction already exist #" . $_POST["invoiceid"] . urldecode($result), "Error");
                        header("Location: viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true");
                        echo "<script> location.href='viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true'; </script>";
                    } else {
                        $USERCURRENCYCODE = mysqli_fetch_assoc(dquery("select code from\n                        tbl_currencies where id=(select default_currency\n                        from tblUsers where id=(select userid from tbl_invoices where id=" . $_POST["invoiceid"] . "))"));
                        if ($resultsarray["RECEIVERBUSINESS"] == $paypalaccount) {
                            if ($resultsarray["CURRENCYCODE"] == $USERCURRENCYCODE["code"]) {
                                if (strtotime("-3 days") <= strtotime($resultsarray["ORDERTIME"])) {
                                    $amount = $resultsarray["AMT"];
                                    $txnid = $resultsarray["TRANSACTIONID"];
                                    $mc_fee = 0;
                                    logTransaction("paypalmasspay", "#" . $_POST["invoiceid"] . urldecode($result), "Successful");
                                    addPayment($_POST["invoiceid"], $txnid, $amount, $mc_fee, "paypal_mass_pay");
                                    header("Location: viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentsuccess=true");
                                    echo "<script> location.href='viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentsuccess=true'; </script>";
                                } else {
                                    logTransaction("paypalmasspay", "Can not accept more than 3 days old transactions, Contact us for manual process for this transaction #" . $_POST["invoiceid"] . urldecode($result), "Error");
                                    header("Location: viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true");
                                    echo "<script> location.href='viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true'; </script>";
                                }
                            } else {
                                logTransaction("paypalmasspay", "invalid currency, Contact us for manual process for this transaction #" . $_POST["invoiceid"] . urldecode($result), "Error");
                                header("Location: viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true");
                                echo "<script> location.href='viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true'; </script>";
                            }
                        } else {
                            logTransaction("paypalmasspay", "Receiver mail and your gateway mail not match #" . $_POST["invoiceid"] . urldecode($result), "Error");
                            header("Location: viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true");
                            echo "<script> location.href='viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true'; </script>";
                        }
                    }
                } else {
                    logTransaction("paypalmasspay", "The transaction id is not valid  #Error ID : 38820" . $_POST["invoiceid"] . urldecode($result), "Error");
                    header("Location: viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true");
                    echo "<script> location.href='viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true'; </script>";
                }
            } else {
                if (stripos($resultsarray["L_LONGMESSAGE0"], "transaction id is not valid") !== false) {
                    logTransaction("paypalmasspay", "The transaction id is not valid #Error ID :023832 #" . $_POST["invoiceid"] . urldecode($result), "Error");
                    header("Location: viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true");
                    echo "<script> location.href='viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true'; </script>";
                }
                logTransaction("paypalsubmitpayment", "#" . $_POST["invoiceid"] . urldecode($result), "Error");
                header("Location: viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true");
                echo "<script> location.href='viewinvoice.php?id=" . $_POST["invoiceid"] . "&paymentfailed=true'; </script>";
            }
        }
    } else {
        if (isset($_POST["dlfile"])) {
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"paypal_" . $_POST["invoiceid"] . ".txt\"");
            $data = NULL;
            $code1 = NULL;
            $data = $_POST["payto"] . "\t" . $_POST["amount"] . "\t" . $_POST["currency"] . "\tPayment to " . $_POST["companyname"] . " Invoice #" . $_POST["invoiceid"];
            echo $data;
            $data = NULL;
        }
    }
}
chkMd5sumsubpage();
class no
{
}
function inCurl11($url, $postfields = [], $curlopts = [])
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

?>