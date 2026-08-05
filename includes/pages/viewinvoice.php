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
require "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/gateway.fun.php";
require_once ROOTDIR . "/includes/invoice.fun.php";
if (!function_exists("getCustomFields")) {
    require ROOTDIR . "/includes/customfield.fun.inc.php";
}
$currentpage = "viewinvoice";
$_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["dashboard"] . "</a> / ";
$templatefile = "client_viewinvoice";
$fileverioncheck = "6.1.0";
$_addd_to_update = "";
if (!file_exists(ROOTDIR . "/templates/" . $_SESSION["template"] . "/client_viewinvoice.tpl")) {
    copy(ROOTDIR . "/templates/default2/client_viewinvoice.tpl", ROOTDIR . "/templates/" . $_SESSION["template"] . "/client_viewinvoice.tpl");
}
$taxref = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $txref);
$checkoutId = preg_replace("/[^0-9\\_\\-a-zA-Z]/i", "", $checkoutId);
$transactionId = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $transactionId);
if ($gateway == "applycredit") {
    $gateway = "";
}
if ($successmsg) {
    $tempalte_ver["notification"]["success"] = $successmsg;
}
if ($dhrutrid && $custom) {
    $dhrutrid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $dhrutrid);
    $custom = $_invoiceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $custom);
    $walletes = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $walletes);
    if ($walletes) {
        $GATEWAY = loadGatewayModule("walletes");
    } else {
        $GATEWAY = loadGatewayModule("dhrumerchant");
    }
    $invs = mysqli_fetch_assoc(dquery("select id,status,mask from tbl_invoices \n    where (id)='" . $custom . "'"));
    $merchanturl = $GATEWAY["merchanturl"];
    $merchantkey = $GATEWAY["merchantkey"];
    $_Sign = md5($dhrutrid . $_invoiceid . $merchantkey);
    if (!mysqli_num_rows(dquery("select id from tbl_transaction where transid='" . $dhrutrid . "'")) && $paymentstatus == "success" && $invs["status"] == "Unpaid") {
        if (!$merchanturl || $walletes) {
            $merchanturl = "https://walletes.com/merchant/index.php";
        }
        logTransaction("dhrumerchant", "Callback Received " . $dhrutrid, "Received");
        $postfields["checktransaction"] = $dhrutrid;
        $postfields["custom"] = $_invoiceid;
        $postfields["merchantkey"] = $merchantkey;
        $postfields["sign"] = $_Sign;
        $res = initCurl($merchanturl, $postfields, "", "", "");
        $resp = json_decode($res, true);
        if ($resp["code"] == 200) {
            addPayment($custom, $dhrutrid, $resp["detail"]["amount"], 0, "dhrumerchant", true);
        } else {
            logTransaction("dhrumerchant", $resp["message"], "Error");
        }
    }
}
if ($checkoutId && $transactionId) {
    $inv = mysqli_fetch_assoc(dquery("select * from tbl_invoices\nwhere businessid='" . $checkoutId . "'"));
    $id = md5($inv["id"]);
    if ($inv["status"] == "Unpaid") {
        require_once ROOTDIR . "/includes/3rdparty/squareup/autoload.php";
        $paidamountcal = mysqli_fetch_assoc(dquery("select sum(amountin) as total\n        from tbl_transaction where invoiceid='" . $inv["id"] . "'"));
        if ($paidamountcal["total"] < $inv["total"]) {
            $sqr = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\n        where gateway='squareup' and setting='accesstoken'"));
            $accessToken = $sqr["value"];
            $sqr = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\n        where gateway='squareup' and setting='locationid'"));
            $locationId = $sqr["value"];
            $defaultApiConfig = new SquareConnect\Configuration();
            $defaultApiConfig->setAccessToken($accessToken);
            $defaultApiClient = new SquareConnect\ApiClient($defaultApiConfig);
            $transaction = new SquareConnect\Api\TransactionsApi($defaultApiClient);
            try {
                $apiResponse = $transaction->retrieveTransaction($locationId, $transactionId);
                logTransaction("squareup", $apiResponse, "Success");
                $paidamount = round($apiResponse["transaction"]["tenders"][0]["amount_money"]["amount"] / 100, 2);
                $paidbycurrency = $apiResponse["transaction"]["tenders"][0]["amount_money"]["currency"];
                if ($inv["total"] == $paidamount && $inv["currency"] == trim($paidbycurrency)) {
                    addPayment($inv["id"], $transactionId, $paidamount, "", "squareup", 1);
                    logTransaction("squareup", $apiResponse, "Completed");
                } else {
                    $ravecurid = mysqli_fetch_assoc(dquery("select id from tbl_currencies where code='" . $paidbycurrency . "'"));
                    $convertedamount = convertCurrency($paidamount, $ravecurid["id"], $inv["currencyid"]);
                    if ($inv["total"] == $convertedamount) {
                        addPayment($inv["id"], $transactionId, $convertedamount, "", "squareup", 1);
                        logTransaction("squareup", $apiResponse, "Completed");
                    } else {
                        logTransaction("squareup", $apiResponse, "Amount Or Currency Mismatch");
                    }
                }
            } catch (SquareConnect\ApiException $e) {
                logTransaction("squareup", $e, "Error");
            }
        } else {
            header("Location: " . _url("viewinvoice/id/") . $id);
            exit;
        }
    } else {
        header("Location: " . _url("viewinvoice/id/") . $id);
        exit;
    }
}
if ($taxref) {
    $invs = mysqli_fetch_assoc(dquery("select id,status,mask from tbl_invoices \n    where md5(id)='" . $taxref . "'"));
    if ($invs["status"] == "Unpaid") {
        $rave = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\nwhere gateway='rave' and setting='secretkey'"));
        $url = "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify";
        $body = ["txref" => $taxref, "SECKEY" => $rave["value"]];
        $headers = ["Content-Type" => "application/json"];
        $curlopts["HEADER"] = $headers;
        $res = initCurl($url, $body, $curlopts, "", "");
        $resp = json_decode($res, true);
        if ($resp["status"] == "success") {
            $ravedata = $resp["data"];
            $invoiceid = trim($ravedata["txref"]);
            $inv = mysqli_fetch_assoc(dquery("select *,(select code from tbl_currencies\nwhere id=(select default_currency from tblUsers where id=userid)) as currency,\n(select default_currency from tblUsers where id=userid) as currencyid \n from tbl_invoices \nwhere md5(id)='" . $invoiceid . "'"));
            logTransaction("rave", $res, "Success");
            if ($inv["total"] == $ravedata["amount"] && $inv["currency"] == trim($ravedata["currency"])) {
                addPayment($inv["id"], $ravedata["txid"], $ravedata["amount"], "", "rave", 1);
                logTransaction("rave", $res, "Completed");
            } else {
                $ravecurid = mysqli_fetch_assoc(dquery("select id from tbl_currencies where code='" . $ravedata["currency"] . "'"));
                $convertedamount = convertCurrency($ravedata["amount"], $ravecurid["id"], $inv["currencyid"]);
                if ($inv["total"] == $convertedamount) {
                    addPayment($inv["id"], $ravedata["txid"], $convertedamount, "", "rave", 1);
                    logTransaction("rave", $res, "Completed");
                } else {
                    logTransaction("rave", $res, "Amount Or Currency Mismatch");
                }
            }
        } else {
            logTransaction("rave", $res, "Error");
        }
    }
}
$invs = mysqli_fetch_assoc(dquery("select id,receivedamount,paymentmethod,status,mask,total,(select code from \n    tbl_currencies where tbl_currencies.id=(select default_currency from tblUsers\n    where id=userid)) as code,(select description from tbl_invoiceitems\n    where invoiceid=tbl_invoices.id limit 1) as info from tbl_invoices \n        where md5(id)='" . $id . "' and userid='" . $_SESSION["uid"] . "'"));
$tempalte_ver["invoiceurl"] = _url("viewinvoice/id/" . $id);
if ($invs["status"] == "Unpaid") {
    if ($verifyfawrypayment && isset($_SESSION[$invs["id"] . "_orderrefno"])) {
        $params = loadGatewayModule("fawry");
        $MERCHANTCODE = $params["merchantcode"];
        $SECUREKEY = $params["securekey"];
        $REFNO = $_SESSION[$invs["id"] . "_orderrefno"];
        $sec2 = hash("sha256", $MERCHANTCODE . $invs["id"] . $SECUREKEY);
        $AMOUNT = number_format((double) $invs["total"], 2, ".", "");
        $URL = "https://www.atfawry.com/ECommerceWeb/Fawry/payments/status";
        if ($params["sandbox"]) {
            $URL = "https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/status";
        }
        $url2 = $URL . "?merchantCode=" . $MERCHANTCODE . "=&merchantRefNumber=" . $invs["id"] . "&signature=" . $sec2;
        $RES = file_get_contents($url2);
        $RES = json_decode($RES, true);
        logTransaction("fawry", $RES, "Received", "invoice", $invs["id"]);
        if ($RES["statusCode"] == 200) {
            addPayment($invs["id"], $_SESSION[$invs["id"] . "_orderrefno"], $invs["total"], 0, "fawry", 1);
            logTransaction("fawry", $RES, "Successful", "invoice", $invs["id"]);
            unset($_SESSION[$invs["id"] . "_orderrefno"]);
            $tempalte_ver["notification"]["success"] = $RES["statusDescription"];
        } else {
            $tempalte_ver["notification"]["error"] = $RES["statusDescription"];
        }
    }
    if ($payment == "fawry") {
        if (!$email || !$phone) {
            $tempalte_ver["notification"]["error"] = "Email and Phone required";
        } else {
            $params = loadGatewayModule("fawry");
            $invoiceid = $invs["id"];
            $description = $invs["info"];
            $MERCHANTCODE = $params["merchantcode"];
            $SECUREKEY = $params["securekey"];
            $AMOUNT = round($invs["total"], 2);
            if ($_SESSION["currency"]["code"] != "EGP") {
                $AMOUNT = round(convertCurrency($AMOUNT, $_SESSION["currency"]["code"], "EGP"), 2);
            }
            $PAYMETNMETHOD = "PAYATFAWRY";
            $REFNO = $invoiceid;
            $CUSTOMERID = $_SESSION["uid"];
            $AMOUNT = number_format((double) $AMOUNT, 2, ".", "");
            $SIGNATURE = hash("sha256", $MERCHANTCODE . $REFNO . $CUSTOMERID . $PAYMETNMETHOD . $AMOUNT . $SECUREKEY);
            $SiteAddress = $config["site_address"];
            if ($config["config_ssl_allow"]) {
                $SiteAddress = $config["config_ssl_allow"];
            }
            $BODY = "{\n    \"merchantCode\": \"" . $MERCHANTCODE . "\",\n    \"merchantRefNum\": \"" . $REFNO . "\",\n    \"customerProfileId\": \"" . $CUSTOMERID . "\",\n    \"customerMobile\": \"" . $phone . "\",\n    \"customerEmail\": \"" . $email . "\",\n    \"paymentMethod\": \"" . $PAYMETNMETHOD . "\",\n    \"amount\": " . $AMOUNT . ",\n    \"currencyCode\": \"EGP\",\n    \"description\": \"" . $description . "\",\n    \"chargeItems\": [\n        {\n            \"itemId\": \"" . $invoiceid . "\",\n            \"description\": \"" . $description . "\",\n            \"price\": " . $AMOUNT . ",\n            \"quantity\": 1\n        }\n    ],\n    \"signature\": \"" . $SIGNATURE . "\"\n}";
            $URL = "https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge";
            if ($params["sandbox"]) {
                $URL = "https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/charge";
            }
            $ch = curl_init($URL);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $BODY);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $RESPONSE = curl_exec($ch);
            $result = json_decode($RESPONSE, true);
            curl_close($ch);
            if ($result["statusCode"] == 200) {
                $_SESSION[$invoiceid . "_orderrefno"] = $result["referenceNumber"];
                $tempalte_ver["notification"]["success"] = $result["statusDescription"] . " Please check your mobile and make payment. Reference Number : " . $_SESSION[$invoiceid . "_orderrefno"];
            } else {
                $tempalte_ver["notification"]["error"] = $result["statusDescription"];
            }
        }
    }
}
$PaymentMethod = $invs["paymentmethod"];
$FromDirectApply = false;
if ($PaymentMethod == "applycredit" && $invs["status"] == "Unpaid") {
    $PaymentMethod = "";
    $FromDirectApply = true;
    $invs["paymentmethod"] = "";
    $applycredit = true;
    $creditamount = $invs["total"];
}
if ($authorize) {
    $card = preg_replace("/[^0-9]/i", "", $card);
    $cvv = preg_replace("/[^0-9]/i", "", $cvv);
    $month = preg_replace("/[^0-9]/i", "", $month);
    $year = preg_replace("/[^0-9]/i", "", $year);
    if ($card && $month && $year) {
        $Autho = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\n        where gateway='authorizenet' and setting='sendbox'"));
        if ($Autho["value"]) {
            $post_url = "https://test.authorize.net/gateway/transact.dll";
        } else {
            $post_url = "https://secure.authorize.net/gateway/transact.dll";
        }
        $Autho = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\n        where gateway='authorizenet' and setting='loginid'"));
        $logiid = $Autho["value"];
        $Autho = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\n        where gateway='authorizenet' and setting='transactionkey'"));
        $transactionkey = $Autho["value"];
        $fullname = explode(" ", $_SESSION["fullname"]);
        $post_values = ["x_login" => $logiid, "x_tran_key" => $transactionkey, "x_version" => "3.1", "x_delim_data" => "TRUE", "x_delim_char" => "|", "x_relay_response" => "FALSE", "x_type" => "AUTH_CAPTURE", "x_method" => "CC", "x_card_num" => $card, "x_exp_date" => $month . $year, "x_currency_code" => $invs["code"], "x_amount" => $invs["total"], "x_description" => "Add Fund #" . $invs["id"], "x_first_name" => $fullname[0], "x_last_name" => $fullname[1], "x_zip" => $_SESSION["shippingzip"]];
        $post_string = "";
        foreach ($post_values as $key => $value) {
            $post_string .= $key . "=" . urlencode($value) . "&";
        }
        $post_string = rtrim($post_string, "& ");
        $request = curl_init($post_url);
        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
        $post_response = curl_exec($request);
        curl_close($request);
        $response_array = explode($post_values["x_delim_char"], $post_response);
        if ($response_array[0] == 1) {
            list($txnid, $amount) = $response_array;
            $code = $invs["code"];
            $inv = mysqli_fetch_assoc(dquery("select *,(select code from tbl_currencies\nwhere id=(select default_currency from tblUsers where id=userid)) as currency,\n(select default_currency from tblUsers where id=userid) as currencyid \n from tbl_invoices \nwhere md5(id)='" . $id . "'"));
            logTransaction("authorize", $post_response, "Success");
            if ($amount == $invs["total"] && $inv["currency"] == trim($code)) {
                addPayment($inv["id"], $txnid, $amount, "", "authorizenet", 1);
                logTransaction("authorize", $post_response, "Completed");
                $tempalte_ver["notification"]["success"] = "Payment Successful";
            } else {
                $ravecurid = mysqli_fetch_assoc(dquery("select id from tbl_currencies where code='" . $code . "'"));
                $convertedamount = convertCurrency($amount, $ravecurid["id"], $inv["currencyid"]);
                if ($inv["total"] == $convertedamount) {
                    addPayment($inv["id"], $txnid, $convertedamount, "", "authorizenet", 1);
                    logTransaction("authorize", $post_response, "Completed");
                    $tempalte_ver["notification"]["success"] = "Payment Successful";
                } else {
                    logTransaction("authorize", $post_response, "Amount Or Currency Mismatch");
                }
            }
        } else {
            logTransaction("authorize", $post_response, "Error Repeat");
            $tempalte_ver["notification"]["error"] = $response_array[3];
        }
    } else {
        $tempalte_ver["notification"]["error"] = "Required field should not blank";
    }
}
$tempalte_ver["idsn"] = $id;
if (isset($_POST["paypalexpresscheckout"])) {
    unset($_SESSION["paypalexpress"]);
    $params = loadGatewayModule("paypalexpress");
    $params["CART"]["L_PAYMENTREQUEST_0_NAME0"] = "Add Funds #" . $invs["id"];
    $params["CART"]["L_PAYMENTREQUEST_0_NUMBER0"] = 1;
    $params["CART"]["L_PAYMENTREQUEST_0_AMT0"] = round($_SESSION["EXPRESSPARAM"]["amount"], 2);
    $params["CART"]["L_PAYMENTREQUEST_0_QTY0"] = 1;
    $params["CART"]["PAYMENTREQUEST_0_CUSTOM"] = md5($invs["id"]);
    $params["CART"]["PAYMENTREQUEST_1_CUSTOM"] = $invs["id"];
    $params["CART"]["PAYMENTREQUEST_0_SHIPPINGAMT"] = 0;
    $params["CART"]["PAYMENTREQUEST_0_ITEMAMT"] = round($_SESSION["EXPRESSPARAM"]["amount"] - $_SESSION["EXPRESSPARAM"]["invtax"], 2);
    $params["CART"]["PAYMENTREQUEST_0_TAXAMT"] = round($_SESSION["EXPRESSPARAM"]["invtax"], 2);
    $params["CART"]["PAYMENTREQUEST_0_AMT"] = round($_SESSION["EXPRESSPARAM"]["amount"], 2);
    $params["CART"]["CARTBORDERCOLOR"] = "FFFFFF";
    $params["CART"]["ALLOWNOTE"] = 1;
    if (mysqli_num_rows(dquery("select * from tbl_paymentgateways\n            where gateway='paypalexpress' and setting='convertto' and value='1'"))) {
        $GATEWAY = mysqli_fetch_assoc(dquery("select value from \n        tbl_paymentgateways where gateway='paypalexpress' and setting='curcode'"));
        $params["currency"] = $GATEWAY["value"];
    } else {
        $params["currency"] = $_SESSION["currency"]["code"];
    }
    $_SESSION["paypalexpress"]["params"] = $params;
    $postfields = [];
    $postfields["PAYMENTREQUEST_0_PAYMENTACTION"] = "Sale";
    $postfields["PAYMENTREQUEST_0_CURRENCYCODE"] = $params["currency"];
    $postfields["RETURNURL"] = $params["systemurl"] . "/modules/gateways/callback/paypalexpress.php?fund=" . md5($id);
    $postfields["CANCELURL"] = _url("viewinvoice/id/" . md5($id), true);
    foreach ($params["CART"] as $k => $v) {
        $postfields[$k] = $v;
    }
    $results = paypalexpress_viewcart($params);
    $ack = strtoupper($results["ACK"]);
    if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
        logTransaction("PayPal Express", $results, "Successful");
        $_SESSION["paypalexpress"]["token"] = $results["TOKEN"];
        $_SESSION["paypalexpress"]["payerid"] = $params["payerid"];
        header("Location: https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=" . $PAYPAL_URL . $results["TOKEN"]);
        exit;
    }
    logTransaction("PayPal Express", $results, "Error");
    return "PayPal Checkout Error. Please Contact Support.";
} else {
    unset($_SESSION["EXPRESSPARAM"]);
    if (isset($_POST["submitdetail"])) {
        if ($error = checkCustomFields($customfield)) {
            $_GET["paymentfailed"] = "Required custom field should not blank";
        } else {
            include_once ROOTDIR . "/includes/mail.fun.php";
            if (0 >= $_FILES["screenshot"]["error"]) {
                $cont = file_get_contents($_FILES["screenshot"]["tmp_name"]);
                $contensts = explode("?php", $cont);
                if (1 < count($contensts)) {
                    exit;
                }
                list($width, $height, $type, $attr) = getimagesize($_FILES["screenshot"]["tmp_name"]);
                if ($type <= 6 && 0 < $type && isValidExtension($_FILES["screenshot"]["name"])) {
                    $exp = explode(".", $_FILES["screenshot"]["name"]);
                    $ext = end($exp);
                    if ($ext == "php" || $ext == "sh" || $ext == "htaccess" || $ext == "ini" || $ext == "cgi") {
                        exit;
                    }
                    $file = md5($invs["id"] . $_SESSION["uid"]);
                    move_uploaded_file($_FILES["screenshot"]["tmp_name"], $donloaddirpath . "/" . $file . "." . $ext);
                    $filename = $_FILES["screenshot"]["name"];
                    dquery("update tbl_invoices set screenshot='" . $filename . "' where md5(id)='" . $id . "'");
                }
            }
            saveCustomFields($invs["id"], $customfield);
            $mailto[0] = $config["config_admin_mail"];
            dquery("update tbl_invoices set offline='1' where md5(id)='" . $id . "'");
            $adminmessage = "Offline Payment Gateway Updated <br> <br>\n        Invoice ID : " . $invs["id"] . " <br>\n        Username : " . $_SESSION["username"] . " <br />";
            sendNotification("system", "Offline Gateway updated", $adminmessage, $mailto);
            $email_merge_fields = NULL;
            $email_merge_fields["invoiceid"] = $invs["id"];
            sendMail(75, $_SESSION["uid"], "", $email_merge_fields, true);
        }
    }
    if ($_GET["accesskey"] || $_POST["accesskey"]) {
        if ($mid) {
            $id = md5($mid);
        }
        if ($_GET["accesskey"]) {
            $accesskey = $_GET["accesskey"];
        } else {
            if ($_POST["accesskey"]) {
                $accesskey = $_POST["accesskey"];
            }
        }
        $key = base64_decode($accesskey);
        $creditials = explode("===", $key);
        $tempalte_ver["application"] = true;
        $tempalte_ver["accesskey"] = $accesskey;
        $tempalte_ver["id"] = $accesskey;
        $username = descape($creditials[0]);
        $password = $creditials[1];
        $result = dquery("SELECT * FROM `tblUsers` WHERE (`username`='" . $username . "'\n     or `email`='" . $username . "')");
        $data = mysqli_fetch_assoc($result);
        if ($data["id"]) {
            $validIp[] = $data["ip_range1"];
            $validIp[] = $data["ip_range2"];
            $validIp[] = $data["ip_range3"];
            $validIp[] = $data["ip_range4"];
            $validIp[] = $data["ip_range5"];
            if (trim($data["tmp_password"]) == md5($password) && $data["tmp_pass_time"] + 3600 < time()) {
                $err_output .= "<li>" . $lng_languag["passexipred"] . "</li>";
            } else {
                if ($data["password"] != md5(md5($password) . "9486") && trim($data["tmp_password"]) != md5($password) && !$_SESSION["adminid"]) {
                    $err_output .= "<li>" . $lng_languag["passnotmatch"] . "</li>";
                    dquery("UPDATE `tblUsers` SET `login_failed_atoms`=login_failed_atoms+1 \n                                                WHERE `id`= '" . $data["id"] . "'");
                    $mail_ver["blockreson"] = "Automatically block (" . $config["MaxLoginFailedAttempts"] . " failed login attempts) from IP -" . $remote_ip;
                    $config["MaxLoginFailedAttempts"] = $config["MaxLoginFailedAttempts"] - 1;
                    $login_attempts = mysqli_fetch_assoc(dquery("SELECT `login_failed_atoms` FROM `tblUsers` WHERE `id`='" . $data["id"] . "' AND `login_failed_atoms` > '" . $config["MaxLoginFailedAttempts"] . "' "));
                    if ($login_attempts) {
                        dquery("UPDATE `tblUsers` SET `block_reason`='" . $mail_ver["blockreson"] . "',`canactive`=1,`userstatus`='1',`login_failed_atoms`='0' WHERE `id`='" . $data["id"] . "' ");
                        if (!isWhiteIP($remote_ip)) {
                            blockIP($remote_ip, $mail_ver["blockreson"], 15);
                        }
                        require_once ROOTDIR . "/includes/mail.fun.php";
                        sendMail(5, $data["id"], "", $mail_ver);
                    }
                } else {
                    if ($data["userstatus"] != "0" && !$_SESSION["adminid"]) {
                        if ($data["canactive"] && $config["smsgateway"]) {
                            $_SESSION["CANACTIVE"] = true;
                            $varac = "<br />To active your account<strong><a href='" . _url("activeuser") . "'> click here</a></strong>";
                        }
                        $err_output .= "<li>" . $lng_languag["accoutnotact"] . " " . $data["block_reason"] . $varac . " </li>";
                    } else {
                        $ipvalidation = false;
                        if ($data["ip_range"]) {
                            $ipvalidation = checkIPinList($data["ip_range"], $remote_ip);
                        } else {
                            $ipvalidation = true;
                        }
                        if ($ipvalidation) {
                            include_once ROOTDIR . "/includes/geo.fun.php";
                            $gi = geoip_open(ROOTDIR . "/includes/geodata/GeoIP.dat", GEOIP_STANDARD);
                            $login_country_code = Dhrugeoip_country_code_by_addr($gi, $remote_ip);
                            $login_country = Dhrugeoip_country_name_by_addr($gi, $remote_ip);
                            if ($data["login_country"]) {
                                if ($data["country"] != $login_country_code && !$development && trim($data["tmp_password"]) != md5($password)) {
                                    $mail_ver["loginip"] = $remote_ip;
                                    $mail_ver["logincountry"] = $login_country;
                                    $mail_ver["logincountrycode"] = $login_country_code;
                                    require_once ROOTDIR . "/includes/mail.fun.php";
                                    sendMail(51, $data["id"], "", $mail_ver);
                                    if ($config["block_ac_on_country_mismatch"] && !isWhiteIP($remote_ip)) {
                                        $mail_ver["blockreson"] = "Login from " . $login_country . "(" . $login_country_code . ") " . $remote_ip;
                                        dquery("UPDATE `tblUsers` SET `block_reason`='" . $mail_ver["blockreson"] . "',`canactive`='1',`userstatus`='1',`login_failed_atoms`='0' WHERE `id`='" . $data["id"] . "' ");
                                        blockIP($remote_ip, $mail_ver["blockreson"], 15);
                                        sendMail(5, $data["id"], "", $mail_ver);
                                        $block_accout = true;
                                    }
                                }
                            } else {
                                $_addd_to_update = " , `login_country`='" . $login_country_code . "'";
                            }
                            geoip_close($gi);
                            $lastlogin = time();
                            $encdata = md5($_SERVER["HTTP_USER_AGENT"] . $remote_ip);
                            $session = session_id();
                            $time = time();
                            dquery("UPDATE `tblUsers` SET `enc_login`= '" . $encdata . "',`last_login`='" . $lastlogin . "',`last_login_ip`='" . $remote_ip . "',`current_session_id`='" . $session . "',\n                    `current_login_time`='" . $time . "',`online_status`='1' " . $_addd_to_update . ",`login_failed_atoms`='0'\n                    WHERE `id`= '" . $data["id"] . "' ");
                            $ins = NULL;
                            $ins["username"] = $username;
                            $ins["userid"] = $data["id"];
                            $ins["ip"] = $remote_ip;
                            $ins["time"] = time();
                            $db->insert("tbl_loginlog_user", $ins);
                            $ins = NULL;
                            if ($rememberme) {
                                setcookie("GSMBACKBASEUID", $username, time() + 31536000);
                                setcookie("GSMBACKBASEPW", $password, time() + 31536000);
                            }
                            if (!$block_accout) {
                                $_SESSION["uid"] = $data["id"];
                                $_SESSION["username"] = $data["username"];
                                $_SESSION["fullname"] = $data["first_name"] . " " . $data["last_name"];
                                dquery("DELETE FROM `tbl_chat_visitor` WHERE \n                        `username`= '" . $_SESSION["user_livechat_username"] . "'");
                                $_SESSION["user_livechat_username"] = $data["username"];
                                $_SESSION["USERLANG"] = $data["language"];
                                $_SESSION["currency"] = $data["default_currency"];
                                $_SESSION["shippingzip"] = $data["zip"];
                                $_SESSION["shippingstate"] = $data["state"];
                                $_SESSION["shippingcountry"] = $data["country"];
                                if ($config["afterlogin_apply"] && $config["template_afterlogin"] != "") {
                                    $_SESSION["template"] = $config["template_afterlogin"];
                                } else {
                                    if ($data["default_theme"]) {
                                        $_SESSION["template"] = $data["default_theme"];
                                    } else {
                                        $_SESSION["template"] = $config["template_afterlogin"];
                                    }
                                }
                                $_SESSION["encdata"] = $encdata;
                            }
                            $_SESSION["last_login"] = $data["last_login"] . "," . $data["last_login_ip"];
                            $days = $data["lastpassreset"] + $config["password_expired"] * 86400;
                            if ($days < time() && 0 < $config["password_expired"] && !$_SESSION["CART"]) {
                                $_SESSION["afterloginredirect"] = _url("settings/action/password/msg/1");
                            }
                            if ($_SESSION["afterloginredirect"]) {
                                if (stripos($_SESSION["afterloginredirect"], "http") !== false) {
                                    $ste_addr = str_replace("http://", "", $_SESSION["afterloginredirect"]);
                                    $ste_addr = str_replace("https://", "", $ste_addr);
                                    $succ_output .= "redirectto: " . $ste_addr;
                                } else {
                                    $succ_output .= "redirect: " . $_SESSION["afterloginredirect"];
                                }
                                unset($_SESSION["afterloginredirect"]);
                            } else {
                                $succ_output .= "redirect:" . _url("main/lgin/success/") . $lastlogin;
                            }
                        } else {
                            $_SESSION["validIp"] = $_SESSION["validIp"] + 1;
                            if (2 < $_SESSION["validIp"]) {
                                dquery("UPDATE `tblUsers` SET `block_reason`='Automatically block (login tried from IP-" . $remote_ip . ")',`userstatus`='1' WHERE `id`='" . $data["id"] . "'");
                                unset($_SESSION["validIp"]);
                            }
                            $err_output .= "<li>" . $lng_languag["ipnotmatch"] . " (" . $remote_ip . ")</li>";
                        }
                    }
                }
            }
        } else {
            $err_output .= "<li>" . $lng_languag["userincorrect"] . "</li>";
        }
    }
    $invid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $invid);
    $id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
    $gateway = preg_replace("/[^0-9a-z-_]/i", "", $gateway);
    if ($_SESSION["uid"] || $_SESSION["adminid"]) {
        $pagetitle = "";
        $_nav = "";
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        if ($gateway) {
            update_query("tbl_invoices", ["paymentmethod" => $gateway], ["md5(id)" => $id, "userid" => $_SESSION["uid"]]);
            if ($config["taxenabled"]) {
                $taxrate = getTaxRate(1, $_ClientsDetails["state"], $_ClientsDetails["country"], $gateway);
                $taxrate2 = getTaxRate(2, $_ClientsDetails["state"], $_ClientsDetails["country"], $gateway);
                $taxrate = $taxrate["rate"];
                $taxrate2 = $taxrate2["rate"];
                update_query("tbl_invoices", ["taxrate" => $taxrate, "taxrate2" => $taxrate2], ["md5(id)" => $id, "userid" => $_SESSION["uid"]]);
                $nonmd5 = mysqli_fetch_assoc(dquery("select id from tbl_invoices where md5(id)='" . $id . "'"));
                updateInvoiceTotal($nonmd5["id"]);
            }
        }
        $gatewaysarray = getGatewaysArray();
        if ($_SESSION["adminid"]) {
            $result = select_query("tbl_invoices", "", ["md5(id)" => $invid . $id]);
        } else {
            $result = dquery("select * from tbl_invoices where md5(id)='" . $id . "' and \n    (userid='" . $_SESSION["uid"] . "' or userid in (SELECT id from tblUsers where reseller_id='" . $_SESSION["uid"] . "') )");
        }
        $data = mysqli_fetch_assoc($result);
        $mask = $data["mask"];
        $invoicestatus = $data["status"];
        if ($_SESSION["adminid"] && !$_SESSION["uid"]) {
            $_SESSION["uid"] = $data["userid"];
            installclient($pagetitle, $pageicon, $breadcrumbnav);
        }
        $id = $data["id"];
        $invoicenum = $data["invoicenum"];
        $userid = $data["userid"];
        if ($data["paymentmethod"] == "offlinepayments" || $data["paymentmethod"] == "offlinepayments9" || $data["paymentmethod"] == "offlinepayments5" || $data["paymentmethod"] == "offlinepayments6" || $data["paymentmethod"] == "offlinepayments7" || $data["paymentmethod"] == "offlinepayments8" || $data["paymentmethod"] == "offlinepayments10" || $data["paymentmethod"] == "offlinepayments11" || $data["paymentmethod"] == "offlinepayments12" || $data["paymentmethod"] == "offlinepayments13" || $data["paymentmethod"] == "offlinepayments14" || $data["paymentmethod"] == "offlinepayments15" || $data["paymentmethod"] == "offlinepayments16" || $data["paymentmethod"] == "offlinepayments17" || $data["paymentmethod"] == "offlinepayments18" || $data["paymentmethod"] == "offlinepayments19" || $data["paymentmethod"] == "offlinepayments20" || $data["paymentmethod"] == "offlinepayments1" || $data["paymentmethod"] == "offlinepayments2" || $data["paymentmethod"] == "offlinepayments3" || $data["paymentmethod"] == "offlinepayments4") {
            $customfields = getCustomFields($data["paymentmethod"], "", $invs["id"], "on");
            foreach ($customfields as $value) {
                $tempalte_ver["customfields"][$value["name"]] = $value;
            }
            $scren = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways \n    where gateway='offlinepayments' and setting='Client can upload screenshot'"));
            if ($scren["value"]) {
                $smarty->assign("screenshot", 1);
            }
        }
        $user = mysqli_fetch_assoc(dquery("select company,first_name,email,last_name,\ncity,state,phonenumber,zip,country,address,address2 from tblUsers where id='" . $userid . "'"));
        $userDtl["companyname"] = $user["company"];
        $userDtl["firstname"] = $user["first_name"];
        $userDtl["lastname"] = $user["last_name"];
        $userDtl["city"] = $user["city"];
        $userDtl["state"] = $user["state"];
        $userDtl["postcode"] = $user["zip"];
        $userDtl["country"] = $user["country"];
        $userDtl["address1"] = $user["address"];
        $userDtl["address2"] = $user["address2"];
        $smarty->assign("userdetailsd", $userDtl);
        $date = $data["date"];
        $duedate = $data["duedate"];
        $subtotal = $data["subtotal"];
        $credit = $data["credit"];
        if ($config["taxenabled"]) {
            $tax = $data["tax"];
            $tax2 = $data["tax2"];
            $taxrate = $data["taxrate"];
            $taxrate2 = $data["taxrate2"];
        } else {
            $taxrate = "0.00";
            $taxrate2 = "0.00";
        }
        $shippingtax = $data["shippingtax"];
        $total = $data["total"];
        $status = $data["status"];
        $promotion = $data["promotion"];
        $paymentmethod = $data["paymentmethod"];
        $paymentmethod2 = $gatewaysarray[$paymentmethod];
        $notes = $data["notes"];
        $status = $data["status"];
        $datepaid = $data["datepaid"];
        $rawduedate = $duedate;
        $date = formatDate($date);
        $datepaid = formatDate($datepaid, "time");
        $duedate = formatDate($duedate);
        $result = select_query("tbl_transaction", "(SUM(amountin)-SUM(amountout)) as totalpaid", ["invoiceid" => $id]);
        $data = mysqli_fetch_assoc($result);
        $amountpaid = $data["totalpaid"];
        $balance = $total - $amountpaid;
        $balance = sprintf("%01.2f", $balance);
        if (!$invoicenum) {
            $invoicenum = $id;
        }
        if (!$id) {
            $tempalte_ver["notification"]["error"] = $lng_languag["invoicenotfound"];
            $tempaltefile = "client_accessdenied";
            DisplayOutput($tempaltefile);
            exit;
        }
        if ($status == "Unpaid" && $balance <= 0) {
            $tempalte_ver["notification"]["info"] = $lng_languag["paymentcompltedwaiting"];
        }
        if ($gateway) {
            $paymentmethod = $gateway;
        }
        if ($status == "Unpaid" && $paymentmethod && 0 < $balance && $paymentmethod != "applycredit") {
            if ($paymentmethod) {
                dquery("update tbl_invoices set paymentmethod='" . $paymentmethod . "' where (id)='" . $id . "'");
            }
            $params = loadGatewayModule($paymentmethod, $invoicenum, $balance);
            if ($_SESSION["paypalexpress"]["token"] && $_SESSION["paypalexpress"]["payerid"] && $paymentmethod == "paypalexpress") {
                $params = array_merge($params, $_SESSION["paypalexpress"]["params"]);
                if (mysqli_num_rows(dquery("select * from tbl_paymentgateways\n            where gateway='paypalexpress' and setting='convertto' and value='1'"))) {
                    $GATEWAY = mysqli_fetch_assoc(dquery("select value from \n                tbl_paymentgateways where gateway='paypalexpress' \n                and setting='curcode'"));
                    if ($params["CART"]["L_PAYMENTREQUEST_0_NAME0"] != "Add Funds") {
                        $params["basecurrency"] = $GATEWAY["value"];
                        $params["basecurrencyamount"] = convertCurrencyIfDirect("paypalexpress", $params["basecurrencyamount"]);
                        $params["invtax"] = convertCurrencyIfDirect("paypalexpress", $params["invtax"]);
                        foreach ($params["itemamt"] as $k => $v) {
                            $params["itemamt"][$k] = convertCurrencyIfDirect("paypalexpress", $v);
                        }
                        $params["CART"]["L_PAYMENTREQUEST_0_AMT0"] = convertCurrencyIfDirect("paypalexpress", $params["CART"]["L_PAYMENTREQUEST_0_AMT0"]);
                        $params["CART"]["PAYMENTREQUEST_0_ITEMAMT"] = convertCurrencyIfDirect("paypalexpress", $params["CART"]["PAYMENTREQUEST_0_ITEMAMT"]);
                        $params["CART"]["PAYMENTREQUEST_0_TAXAMT"] = convertCurrencyIfDirect("paypalexpress", $params["CART"]["PAYMENTREQUEST_0_TAXAMT"]);
                        $params["CART"]["PAYMENTREQUEST_0_AMT"] = convertCurrencyIfDirect("paypalexpress", $params["CART"]["PAYMENTREQUEST_0_AMT"]);
                        $params["CART"]["AMT"] = round($params["CART"]["PAYMENTREQUEST_0_AMT"], 2);
                    }
                    if (!$params["amount"]) {
                        $params["amount"] = round($_SESSION["paypalexpress"]["totels"]["totalforexpresscheckout"], 2);
                    }
                }
                if ($params["CART"]["AMT"] == 0) {
                    $params["CART"]["AMT"] = round(0 < $total ? $total : $params["amount"], 2);
                    $params["CART"]["PAYMENTREQUEST_0_AMT"] = round(0 < $total ? $total : $params["amount"], 2);
                    $params["CART"]["L_PAYMENTREQUEST_0_AMT0"] = round(0 < $total ? $total : $params["amount"], 2);
                }
                foreach ($params["CART"] as $k => $v) {
                    $budd .= $k . "-" . $v . "\n";
                }
                logTransaction("paypalexpress", $budd, "Before");
                $callbackarry = call_user_func($paymentmethod . "_checkout", $params);
                if ($callbackarry["status"] == "success") {
                    $paypalcurrencyid = $callbackarry["rawdata"]["PAYMENTINFO_0_CURRENCYCODE"];
                    $currency = getCurrency("", $userid);
                    $mc_gross = $callbackarry["rawdata"]["PAYMENTINFO_0_AMT"];
                    $mc_fee = $callbackarry["rawdata"]["PAYMENTINFO_0_FEEAMT"];
                    $txn_id = $callbackarry["transid"];
                    if ($paypalcurrencyid != $currency["id"] && $paypalcurrencyid != "") {
                        $mc_gross = convertCurrency($mc_gross, $paypalcurrencyid, $currency["id"]);
                        $mc_fee = convertCurrency($mc_fee, $paypalcurrencyid, $currency["id"]);
                        $result = select_query("tbl_invoices", "total", ["id" => $invoicenum]);
                        $data = mysqli_fetch_assoc($result);
                        $total = $data["total"];
                        if ($total < $mc_gross + 1 && $mc_gross - 1 < $total) {
                            $mc_gross = $total;
                        }
                    }
                    addPayment($invoicenum, $txn_id, $mc_gross, $mc_fee, "paypalexpress");
                    logTransaction("paypalexpress", $callbackarry, "Success");
                    unset($_SESSION["paypalexpress"]);
                    header("Location: " . _url("viewinvoice/id/") . md5($id));
                    exit;
                }
                logTransaction("paypalexpress", $callbackarry, "Error");
                unset($_SESSION["paypalexpress"]);
                header("Location: " . _url("viewinvoice/id/") . md5($id));
                exit;
            } else {
                if ($paymentmethod == "paypalexpress") {
                    $_SESSION["EXPRESSPARAM"] = $params;
                    $paymentbutton = call_user_func($paymentmethod . "_link", $params);
                } else {
                    if ($status == "Unpaid") {
                        $params["mask"] = "P/" . $mask;
                    } else {
                        $params["mask"] = "I/" . $mask;
                    }
                    $params["invoiceidstripe"] = md5($id);
                    $params["emailforstripe"] = $user["email"];
                    $params["firstname"] = $user["first_name"];
                    $params["lastname"] = $user["last_name"];
                    $params["customerphone"] = $user["phonenumber"];
                    $paymentbutton = call_user_func($paymentmethod . "_link", $params);
                }
            }
        }
        if ($status == "Unpaid") {
            $params["mask"] = "P/" . $config["invoiceprefix"] . $mask;
        } else {
            $params["mask"] = "I/" . $config["invoiceprefix"] . $mask;
        }
        $smarty->assign("invoicemask", $params["mask"]);
        $smarty->assign("companyname", $config["companyname"]);
        if ($invs["status"] == "Unpaid") {
            if ($invs["receivedamount"] == $invs["total"] && $invs["status"] == "Unpaid") {
                $smarty->assign("pagetitle", $lng_languag["orderid"] . " #" . $invs["id"]);
            } else {
                if ($invs["status"] == "Unpaid") {
                    $smarty->assign("pagetitle", $lng_languag["orderid"] . " #" . $invs["id"]);
                } else {
                    $smarty->assign("pagetitle", $lng_languag["proforma"] . " " . $lng_languag["invoice"] . " #" . "P/" . $config["invoiceprefix"] . $invs["mask"]);
                }
            }
        } else {
            $smarty->assign("pagetitle", $lng_languag["invoicenumber"] . "I/" . $config["invoiceprefix"] . $invs["mask"]);
        }
        $smarty->assign("invoiceid", $id);
        $smarty->assign("invoiceidmd5", md5($id));
        $smarty->assign("invoicenum", $invoicenum);
        $smarty->assign("payto", nl2br($config["invoicepayto"]));
        $smarty->assign("datecreated", $date);
        $smarty->assign("promotion", $promotion != 0 ? formatCurrency($promotion) : "");
        $smarty->assign("datedue", $duedate);
        $smarty->assign("subtotal", formatCurrency($subtotal, "", 2));
        $smarty->assign("credit", formatCurrency($credit, "", 2));
        if ($taxrate != "0.00") {
            $taxname = getTaxRate(1, $_ClientsDetails["state"], $_ClientsDetails["country"], $paymentmethod);
            $smarty->assign("taxname", $taxname["name"]);
            $smarty->assign("taxrate", $taxrate);
        }
        if ($taxrate2 != "0.00") {
            $taxname = getTaxRate(2, $_ClientsDetails["state"], $_ClientsDetails["country"], $paymentmethod);
            $smarty->assign("taxname2", $taxname["name"]);
            $smarty->assign("taxrate2", $taxrate2);
        }
        $smarty->assign("taxgoogle", $tax2 + $tax);
        $smarty->assign("totalgoogle", $total);
        $smarty->assign("tax", formatCurrency($tax, "", 2));
        $smarty->assign("tax2", formatCurrency($tax2, "", 2));
        $smarty->assign("shippingcharge", formatCurrency($shippingtax, "", 2));
        $smarty->assign("shippingname", $lng_languag["shippingcharge"]);
        $smarty->assign("total", formatCurrency($total, "", 2));
        $smarty->assign("balance", formatCurrency($balance, "", 2));
        $smarty->assign("status", $status);
        $smarty->assign("datepaid", $datepaid);
        $smarty->assign("paymentmethod", $paymentmethod2);
        $smarty->assign("paymentbutton", $paymentbutton);
        $smarty->assign("offlinepaid", $offlinepaid);
        $smarty->assign("notes", nl2br($notes));
        $smarty->assign("taxtype", $config["taxtype"]);
        $result = select_query("tbl_invoices", "SUM(total)", ["userid" => $userid, "status" => "Unpaid"]);
        $data = mysqli_fetch_assoc($result);
        $alldueinvoices = $data[0];
        $smarty->assign("previousbalance", $alldueinvoices - $total);
        $smarty->assign("alldueinvoices", $alldueinvoices);
        $result = select_query("tbl_transaction", "amountin", ["userid" => $userid], "id", "DESC");
        $data = mysqli_fetch_assoc($result);
        $lastpaymentamount = $data[0];
        $smarty->assign("lastpaymentamount", $lastpaymentamount);
        if ($_ClientsDetails["client_group"]) {
            $CG = mysqli_fetch_assoc(dquery("select * from tbl_client_group\n        where id='" . $_ClientsDetails["client_group"] . "'"));
            if ($CG["paymentgateway"]) {
                $GatewayArr = explode(",", $CG["paymentgateway"]);
            }
        }
        $disabledgateways = [];
        $disabledgateways = array_unique($disabledgateways);
        $gatewaydropdown = "<select name=\"gateway\" class=\"form-control\" onchange=\"submit()\">";
        if (!mysqli_num_rows(dquery("select * from tbl_user_gateway\nwhere userid='" . $_SESSION["uid"] . "'"))) {
            $result = dquery("select * from tbl_paymentgateways group by gateway order by `order` asc");
            while ($data = mysqli_fetch_assoc($result)) {
            }
            $gatewaydropdown .= "</select>";
            $cnto = mysqli_num_rows(dquery("select order_id from tbl_order_product where invoiceid='" . $id . "'\nand (select paymentmethod from tbl_invoices where id='" . $id . "')='cod' "));
            $cnts = mysqli_num_rows(dquery("select order_id from tbl_order_product where invoiceid='" . $id . "' \n    and user_can_c<5 and (select paymentmethod from tbl_invoices where id='" . $id . "')='cod'"));
            if ($cnto == $cnts && $cnto != 0) {
                $smarty->assign("codmsg", $lng_languag["codmsg"]);
                $smarty->assign("allowchangegateway", false);
            } else {
                $smarty->assign("allowchangegateway", $config["can_change_invoice_gateway"]);
            }
            $smarty->assign("gatewaydropdown", $gatewaydropdown);
            require_once ROOTDIR . "/includes/customfield.fun.inc.php";
            $invoiceitems = [];
            $desable_add_credit = true;
            $result = dquery("select *,count(*) as cnt from tbl_invoiceitems where invoiceid='" . $id . "' GROUP BY qnt ORDER BY id ASC");
            while ($data = mysqli_fetch_assoc($result)) {
                $taxed = false;
                if ($data["taxed"]) {
                    $taxed = true;
                }
                if (0 < $data["relid"]) {
                    $desable_add_credit = false;
                }
                if ($data["type"] == "Product") {
                    $sql = mysqli_fetch_assoc(dquery("select service_id from tbl_order_product where order_id='" . $data["relid"] . "'"));
                    $customfields = getCustomFields("product", $sql["service_id"], $data["relid"], "", "", "", false, $_SESSION["currency"]);
                    $freeship = mysqli_fetch_assoc(dquery("select freeship from tbl_products where id='" . $sql["service_id"] . "'"));
                    $cnt = mysqli_num_rows(dquery("select * from tbl_invoiceitems where invoiceid='" . $data["invoiceid"] . "' and qnt='" . $data["qnt"] . "'"));
                    $pro = mysqli_fetch_assoc(dquery("select bundle_list,bundle from tbl_products\n        where id='" . $sql["service_id"] . "'"));
                    if ($pro["bundle"]) {
                        $bundles = [];
                        $ex = explode(",", $pro["bundle_list"]);
                        foreach ($ex as $e) {
                            $s = mysqli_fetch_assoc(dquery("select service_name from tbl_products where id='" . $e . "'"));
                            $bundles[$e] = $s["service_name"];
                        }
                    }
                } else {
                    $cnt += 0 < $data["qnt"] ? $data["qnt"] : 1;
                    $customfields = NULL;
                }
                $imei = "";
                if ($data["type"] == "IMEI" && $data["relid"]) {
                    $imei = mysqli_fetch_assoc(dquery("select imei from tbl_order_imei where \n        order_id='" . $data["relid"] . "'"));
                    $imei = $imei["imei"];
                }
                if ($data["type"] == "AddFunds") {
                    $data["description"] = $data["description"] . " #" . $id;
                }
                if ($imei) {
                    $invoiceitems[] = ["id" => $data["id"], "type" => $data["type"], "relid" => $data["relid"], "description" => nl2br(html_entity_decode($data["description"] . "<br/> IMEI:<strong>" . $imei . "</strong>")), "freeship" => $freeship["freeship"], "unitprice" => 0 < $data["amount"] ? formatCurrency($data["amount"]) : "", "amount" => formatCurrency($data["amount"] * $cnt), "amountgoogle" => $data["amount"], "taxed" => $taxed, "bundle" => $bundles, "customfields" => $customfields, "qnt" => $cnt];
                } else {
                    $invoiceitems[] = ["id" => $data["id"], "type" => $data["type"], "relid" => $data["relid"], "description" => nl2br(html_entity_decode($data["description"])), "freeship" => $freeship["freeship"], "unitprice" => 0 < $data["amount"] ? formatCurrency($data["amount"]) : "", "amount" => formatCurrency($data["amount"] * $cnt), "amountgoogle" => $data["amount"], "taxed" => $taxed, "bundle" => $bundles, "customfields" => $customfields, "qnt" => $cnt];
                }
                if ($data["type"] == "AddFunds" || $data["type"] == "AddFunds by Admin") {
                    $desable_add_credit = true;
                }
                $promocode = $data["promotion_code"];
            }
            $CustomofInvoice = getCustomFields($paymentmethod, "", $invs["id"]);
            $smarty->assign("invoicecustom", $CustomofInvoice);
            $smarty->assign("invoiceitems", $invoiceitems);
            $smarty->assign("promotion_code", $promocode);
            if ($_ClientsDetails["credit"]["credit"] != "0.00" && $status == "Unpaid" && !$desable_add_credit) {
                if ($applycredit) {
                    $totalcredit = $_ClientsDetails["credit"]["credit"];
                    if ($totalcredit < $creditamount || $creditamount < 0) {
                        echo $lng_languag["cannotapplycredit"];
                        exit;
                    }
                    if ($balance < $creditamount) {
                        echo $lng_languag["cannotapplycredit"];
                        exit;
                    }
                    if (!function_exists(applyCredit)) {
                        include_once ROOTDIR . "/includes/invoice.fun.php";
                    }
                    global $adminAddPayment;
                    $adminAddPayment = true;
                    applyCredit($id, $userid, $creditamount);
                    dquery("update tbl_invoices set paymentmethod='' where id='" . $id . "'");
                    header("Location: " . _url("viewinvoice/id/" . md5($id)));
                    exit;
                }
                $smarty->assign("applycredit", true);
                $smarty->assign("totalcredit", formatCurrency($_ClientsDetails["credit"]["credit"]));
                if (!$creditamount) {
                    if ($_ClientsDetails["credit"]["credit"] <= $balance) {
                        $creditamount = $_ClientsDetails["credit"]["credit"];
                    } else {
                        $creditamount = $balance;
                    }
                }
                $smarty->assign("creditamount", $creditamount);
            }
            $Gateways = "";
            $transactions = [];
            $result = select_query("tbl_transaction", "", ["invoiceid" => $id], "date` ASC,`id", "ASC");
            while ($data = mysqli_fetch_assoc($result)) {
                $date = $data["date"];
                $date = formatDate($date);
                $gateway = $data["gateway"];
                $description = $data["description"];
                $amountin = $data["amountin"];
                $fees = $data["fees"];
                $amountout = $data["amountout"];
                $transid = $data["transid"];
                $invoiceid = $data["invoiceid"];
                $gateway = $gatewaysarray[$gateway];
                $Gateways .= $gateway . ",";
                if (!$gateway) {
                    $gateway = "-";
                }
                $smarty->assign("paiddate", trim($date));
                $transactions[] = ["date" => $date, "gateway" => $gateway, "transid" => $transid, "amount" => formatCurrency($amountin - $amountout)];
            }
            $smarty->assign("paidgateway", trim($Gateways, ","));
            $smarty->assign("transactions", $transactions);
            if ($_SESSION["adminid"] && !$_SESSION["uid"]) {
                unset($_SESSION["uid"]);
            }
            $smarty->assign("sitepath", $config["site_address"]);
            if ($autoredirect) {
                if ($PaymentMethod == "payumoney") {
                    $smarty->assign("instapay", 1);
                } else {
                    if ($gateway != "cod") {
                        echo "<br><br><br><br><div align='center'> " . $lng_languag["pleasewaitpaypal"] . " " . $paymentbutton . "</div>";
                        echo "<script> document.forms[0].submit(); </script>";
                        exit;
                    }
                    echo "<br><br><br><br><div align='center'> " . $paymentbutton . "</div>";
                    echo "<script> document.forms[0].submit(); </script>";
                    exit;
                }
            } else {
                if (!$a && $gateway != "paypal") {
                    require_once ROOTDIR . "/includes/mail.fun.php";
                    if ($invoicestatus == "Unpaid") {
                        $adminmessage .= "New Order Placed by Offline Gateway.\n                Please process order manually <br /><br />\n                ========================<br />\n                Gateway   : " . $gateway . " <br />\n                Invoice ID: P/" . $mask . " <br />\n                Username  : " . $_SESSION["username"] . " #" . $_SESSION["uid"] . "<br />\n                Full Name : " . $_SESSION["fullname"];
                    } else {
                        $adminmessage .= "New Order Placed by Offline Gateway.\n                Please process order manually <br /><br />\n                ========================<br />\n                Gateway   : " . $gateway . " <br />\n                Invoice ID: I/" . $id . " <br />\n                Username  : " . $_SESSION["username"] . " #" . $_SESSION["uid"] . "<br />\n                Full Name : " . $_SESSION["fullname"] . " ";
                    }
                    sendNotification("system", "New Order Place by Offline Gateway", $adminmessage, $mailto);
                }
            }
            $error = preg_replace("/[^0-9\\-a-zA-Z\\ ]/i", "", $error);
            if ($error) {
                $tempalte_ver["codmsg"] = $error;
            }
            if ($invs["receivedamount"] == $invs["total"] && $invs["status"] == "Unpaid") {
                $tempalte_ver["status"] = $lng_languag["waitingapproval"];
                $tempalte_ver["applycredit"] = 0;
            }
            $tempalte_ver["token"] = generate_token("form");
            chkMd5sumsubpage();
            if ($paymentsuccess) {
                $SiteAddress = $config["site_address"];
                if ($config["config_ssl_allow"]) {
                    $SiteAddress = $config["config_ssl_allow"];
                }
                header("Location:" . _url("cart/ordersucceess/a/invoice/" . md5($id), true));
            }
            if ($standalone) {
                $smarty->assign("standalone", 1);
            }
            if ($webview || isset($_SESSION["webview"]) || isset($_SESSION["fromapp"]) || $standalone) {
                $smarty->assign("mobileinvoice", 1);
                $smarty->assign("fromapp", 1);
                $smarty->assign("standalone", 1);
                echo processSingleTemplate($templatefile);
            } else {
                DisplayOutput($templatefile);
            }
        } else {
            $result = dquery("select * from tbl_paymentgateways \n   where gateway in (select payment from tbl_user_gateway where userid='" . $_SESSION["uid"] . "')\n   group by gateway order by `order` asc");
        }
        if (!($data["gateway"] == "directpaypal1" || $data["gateway"] == "directpaypal2" || $data["gateway"] == "directpaypal3" || $data["gateway"] == "directpaypal4" || $data["gateway"] == "directpaypal5")) {
            if (!(isset($_SESSION["uid"]) && mysqli_num_rows(dquery("select * from tbl_user_gateway\n            where userid='" . $_SESSION["uid"] . "'")) && !mysqli_num_rows(dquery("select * from tbl_user_gateway\n                where userid='" . $_SESSION["uid"] . "' and payment='" . $data["gateway"] . "'")))) {
                if (!($_ClientsDetails["client_group"] && count($GatewayArr)) || in_array($data["gateway"], $GatewayArr)) {
                    $gateway = $data["gateway"];
                    $result2 = select_query("tbl_paymentgateways", "", ["setting" => "visible", "value" => "1", "gateway" => $gateway]);
                    $data2 = mysqli_fetch_assoc($result2);
                    $gwid = $data2["gateway"];
                    $skip_gateway = false;
                    if (in_array($gwid, $disabledgateways)) {
                        $skip_gateway = true;
                    }
                    if ($gateway == $paymentmethod) {
                        $gwid = 1;
                        $skip_gateway = false;
                    }
                    if ($gwid && !$skip_gateway) {
                        $result2 = select_query("tbl_paymentgateways", "", ["setting" => "name", "gateway" => $gateway]);
                        $data2 = mysqli_fetch_assoc($result2);
                        $value = $data2["value"];
                        $gatewaydropdown .= "<option value=\"" . $gateway . "\"";
                        if ($gateway == $paymentmethod) {
                            $gatewaydropdown .= " selected=\"selected\"";
                        }
                        $gatewaydropdown .= ">" . $value . "</option>";
                    }
                }
            }
        }
    } else {
        include "includes/login.inc.php";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        DisplayOutput($templatefile);
        exit;
    }
}

?>