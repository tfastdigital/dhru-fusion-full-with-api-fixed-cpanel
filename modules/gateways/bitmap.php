<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function bitmap_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Bitmap  Payment"], "merchantid" => ["Name" => "Merchant ID", "Type" => "text", "Size" => "50"], "merchantkey" => ["Name" => "Merchant Key", "Type" => "text", "Size" => "50"], "sandbox" => ["Name" => "Sandbox", "Type" => "yesno", "Size" => "50"]];
    return $configarray;
}
function baseurl()
{
    if (isset($_SERVER["HTTPS"])) {
        $protocol = $_SERVER["HTTPS"] && $_SERVER["HTTPS"] != "off" ? "https" : "http";
    } else {
        $protocol = "http";
    }
    return $protocol . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
}
function bitmap_link($params)
{
    global $config;
    include_once ROOTDIR . "/modules/gateways/bitmap/Bitmap.php";
    $invoiceid = $params["invoiceid"];
    $description = $params["description"];
    $SiteAddress = $config["site_address"];
    if ($config["config_ssl_allow"]) {
        $SiteAddress = $config["config_ssl_allow"];
    }
    $IsWallet = false;
    $walt = explode("_", $invoiceid);
    if ($walt[0] == "B") {
        $IsWallet = true;
    }
    $INVDETAIL = mysqli_fetch_assoc(dquery("select *,(select (select `code` from tbl_currencies where tbl_currencies.id=default_currency) \nfrom tblUsers where tblUsers.id=tbl_invoices.userid) as usercurrency from tbl_invoices where id='" . $invoiceid . "'"));
    if ($INVDETAIL["status"] == "Unpaid" || $IsWallet) {
        $networkOnlineArray = ["Network_Online_setting" => ["merchantKey" => $params["merchantkey"], "merchantId" => $params["merchantid"], "collaboratorId" => "NI", "iv" => "0123456789abcdef", "url" => $params["sandbox"] ? false : true], "Block_Existence_Indicator" => ["transactionDataBlock" => true, "billingDataBlock" => true, "shippingDataBlock" => false, "paymentDataBlock" => true, "merchantDataBlock" => false, "otherDataBlock" => true, "DCCDataBlock" => false], "Field_Existence_Indicator_Transaction" => ["merchantOrderNumber" => $invoiceid, "amount" => round($params["amount"], 2), "successUrl" => $params["merchantreturnurl"] ? $params["merchantreturnurl"] : _url("viewinvoice/id/" . md5($params["invoiceid"]), true), "failureUrl" => $params["merchantreturnurl"] ? $params["merchantreturnurl"] : _url("viewinvoice/id/" . md5($params["invoiceid"]), true), "transactionMode" => "INTERNET", "payModeType" => "", "transactionType" => "01", "currency" => $params["currency"]], "Field_Existence_Indicator_Billing" => ["billToFirstName" => $params["firstname"], "billToLastName" => $params["lastname"], "billToStreet1" => "", "billToStreet2" => "", "billToCity" => "", "billToState" => $_SESSION["shippingstate"], "billtoPostalCode" => $_SESSION["shippingzip"], "billToCountry" => $_SESSION["shippingcountry"], "billToEmail" => $params["emailforstripe"], "billToMobileNumber" => $params["customerphone"], "billToPhoneNumber1" => "", "billToPhoneNumber2" => "", "billToPhoneNumber3" => ""], "Field_Existence_Indicator_Shipping" => ["shipToFirstName" => $params["firstname"], "shipToLastName" => $params["lastname"], "shipToStreet1" => "", "shipToStreet2" => "", "shipToCity" => "", "shipToState" => $_SESSION["shippingstate"], "shipToPostalCode" => $_SESSION["shippingzip"], "shipToCountry" => $_SESSION["shippingcountry"], "shipToPhoneNumber1" => "", "shipToPhoneNumber2" => "", "shipToPhoneNumber3" => "", "shipToMobileNumber" => ""], "Field_Existence_Indicator_Payment" => ["cardNumber" => "", "expMonth" => "08", "expYear" => "", "CVV" => "123", "cardHolderName" => $params["firstname"] . " " . $params["lastname"], "cardType" => "Visa", "custMobileNumber" => $params["customerphone"], "paymentID" => "123456", "OTP" => "123456", "gatewayID" => "1026", "cardToken" => "1202"], "Field_Existence_Indicator_Merchant" => ["UDF1" => $invoiceid, "UDF2" => "abc", "UDF3" => "abc", "UDF4" => "abc", "UDF5" => "abc", "UDF6" => "abc", "UDF7" => "abc", "UDF8" => "abc", "UDF9" => "abc", "UDF10" => "abc"], "Field_Existence_Indicator_OtherData" => ["custID" => "cust123", "transactionSource" => "IVR", "productInfo" => $description, "isUserLoggedIn" => "Y", "itemTotal" => $params["fee"], "itemCategory" => "", "ignoreValidationResult" => "FALSE"]];
        $networkOnlineObject = new NetworkonlieBitmapPaymentIntegration($networkOnlineArray);
        if (isset($_REQUEST["responseParameter"]) && $_REQUEST["responseParameter"] != "") {
            include_once ROOTDIR . "/includes/gateway.fun.php";
            include_once ROOTDIR . "/includes/invoice.fun.php";
            $response = $networkOnlineObject->decryptData($_REQUEST["responseParameter"], $networkOnlineObject->merchantKey, $networkOnlineObject->iv);
            logTransaction("bitmap", $response, "Callback", "invoice", $invoiceid);
            $TrStatus = explode("|", $response["Transaction_Status_information"]);
            if ($TrStatus[1] == "SUCCESS") {
                $Transaction = explode("|", $response["Transaction_related_information"]);
                $TransactionID = $Transaction[5];
                $Return = explode("|", $response["Transaction_Response"]);
                list($invoiceid, $Currency, $PaidAmount) = $Return;
                $mc_fee = 0;
                logTransaction("bitmap", $response, "Success", "invoice", $invoiceid);
                logTransaction("bitmap", $response, "Received", "invoice", $invoiceid, $invoiceid);
                $Fee = 0;
                if (0 < $walt[2]) {
                    $Fee = $walt[2];
                }
                if ($INVDETAIL["usercurrency"] != $Currency) {
                    $PaidAmount = convertCurrency($PaidAmount, $Currency, $INVDETAIL["usercurrency"], "", "code");
                    $result = select_query("tbl_invoices", "total", ["id" => $invoiceid]);
                    $data = mysqli_fetch_assoc($result);
                    $total = round($data["total"], 2);
                    if ($total < $PaidAmount + 1 && $PaidAmount - 1 < $total) {
                        $PaidAmount = $total;
                    }
                }
                if ($IsWallet) {
                    $INVOSI = explode("_", $invoiceid);
                    $Wallet = mysqli_fetch_assoc(dquery("select fee,amount from tblWalletTransaction \nwhere transid='" . $INVOSI[1] . "'"));
                    $Fee = $Wallet["fee"];
                    $PaidAmount = round($PaidAmount, 2);
                    if (0 < $Fee) {
                        $PaidAmount = $PaidAmount - $Fee;
                    }
                    $Gateway = loadGatewayModule("bitmap");
                    if ($Wallet["amount"] <= $PaidAmount) {
                        walletTransaction($TransactionID, $INVOSI[1], $PaidAmount, $walt[2], $Gateway["name"]);
                        logTransaction("bitmap", $data, "Wallet Paid", "invoice", $invoiceid);
                    } else {
                        dquery("update tblWalletTransaction set status='unpaid',receivedamount=receivedamount+'" . $PaidAmount . "' where  transid='" . $walt[2] . "'");
                        logTransaction("rakbankpay", $params, "Transaction Less Amount", "invoice", $invoiceid);
                        include_once ROOTDIR . "/includes/mail.fun.php";
                        $adminmessage .= "Part Payment Received for Wallet Transaction B_" . $walt[2] . " <br />";
                        $adminmessage .= "Gateway : " . $Gateway["name"] . " <br />";
                        $adminmessage .= "Amount : " . $PaidAmount;
                        sendNotification("system", "Part Payment Received for Wallet Transaction", $adminmessage, "");
                    }
                    header("Location: " . _url("/index/login/success/paymentsuccess/true"));
                } else {
                    addPayment($invoiceid, $TransactionID, $PaidAmount, $mc_fee, "bitmap", 1, "", "", "");
                    header("Location: " . _url("/viewinvoice/id/" . md5($invoiceid)));
                }
                $networkOnlineObject->AddLog("Network Online Response : " . print_r($response, true), "16");
            } else {
                $Transaction = explode("|", $response["Transaction_Status_information"]);
                $Error = $Transaction[3];
                logTransaction("bitmap", $response, "Error", "invoice", $invoiceid);
                return "<div id='notification1' class='errorbox error'>" . $Error . "</div>";
            }
        }
        $requestParameter = $networkOnlineObject->NeoPostData;
        if ($networkOnlineObject->url) {
            $requestUrl = "https://NeO.network.ae/direcpay/secure/PaymentTxnServlet";
        } else {
            $requestUrl = "https://uat-NeO.network.ae/direcpay/secure/PaymentTxnServlet";
        }
        $code = "\n<form action='" . $requestUrl . "' method=\"post\" name=\"network_online_payment\" id=\"network_online_payment\">\n<input type=\"hidden\" name=\"requestParameter\" value='" . $requestParameter . "'>\n  <input type=\"submit\" class='paymentbtn btn btn-primary' value=\"Submit\">\n</form>";
        return $code;
    }
}

?>