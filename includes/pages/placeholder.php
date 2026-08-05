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
header_remove("Content-Security-Policy");
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/imeiservices.fun.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
require_once ROOTDIR . "/includes/invoice.fun.php";
require_once ROOTDIR . "/includes/mail.fun.php";
$gat = preg_replace("/[^0-9A-Za-z]/i", "", $gat);
$group = preg_replace("/[^0-9A-Za-z]/i", "", $group);
global $precision;
if (isset($_REQUEST["chargeResponse"])) {
    $Res = $_REQUEST["chargeResponse"];
    $Res = explode(",", $Res);
    $MERCHANTREFNO = "";
    $FAWRYREFNO = "";
    $PAYMENTMETHOD = "";
    foreach ($Res as $k => $val) {
        $peice = explode(":", $val);
        if (strpos($peice[0], "merchantRefNumber") !== false) {
            $MERCHANTREFNO = trim(urldecode($peice[1]), "&quote;");
        }
        if (strpos($peice[0], "fawryRefNumber") !== false) {
            $FAWRYREFNO = str_replace("\"", "", $peice[1]);
            $FAWRYREFNO = trim(urldecode($FAWRYREFNO), "&quote;");
        }
        if (strpos($peice[0], "paymentMethod") !== false) {
            $PAYMENTMETHOD = str_replace("\"", "", $peice[1]);
            $PAYMENTMETHOD = trim(urldecode($PAYMENTMETHOD), "&quote;");
        }
    }
    if ($FAWRYREFNO && $MERCHANTREFNO) {
        require_once ROOTDIR . "/includes/gateway.fun.php";
        $GATEWAY = loadGatewayModule("fawry");
        logTransaction("fawry", $_REQUEST["chargeResponse"], "charge response");
        $merchantrefno = $MERCHANTREFNO;
        $merchantcode = $GATEWAY["merchantcode"];
        $customerid = $_SESSION["uid"];
        $securekey = $GATEWAY["securekey"];
        $sec2 = hash("sha256", $merchantcode . $merchantrefno . $securekey);
        $URL = "https://www.atfawry.com/ECommerceWeb/Fawry/payments/status";
        if ($GATEWAY["sandbox"]) {
            $URL = "https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/status";
        }
        $url2 = $URL . "?merchantCode=" . $merchantcode . "&merchantRefNumber=" . $merchantrefno . "&signature=" . $sec2;
        $RES = file_get_contents($url2);
        $RES = json_decode($RES, true);
        if ($RES["statusCode"] == 200 && $RES["paymentStatus"] == "PAID") {
            $inv = mysqli_fetch_assoc(dquery("select total from tbl_invoices where id='" . $RES["merchantRefNumber"] . "'"));
            logTransaction("fawry", $RES, "success");
            addPayment($RES["merchantRefNumber"], $RES["referenceNumber"], $inv["total"], 0, "fawry", 1);
            header("Location: " . _url("viewinvoice/id/" . md5($RES["merchantRefNumber"])));
            echo "            <script>\n                location.href = '";
            echo _url("viewinvoice/id/" . md5($RES["merchantRefNumber"]));
            echo "';\n            </script>\n            ";
        } else {
            if ($RES["paymentStatus"] == "UNPAID") {
                $invoiceid = $RES[merchantRefNumber];
                if ($RES["paymentMethod"] == "PAYATFAWRY") {
                    $_SESSION["fawry_" . $invoiceid] = $RES["referenceNumber"];
                }
                logTransaction("fawry", $RES, "unpaid");
                header("Location: ", _url("viewinvoice/id/" . md5($RES["merchantRefNumber"])));
                echo "            <script>\n                location.href = '";
                echo "viewinvoice/id/" . md5($RES["merchantRefNumber"]);
                echo "';\n            </script>\n            ";
            }
        }
    }
    exit;
} else {
    if ($actiongateway == "rakbankpay") {
        $params = decrypt($q, "AKSDFLK239RLAKJDLK239FUALJFLADJ");
        $params = json_decode(trim($params), true);
        $SiteAddress = $config["site_address"];
        if ($config["config_ssl_allow"]) {
            $SiteAddress = $config["config_ssl_allow"];
        }
        $IsWallet = false;
        $LinktoCancel = $SiteAddress . _url("viewinvoice/id/" . md5($params[invoiceid]) . "/paymentfailed/true");
        $LinktoSuccess = $SiteAddress . _url("viewinvoice/id/" . md5($params[invoiceid]) . "/rakbankpayprocesssuccess/true");
        $walt = explode("_", $params[invoiceid]);
        if ($walt[0] == "B") {
            $LinktoCancel = "./merchant/index.php?login=succes&paymentfailed=true";
            $LinktoSuccess = "./merchant/index.php?login=succes&rakbankpayprocesssuccess=true";
            $IsWallet = true;
        }
        echo "<script src=\"https://rakbankpay.gateway.mastercard.com/checkout/version/55/checkout.js\"\n                data-error=\"errorCallback1111\"\n                data-cancel=\"cancelCallback111\"\n                data-complete=\"completeCallback111\"\n                ></script>\n<script type=\"text/javascript\">\n         \n            function errorCallback1111(error) {\n                console.log(\"Error...\");\n                  console.log(JSON.stringify(error));\n                  window.location.href =\"" . $LinktoCancel . "\";\n            }\n            function cancelCallback111() {\n                  console.log('Payment cancelled');\n                  window.location.href = \"" . $LinktoCancel . "\";\n            }\n            function completeCallback111(data) {\n                  window.location.href = \"" . $LinktoSuccess . "\";\n                  console.log(JSON.stringify(data));\n                  console.log('Payment Success');\n            }\n\n            Checkout.configure({\n                merchant: '" . $params[merchant_id] . "',\n                order: {\n                    amount: " . sprintf("%0.2f", round($params["amount"], 2)) . ",\n                    currency: '" . $params["currency"] . "',\n                    description: '" . $params["description"] . "',\n                    id: '" . $params["invoiceid"] . "'\n                },\n                session : {\n                    id : '" . $params["session_id"] . "'\n                    },\n                interaction: {\n                    operation: 'PURCHASE', // set this field to 'PURCHASE' for Hosted Checkout to perform a Pay Operation.\n                    merchant: {\n                        name: '" . $params["companyname"] . "'\n                    }\n                }\n            });\n            \n        </script>";
        if (!$params["invoiceid"]) {
            exit("!Invoice ID");
        }
        echo "<script>Checkout.showLightbox();</script>";
        exit;
    }
    if ($actiongateway == "vnpay") {
        require_once ROOTDIR . "/includes/gateway.fun.php";
        $GATEWAY = loadGatewayModule("vnpay");
        $invoiceid = preg_replace("/[^0-9A-Za-z_]/i", "", $invoiceid);
        $vnp_TxnRef = $invoiceid;
        $Invoices = explode("_", $invoiceid);
        $InvoiceItems = mysqli_fetch_assoc(dquery("select description from tbl_invoiceitems\n    WHERE invoiceid='" . $Invoices[0] . "'"));
        $InvoiceDtl = mysqli_fetch_assoc(dquery("select total from tbl_invoices\n    WHERE id='" . $Invoices[0] . "'"));
        $vnp_OrderInfo = $InvoiceItems["description"];
        $vnp_OrderType = "other";
        $vnp_Amount = $InvoiceDtl["total"] * 100;
        $vnp_Locale = "en";
        $vnp_BankCode = $bankcode;
        $vnp_IpAddr = $_SERVER["REMOTE_ADDR"];
        $SiteAddress = $config["site_address"];
        if ($config["config_ssl_allow"]) {
            $SiteAddress = $config["config_ssl_allow"];
        }
        $returnurl = $SiteAddress . "/modules/gateways/callback/vnpay.php";
        $inputData = ["vnp_Version" => "2.0.0", "vnp_TmnCode" => $GATEWAY["webcode"], "vnp_Amount" => $vnp_Amount, "vnp_Command" => "pay", "vnp_CreateDate" => date("YmdHis"), "vnp_CurrCode" => $GATEWAY["currency"], "vnp_IpAddr" => $vnp_IpAddr, "vnp_Locale" => $vnp_Locale, "vnp_OrderInfo" => $vnp_OrderInfo, "vnp_OrderType" => $vnp_OrderType, "vnp_ReturnUrl" => $returnurl, "vnp_TxnRef" => $vnp_TxnRef];
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData["vnp_BankCode"] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= "&" . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . "&";
        }
        $vnp_Url = "http://vnpayment.vn/paymentv2/vpcpay.html";
        if ($GATEWAY["mode"] == "Sandbox") {
            $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        }
        $vnp_HashSecret = $GATEWAY["secret"];
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash("sha256", $vnp_HashSecret . $hashdata);
            $vnp_Url .= "vnp_SecureHashType=SHA256&vnp_SecureHash=" . $vnpSecureHash;
        }
        header("Location: " . $vnp_Url);
        exit;
    } else {
        if (!(isset($_REQUEST["responseParameter"]) && $_REQUEST["responseParameter"] != "")) {
            if ($actiongateway == "stripe" && !empty($_POST["stripeToken"]) && $invoiceid) {
                require_once ROOTDIR . "/includes/3rdparty/stripe/init.php";
                require_once ROOTDIR . "/includes/gateway.fun.php";
                $invoiceid = preg_replace("/[^0-9A-Za-z]/i", "", $invoiceid);
                $GATEWAY = loadGatewayModule("stripe");
                try {
                    $stripe = ["secret_key" => $GATEWAY["secret_key"], "publishable_key" => $GATEWAY["publisher_key"]];
                    Stripe\Stripe::setApiKey($stripe["secret_key"]);
                    $inv = mysqli_fetch_assoc(dquery("select id,total,(select code from \ntbl_currencies where id=(select default_currency from tblUsers where \nid=tbl_invoices.userid)) as currency,(select description\nfrom tbl_invoiceitems where invoiceid=tbl_invoices.id) as item\n ,(select `type`\nfrom tbl_invoiceitems where invoiceid=tbl_invoices.id) as itemtype\n \n from tbl_invoices \n    where md5(id)='" . $invoiceid . "' and userid='" . $_SESSION["uid"] . "'"));
                    $Cust = mysqli_fetch_assoc(dquery("select address,address2,city,country,zip,state from tblUsers where \nid='" . $_SESSION["uid"] . "'"));
                    if (!$inv["id"]) {
                        echo "<script> location.href=" . _url("main/payment/error") . ";</script>";
                    }
                    $token = $_POST["stripeToken"];
                    $name = $_POST["name"];
                    $email = $_POST["email"];
                    $card_num = $_POST["card_num"];
                    $card_cvc = $_POST["cvc"];
                    $card_exp_month = $_POST["exp_month"];
                    $card_exp_year = $_POST["exp_year"];
                    $customer = Stripe\Customer::create(["name" => $name, "address" => ["line1" => $Cust["address"], "line2" => $Cust["address2"], "city" => $Cust["city"], "state" => $Cust["state"], "country" => $Cust["country"], "postal_code" => $Cust["zip"]], "email" => $email, "source" => $token]);
                    if ($inv["type"] == "AddFunds") {
                        $inv["item"] = $config["companyname"] . " " . $inv["item"];
                    }
                    $itemName = $inv["item"];
                    $itemNumber = $invoiceid;
                    $itemPrice = $inv["total"];
                    $currency = $inv["currency"];
                    $orderID = $invoiceid;
                    $charge = Stripe\Charge::create(["customer" => $customer->id, "amount" => round($itemPrice * 100, 0), "currency" => $currency, "description" => $itemName, "metadata" => ["order_id" => $orderID]]);
                    logTransaction("stripe", $customer->id . "=" . "Price: " . $itemPrice . "Currency : " . $currency, "before", $orderID);
                    $chargeJson = $charge->jsonSerialize();
                    logTransaction("stripe", $chargeJson, "charge", $orderID);
                    if ($chargeJson["amount_refunded"] == 0 && empty($chargeJson["failure_code"]) && $chargeJson["paid"] == 1 && $chargeJson["captured"] == 1) {
                        $amount = round($chargeJson["amount"] / 100, 2);
                        $balance_transaction = $chargeJson["balance_transaction"];
                        $currency = $chargeJson["currency"];
                        $status = $chargeJson["status"];
                        $date = date("Y-m-d H:i:s");
                        $sendinvoiceid = $chargeJson["metadata"]["order_id"];
                        if ($status == "succeeded") {
                            $statusMsg = "<h2>The transaction was successful.</h2><h4>Order ID: " . $last_insert_id . "</h4>";
                            if ($amount == round($itemPrice, 2) && $sendinvoiceid == $invoiceid) {
                                addPayment($inv["id"], $balance_transaction, $amount, "", "stripe", true, "", "", "");
                                echo "<script> location.href='" . _url("viewinvoice/id/" . $invoiceid) . ";</script>";
                            } else {
                                echo "<script> location.href='" . _url("main/payment/error/msg/Amount not match") . ";</script>";
                            }
                        } else {
                            $statusMsg = "Transaction has been failed";
                            echo "<script> location.href='" . _url("main/id/" . $invoiceid . "/msg/" . $statusMsg) . ";</script>";
                        }
                    } else {
                        $statusMsg = "Transaction has been failed";
                        echo "<script> location.href='" . _url("main/payment/error/msg/" . $statusMsg) . ";</script>";
                    }
                } catch (Exception $exception) {
                    echo "<script> location.href='" . _url("viewinvoice/id/" . $invoiceid . "/error/" . $exception->getMessage()) . "';</script>";
                }
            } else {
                if ($funds) {
                    $amount = preg_replace("/[^0-9.]/i", "", $amount);
                    $gatewaywise = json_decode($config["otherfundlimit"], true);
                    $paymentmethod = "paypal";
                    if (0 < $gatewaywise[$paymentmethod]["minlimit"]) {
                        $config["AddFundsMinimum"] = $gatewaywise[$paymentmethod]["minlimit"];
                    }
                    $orderid = $storeowner["id"] * 123 . "-" . $_SESSION["uid"] * 247;
                    $orderid = base64_encode($orderid);
                    if (is_numeric($amount) && $amount != "" && $config["AddFundsMinimum"] <= $amount) {
                        if ($storecoinbase) {
                            $CURRENCYCODE = $_SESSION["currency"]["code"];
                            if ($config["coinbasecurrency"]) {
                                $cur = mysqli_fetch_assoc(dquery("select code from tbl_currencies where \n                       id='" . $config["paypalcurrency"] . "'"));
                                $CURRENCYCODE = $cur["code"];
                                $amount = convertCurrency($amount, $_SESSION["currency"]["id"], $config["coinbasecurrency"]);
                            }
                            require_once ROOTDIR . "/includes/gateway.fun.php";
                            $orderid = $storeowner["id"] * 123 . "-" . $_SESSION["uid"] * 247;
                            $Gateway = loadGatewayModule("coinbase", $orderid, $amount);
                            $Gateway["currency"] = $CURRENCYCODE;
                            $Gateway["apiKey"] = $config["coinbaseapikey"];
                            $Gateway["otherinvoiceid"] = $orderid;
                            $Form = coinbase_link($Gateway);
                            echo "<br><br><br><br>\n        <div align='center'>Please wait while we redirect to \n        payment if not redirect within 5 sec Click here " . $Form . "</div>";
                            echo "<script> document.forms[0].submit(); </script>";
                        } else {
                            $tax = round($amount * $config["paypaltax"] / 100, $precision);
                            $paypallink = "https://www.paypal.com/cgi-bin/webscr";
                            if ($demomode) {
                                $paypallink = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                            }
                            $CURRENCYCODE = $_SESSION["currency"]["code"];
                            if ($config["paypalcurrency"]) {
                                $cur = mysqli_fetch_assoc(dquery("select code from tbl_currencies where \n                       id='" . $config["paypalcurrency"] . "'"));
                                $CURRENCYCODE = $cur["code"];
                                $amount = convertCurrency($amount, $_SESSION["currency"]["id"], $config["paypalcurrency"]);
                            }
                            $code .= "<form action=\"" . $paypallink . "\" method=\"post\">\n    <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\n    <input type=\"hidden\" name=\"business\" value=\"" . $config["paypalid"] . "\">";
                            $code .= "<input type=\"hidden\" name=\"item_name\" value=\"Add Fund Reseller Store\">\n    <input type=\"hidden\" name=\"amount\" id=\"storeamount\" value=\"" . $amount . "\">\n    <input type=\"hidden\" name=\"tax\" id=\"taxcal\" value=\"" . round($tax, 2) . "\">\n    <input type=\"hidden\" name=\"no_note\" value=\"1\">\n    <input type=\"hidden\" name=\"no_shipping\" value=\"1\">\n    <input TYPE=\"hidden\" name=\"charset\" value=\"UTF-8\">\n    <input type=\"hidden\" name=\"currency_code\" value=\"" . $CURRENCYCODE . "\">\n    <input type=\"hidden\" name=\"custom\" value=\"" . $orderid . "\">\n    <input type=\"hidden\" name=\"return\" value=\"" . ($config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"]) . "main.php?paymentsuccess=true\">\n    <input type=\"hidden\" name=\"cancel_return\" value=\"" . ($config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"]) . "main.php?paymentfailed=true\">\n    <input type=\"hidden\" name=\"notify_url\" value=\"" . ($config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"]) . "modules/gateways/callback/storepaypal.php\">\n    <input type=\"hidden\" name=\"bn\" value=\"DHRUFUSION\">\n    <input type=\"hidden\" name=\"rm\" value=\"2\">\n    <input type=\"submit\" \n    value=\"" . $lng_languag["invoicespaynow"] . "\" \n    alt=\"" . $lng_languag["invoicespaynow"] . "\">\n    </form>";
                            echo "<br><br><br><br>\n        <div align='center'>Please wait while we redirect to \n        payment if not redirect within 5 sec Click here " . $code . "</div>";
                            echo "<script> document.forms[0].submit(); </script>";
                        }
                    } else {
                        echo "<script> location.href='" . _url("main/payment/error") . "';</script>";
                    }
                } else {
                    $servicetype = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $servicetype);
                    $action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
                    $serviceid = preg_replace("/[^0-9]/i", "", $serviceid);
                    $qnt = preg_replace("/[^0-9]/i", "", $qnt);
                    $order = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $order);
                    global $group;
                    if ($order != "") {
                        if ($gat == "2checkout") {
                            $selgateway = "tco";
                        } else {
                            if ($gat == "googlecheckout") {
                                $selgateway = "googlecheckout";
                            } else {
                                if ($gat == "rave") {
                                    $selgateway = "rave";
                                } else {
                                    $selgateway = "paypal";
                                }
                            }
                        }
                        $sql = mysqli_fetch_assoc(dquery("select order_id,qnt,service_id,(select service_name from tbl_services_imei \n                where id=service_id) as service,\n                (select notificationemail from tbl_services_imei where id=service_id) as notificationemail,\n                (select notification_mail from tbl_services_imei where id=service_id) as notification_mail,\n                (select username from tblUsers where id=user_id) as username,\n                service_id,credit,imei,discount from tbl_order_imei where md5(order_id)='" . $order . "'"));
                        $serviceDetails = getIMEIServices("", md5($sql["service_id"]), "", "", "", "", true);
                        $params["orderid"] = $sql["order_id"];
                        if (!$sql["qnt"] || $sql["qnt"] < 1) {
                            $sql["qnt"] = 1;
                        }
                        $params["amount"] = ($serviceDetails["credit"] - $serviceDetails["discount"]) * $sql["qnt"];
                        $paypal = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways where gateway='" . $selgateway . "' and setting='SendBox'"));
                        $params["SendBox"] = $paypal["value"];
                        $paypal = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways where gateway='" . $selgateway . "' and setting='email'"));
                        $params["email"] = $paypal["value"];
                        $params["description"] = $serviceDetails["service_name"];
                        $params["email"] = $paypal["value"];
                        $paypal = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways where gateway='" . $selgateway . "' and setting='convertto'"));
                        if ($paypal["value"] == "DONOTPROCESS") {
                            $params["currency"] = $_SESSION["currency"]["code"];
                        } else {
                            $cod = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $paypal["value"] . "'"));
                            $params["currency"] = $cod["code"];
                            if ($_SESSION["system_default_currency"]["id"] == $paypal["value"]) {
                                $serv = mysqli_fetch_assoc(dquery("select credit from tbl_services_imei where id='" . $serviceDetails["id"] . "'"));
                                $params["amount"] = ($serviceDetails["credit"] - $serviceDetails["discount"]) * $sql["qnt"];
                            } else {
                                $params["amount"] = getIMEIPrice($serviceDetails["id"], $paypal["value"]);
                                if (!$params["amount"]) {
                                    $params["amount"] = convertCurrency(($serviceDetails["credit"] - $serviceDetails["discount"]) * $sql["qnt"], $_SESSION["currency"]["id"], $paypal["value"]);
                                }
                            }
                        }
                        $service = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("editimeiservice&id=" . $sql["service_id"]) . "&title=" . base64_encode("Edit IMEI Service") . "'>" . $sql["service"] . "</a>";
                        $adminmessage = "Service Name: " . $service . "<br><Br>";
                        $adminmessage .= "&nbsp;&nbsp; IMEI : " . $sql["imei"] . "<br>";
                        $adminmessage .= "&nbsp;&nbsp; Order ID: " . $sql["order_id"] . "<br>";
                        $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("includes/pages/utilities.processorder.php?id=" . $sql["order_id"]) . "&title=" . base64_encode("Quick checkout Order") . "'>here</a>";
                        $adminmessage .= "<br /> <br /> You can process order from " . $here;
                        if (!$sql["notificationemail"]) {
                            $mailto = explode(",", $sql["notification_mail"]);
                            if ($config["adminotice_neworder"] && $config["adminnotice"]) {
                                sendNotification("system", "New Order by IMEI Quick checkout - " . $selgateway, $adminmessage, $mailto);
                            }
                        }
                        if ($serviceDetails["taxed"]) {
                            $taxarr = getTaxRate(1, "", "", "paypal");
                            $taxarr2 = getTaxRate(2, "", "", "paypal");
                            $taxrate = $taxarr["rate"];
                            $taxrate2 = $taxarr2["rate"];
                            if ($taxrate != "0.00" && $config["taxtype"] == "Exclusive") {
                                $TAX = $taxarr["rate"];
                            }
                            if ($taxrate2 != "0.00" && $config["taxtype"] == "Exclusive") {
                                $TAX = $taxarr2["rate"];
                            }
                            $TAX = $params["amount"] * $TAX / 100;
                        }
                        $params["tax"] = $TAX;
                        $params["id"] = $sql["order_id"];
                        if ($config["config_ssl_allow"]) {
                            $GATEWAY["systemurl"] = $config["config_ssl_allow"];
                        } else {
                            $GATEWAY["systemurl"] = $config["site_address"];
                        }
                        $params["returnurl"] = $GATEWAY["systemurl"] . _url("cart/service/imei/group/" . $group);
                        $params["systemurl"] = $GATEWAY["systemurl"];
                        if ($gat == "ravepay") {
                            require_once "modules/gateways/rave.php";
                            $gch = mysqli_fetch_assoc(dquery("select value from \n            tbl_paymentgateways where gateway='rave' and setting='publickey'"));
                            $params["publickey"] = $gch["value"];
                            $params["emailforstripe"] = $gch["value"];
                            $params["amount"] = $gch["value"];
                            $params["customerphone"] = $gch["value"];
                            $params["currency"] = $gch["value"];
                            $params["invoiceid"] = $gch["value"];
                            $params["returnurl"] = $gch["value"];
                            $params["cancelurl"] = $gch["value"];
                            $paymentbutton = rave_link($params, true);
                        } else {
                            if ($gat == "2checkout") {
                                require_once "modules/gateways/tco.php";
                                $gch = mysqli_fetch_assoc(dquery("select value from \n            tbl_paymentgateways where gateway='" . $selgateway . "' and setting='vendornumber'"));
                                $params["vendornumber"] = $gch["value"];
                                $paypal = mysqli_fetch_assoc(dquery("select value \n            from tbl_paymentgateways where gateway='" . $selgateway . "' and setting='demomode'"));
                                $params["demomode"] = $paypal["value"];
                                $paypal = mysqli_fetch_assoc(dquery("select value \n            from tbl_paymentgateways where gateway='" . $selgateway . "' and setting='purchaseroutine'"));
                                $params["purchaseroutine"] = $paypal["value"];
                                $params["langpaynow"] = $lng_languag["paynow"];
                                $params["tax"] = number_format($params["tax"], 2);
                                $paymentbutton = tco_link($params, true);
                            } else {
                                if ($gat == "googlecheckout") {
                                    require_once "modules/gateways/googlecheckout.php";
                                    $gch = mysqli_fetch_assoc(dquery("select value from \n            tbl_paymentgateways where gateway='" . $selgateway . "' and setting='merchantid'"));
                                    $params["merchantid"] = $gch["value"];
                                    $paypal = mysqli_fetch_assoc(dquery("select value \n            from tbl_paymentgateways where gateway='" . $selgateway . "' and setting='sandbox'"));
                                    $params["sandbox"] = $paypal["value"];
                                    $params["tax"] = number_format($params["tax"], 2);
                                    $paymentbutton = googlequickcheckout_link($params, true);
                                } else {
                                    require_once "modules/gateways/paypal.php";
                                }
                            }
                        }
                        echo "<br><br><br><br>\n        <div align='center'>Please wait while we redirect to \n        payment if not redirect within 5 sec Click here " . $paymentbutton . "</div>";
                        echo "<script> document.forms[0].submit(); </script>";
                    } else {
                        if (!$id) {
                            echo "<script> location.href='" . _url("main/payment/error") . "';</script>";
                            exit;
                        }
                        $serviceDetails = getIMEIServices("", $id, "", "", "", "", true);
                        $error = placeOrderIMEIvalidation($serviceDetails["reqredfield"], false, "", $serviceDetails);
                        if ($error) {
                            echo $error;
                            exit;
                        }
                        $taxarr = getTaxRate(1, "", "", "paypal");
                        $taxarr2 = getTaxRate(2, "", "", "paypal");
                        $taxrate = $taxarr["rate"];
                        $taxrate2 = $taxarr2["rate"];
                        if ($taxrate != "0.00" && $config["taxtype"] == "Exclusive") {
                            $TAX = $taxarr["rate"];
                        }
                        if ($taxrate2 != "0.00" && $config["taxtype"] == "Exclusive") {
                            $TAX = $taxarr2["rate"];
                        }
                        $TAX = ($serviceDetails["credit"] - $serviceDetails["discount"]) * $TAX / 100;
                        $data["service_id"] = $serviceDetails["id"];
                        $data["server"] = $serviceDetails["useasserver"];
                        $data["purchase_cost"] = $serviceDetails["purchase_cost"];
                        if (0 < $serviceDetails["purchase_cost"]) {
                            $data["profit"] = $serviceDetails["purchase_cost"] - ($serviceDetails["credit"] - $serviceDetails["discount"]);
                        }
                        $data["imei"] = $imei1 . $imei2;
                        $data["date"] = date("Y-m-d");
                        $data["time"] = time();
                        $data["user_can_c"] = 6;
                        $data["tax"] = $TAX;
                        $data["model_id"] = $model_id;
                        $data["provider_id"] = $provider_id;
                        $data["provider_c_id"] = $country;
                        $data["network_id"] = $network_id;
                        $data["mep"] = $mep;
                        $data["KBH"] = $KBH;
                        $data["PIN"] = $PIN;
                        $data["PRD"] = $PRD;
                        $data["Type"] = $Type;
                        $data["gateway"] = $gat;
                        $data["Reference"] = $Reference;
                        $data["note"] = $notes;
                        $data["comments"] = $comments;
                        if ($Locks) {
                            foreach ($Locks as $L) {
                                $T .= "," . $L;
                            }
                            $data["Locks"] = $T;
                        }
                        $data["credit"] = $serviceDetails["credit"];
                        $data["qnt"] = $qnt;
                        $data["discount"] = $serviceDetails["discount"];
                        $data["retail_shop"] = 1;
                        $data["currency_id"] = $_ClientsDetails["currency_id"];
                        $data["ip"] = $_SERVER["REMOTE_ADDR"];
                        $order = $db->insert("tbl_order_imei", $data);
                        alphanumeric($order);
                        $amount = $serviceDetails["credit"] - $serviceDetails["discount"];
                        unset($data);
                        if (!function_exists(checkCustomFields)) {
                            require_once "includes/customfield.fun.inc.php";
                        }
                        saveCustomFields($order, $customfield);
                        $order = md5($order);
                        $ste_addr = str_replace("http://", "", $config["site_address"]);
                        $ste_addr = str_replace("https://", "", $ste_addr);
                        echo "redirectto: " . $ste_addr . "/" . _url("placeholder/order" . $order . "/gat/" . $gat);
                    }
                }
            }
        }
        chkMd5sumsubpage();
    }
}

?>