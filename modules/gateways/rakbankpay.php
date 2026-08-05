<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function rakbankpay_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Rakbankpay Hosted Checkout"], "merchant_id" => ["Name" => "Merchant ID", "Type" => "text", "Size" => "20"], "api_password" => ["Name" => "API Password", "Type" => "text", "Size" => "20"], "test" => ["Name" => "SendBox/Test Mode", "Type" => "yesno", "Size" => "20"]];
    return $configarray;
}
function rakbankpay_link($params)
{
    global $config;
    global $rakbankpayprocesssuccess;
    if ($rakbankpayprocesssuccess) {
        $IsWallet = false;
        $aggregatordata = explode("_", $params["invoiceid"]);
        if ($aggregatordata[0] == "A" || $aggregatordata[0] == "B") {
            $PassInvoice = $params["invoiceid"];
        } else {
            $PassInvoice = $_SESSION["uid"] . "_" . $params["invoiceid"];
        }
        $_pass["merchant_id"] = ($params[test] ? "TEST" : "") . $params["merchant_id"];
        $Log["header"] = "merchant." . $params["merchant_id"] . ":" . $params["api_password"];
        $Log["link"] = "https://rakbankpay.gateway.mastercard.com/api/rest/version/55/merchant/" . $params["merchant_id"] . "/order/" . $PassInvoice;
        logTransaction("rakbankpay", json_encode($Log), $IsWallet . "-Before Curl", "invoice");
        $curlopts["HEADER"][] = "Authorization: Basic " . base64_encode("merchant." . $params["merchant_id"] . ":" . $params["api_password"]);
        $_req = json_decode(initCurl("https://rakbankpay.gateway.mastercard.com/api/rest/version/55/merchant/" . $params["merchant_id"] . "/order/" . $PassInvoice, [], $curlopts), true);
        $_transactions = $_req["transaction"];
        $APPROVED = false;
        $IsAggregator = false;
        $IsWallet = false;
        logTransaction("rakbankpay", json_encode($_req), $IsWallet . "-Full Response", "invoice");
        if ($aggregatordata[0] == "A" && 0 < $aggregatordata[1] && $aggregatordata[2]) {
            $aggretran = dquery("select * from tblAggregatorTransaction where aggregatortransid='" . $aggregatordata[1] . "'");
            $aggretran = mysqli_fetch_assoc($aggretran);
            if ($aggretran["aggregatortransid"]) {
                $idnumber = $aggregatordata[1];
                $IsAggregator = true;
            }
        } else {
            if ($aggregatordata[0] == "B" && 0 < $aggregatordata[1]) {
                $idnumber = $aggregatordata[1];
                $IsWallet = true;
            } else {
                if ($aggregatordata[1]) {
                    $params["invoiceid"] = $aggregatordata[1];
                }
            }
        }
        logTransaction("rakbankpay", json_encode($_transactions), $IsWallet . "-Before", "invoice");
        logTransaction("rakbankpay", json_encode($_transactions), "Received", "", "", $PassInvoice);
        if (strlen(json_encode($_transactions)) < 100) {
            sleep(5);
            $curlopts["HEADER"][] = "Authorization: Basic " . base64_encode("merchant." . $params["merchant_id"] . ":" . $params["api_password"]);
            $_req = json_decode(initCurl("https://rakbankpay.gateway.mastercard.com/api/rest/version/55/merchant/" . $params["merchant_id"] . "/order/" . $PassInvoice, [], $curlopts), true);
            $_transactions = $_req["transaction"];
        }
        foreach ($_transactions as $k => $v) {
            logTransaction("rakbankpay", json_encode($v), "In Transcat", "invoice");
            if ($v["response"]["gatewayCode"] == "APPROVED") {
                $APPROVED = true;
                $transaction = $v["transaction"];
                if ($transaction["type"] == "PAYMENT") {
                    $amount = $transaction["amount"];
                    $amount = preg_replace("/[^0-9\\.]/i", "", $amount);
                    $currency = $transaction["currency"];
                    logTransaction("rakbankpay", json_encode($v), "Successful", "invoice");
                    $userid = $params["clientdetails"]["userid"];
                    $invoiceid = $params["invoiceid"];
                    $txn_id = $transaction["receipt"] . "_" . $transaction["id"];
                    $mc_gross = $amount;
                    $mc_fee = 0;
                    $paypalcurrency = $currency;
                    $currency = getCurrency("", $userid);
                    $result = select_query("tbl_currencies", "", ["code" => $paypalcurrency]);
                    $data = mysqli_fetch_assoc($result);
                    $paypalcurrencyid = $data["id"];
                    if ($paypalcurrencyid != $currency["id"]) {
                        $mc_gross = convertCurrency($mc_gross, $paypalcurrencyid, $currency["id"]);
                        $mc_fee = convertCurrency($mc_fee, $paypalcurrencyid, $currency["id"]);
                        $result = select_query("tbl_invoices", "total", ["id" => $invoiceid]);
                        $data = mysqli_fetch_assoc($result);
                        $total = round($data["total"], 2);
                        if ($total < $mc_gross + 1 && $mc_gross - 1 < $total) {
                            $mc_gross = $total;
                        }
                    }
                    $PaidAmount = $mc_gross;
                    if ($IsWallet) {
                        $INVOSI = explode("_", $params["invoiceid"]);
                        $Gateway = loadGatewayModule("rakbankpay");
                        $Wallet = mysqli_fetch_assoc(dquery("select fee,amount from tblWalletTransaction \nwhere transid='" . $INVOSI[1] . "'"));
                        $Fee = $Wallet["fee"];
                        $PaidAmount = round($PaidAmount, 2);
                        if (0 < $Fee && $Fee < $PaidAmount) {
                            $PaidAmount = $PaidAmount - $Fee;
                        }
                        if (!mysqli_num_rows(dquery("select * from tblWalletTransaction where transid='" . $INVOSI[1] . "' and status='paid'"))) {
                            if ($PaidAmount < $Wallet["amount"] + 0 && $Wallet["amount"] - 0 < $PaidAmount) {
                                walletTransaction($txn_id, $INVOSI[1], $PaidAmount, $Fee, $Gateway["name"]);
                                if (!mysqli_num_rows(dquery("select * from tbl_gatewaylog where refid='B_" . $INVOSI[1] . "' and result='Wallet Paid'"))) {
                                    logTransaction("rakbankpay", $params, "Wallet Paid", "invoice", $invoiceid);
                                    header("Location: " . _url("index/login/success/paymentsuccess/true/A/1"));
                                }
                            } else {
                                dquery("update tblWalletTransaction set status='unpaid',receivedamount=receivedamount+'" . $PaidAmount . "' where  transid='" . $INVOSI[1] . "'");
                                logTransaction("rakbankpay", "Paid " . $PaidAmount . " Wallet " . $Wallet["amount"], "Transaction Less Amount", "invoice", $invoiceid);
                                logTransaction("rakbankpay", $params, "Transaction Less Amount", "invoice", $invoiceid);
                                include_once ROOTDIR . "/includes/mail.fun.php";
                                $adminmessage .= "Part Payment Received for Wallet Transaction B_" . $INVOSI[1] . " <br />";
                                $adminmessage .= "Gateway : " . $Gateway["name"] . " <br />";
                                $adminmessage .= "Amount : " . $PaidAmount;
                                sendNotification("system", "Part Payment Received for Wallet Transaction", $adminmessage, "");
                            }
                        }
                        return NULL;
                    }
                    $INVOSI = explode("_", $invoiceid);
                    if ($INVOSI[1]) {
                        $invoiceid = $INVOSI[1];
                    }
                    addPayment($invoiceid, $txn_id, $mc_gross, $mc_fee, "rakbankpay", 1);
                    return "<script>location.reload();</script> Payment Success....";
                }
                logTransaction("rakbankpay", json_encode($v), "Payment Failed/Void Payment", "invoice");
            }
        }
    }
    $curlopts["HEADER"][] = "Authorization: Basic " . base64_encode("merchant." . $params["merchant_id"] . ":" . $params["api_password"]);
    $_req = json_decode(initCurl("https://rakbankpay.gateway.mastercard.com/api/rest/version/55/merchant/" . $params["merchant_id"] . "/session", [], $curlopts, "", "{\"order\" :{},\"interaction\" : {}}"), true);
    if (!$_req["session"]["id"]) {
        return $_req["error"]["explanation"];
    }
    unset($params["api_password"]);
    unset($params["clientdetails"]);
    $_pass["merchant_id"] = ($params[test] ? "TEST" : "") . $params["merchant_id"];
    if ($IsWallet) {
        $_pass["invoiceid"] = $params[invoiceid];
    } else {
        $params[invoiceid] = $_SESSION["uid"] . "_" . $params[invoiceid];
        $_pass["invoiceid"] = $params[invoiceid];
    }
    $_pass["amount"] = $params[amount];
    $_pass["currency"] = $params[currency];
    $_pass["description"] = $params[description];
    $_pass["companyname"] = $config[companyname];
    $_pass["session_id"] = $_req["session"]["id"];
    if ($IsWallet) {
        return "<form method=\"post\" action=\".." . _url("placeholder/actiongateway/rakbankpay/invoiceid/" . $params["invoiceid"]) . "\">\n    <input type=\"hidden\" value=\"" . encrypt(json_encode($_pass), "AKSDFLK239RLAKJDLK239FUALJFLADJ") . "\" name=\"q\">\n    <button class=\"btn-primary paymentbtn btn\" onclick=\"this.submit()\">Pay Now.</button>\n    </form>";
    }
    return "<form method=\"post\" action=\"" . _url("placeholder/actiongateway/rakbankpay/invoiceid/" . $params["invoiceid"], true) . "\">\n    <input type=\"hidden\" value=\"" . encrypt(json_encode($_pass), "AKSDFLK239RLAKJDLK239FUALJFLADJ") . "\" name=\"q\">\n    <button class=\"btn btn-primary paymentbtn\" onclick=\"this.submit()\">Pay Now</button>\n    </form>";
}

?>