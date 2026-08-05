<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function paypalexpress_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "PayPal Express Checkout"], "clientid" => ["Name" => "Client ID", "Type" => "text", "Size" => "50", "Description" => ""], "secretkey" => ["Name" => "Secret Key", "Type" => "text", "Size" => "30"], "merchant_id" => ["Name" => "PayPal Merchant ID", "Type" => "text", "Size" => "30", "Description" => "(Required for Risk management only) How to find? https://www.paypal.com/in/smarthelp/article/FAQ3850"], "riskmanagement" => ["Type" => "yesno", "Name" => "Pre-transaction risk management evaluation", "Description" => " Make sure your merchant account has special permission for this"], "creditcard" => ["Name" => "Credit Card", "Type" => "yesno"], "testmode" => ["Type" => "yesno", "Name" => "Test Mode", "Description" => " "]];
    return $configarray;
}
function paypalexpress_link($params)
{
    global $config;
    global $getorderjson;
    global $db;
    $config["companyname"] = preg_replace("/[^\\da-zA-Z0-9.\\-_ ]/i", "", $config["companyname"]);
    $tmpid = "INV_" . $params["invoiceid"];
    $invoiceid = $params["invoiceid"];
    $minvoiceid = md5($invoiceid);
    $jsonlink = "./viewinvoice/a/1/id/" . $minvoiceid;
    if (!$params["invoiceid"]) {
        if (isset($_SESSION["CART"])) {
            $sessionid = session_id();
            if (!mysqli_num_rows(dquery("select id from tbl_tmp where uniqueid='" . $sessionid . "'"))) {
                $TMP["data"] = json_encode($_SESSION["CART"]);
                $TMP["uniqueid"] = $sessionid;
                $tmpid = $db->insert("tbl_tmp", $TMP);
            } else {
                $T = mysqli_fetch_assoc(dquery("select id from tbl_tmp where uniqueid='" . $sessionid . "'"));
                $tmpid = $T["id"];
                $TMP["data"] = json_encode($_SESSION["CART"]);
                $db->update("tbl_tmp", $TMP, "uniqueid='" . $sessionid . "'");
            }
        } else {
            $tmpid = $params["CART"]["PAYMENTREQUEST_1_CUSTOM"];
        }
        $params["invoiceid"] = $tmpid;
        $jsonlink = "./cart/view/a";
    }
    $_client_id = $params["clientid"];
    $params["totalamount"] = $params["amount"];
    $type = "AUTHORIZE";
    $_ORDER = [];
    $_ORDER["intent"] = $type;
    $_application_context["brand_name"] = $config["companyname"];
    $_application_context["locale"] = "en-US";
    if (!$params["shippingrequired"]) {
        $_application_context["shipping_preference"] = "NO_SHIPPING";
    }
    $_application_context["user_action"] = "PAY_NOW";
    $_application_context["return_url"] = $params["returnurl"] . "?paymentsuccess=true";
    $_application_context["cancel_url"] = $params["returnurl"] . "?paymentfailed=true";
    $_application_context["payment_method"]["payer_selected"] = "PAYPAL";
    $_application_context["payment_method"]["payee_preferred"] = "IMMEDIATE_PAYMENT_REQUIRED";
    $_ORDER["application_context"] = $_application_context;
    $_ORDER["payer"]["name"]["given_name"] = $params["clientdetails"]["firstname"];
    $_ORDER["payer"]["name"]["surname"] = $params["clientdetails"]["lastname"];
    $_ORDER["payer"]["email_address"] = $params["clientdetails"]["email"];
    if ($params["clientdetails"]["verified"] && $params["clientdetails"]["phonenumber"]) {
        $_ORDER["payer"]["phone"]["phone_number"]["national_number"] = $params["clientdetails"]["phonenumber"];
    }
    $ItemTotal = 0;
    if ($params["currency"] != $params["basecurrency"]) {
        $_purchase_units = [];
        $_items = [];
        $_items["name"] = "INV #" . $params["invoiceid"];
        $_items["quantity"] = 1;
        $_items["unit_amount"]["currency_code"] = $params["currency"];
        $_items["unit_amount"]["value"] = number_format($params["totalamount"], 2, ".", "");
        $_purchase_units["items"][] = $_items;
        $_purchase_units["amount"]["currency_code"] = $params["currency"];
        $_purchase_units["amount"]["value"] = number_format($params["totalamount"], 2, ".", "");
        $_purchase_units["amount"]["breakdown"]["item_total"]["currency_code"] = $params["currency"];
        $_purchase_units["amount"]["breakdown"]["item_total"]["value"] = number_format($params["totalamount"], 2, ".", "");
    } else {
        $_purchase_units = [];
        foreach ($params["items"] as $k => $v) {
            $params["itemqnt"][$k] = $params["itemqnt"][$k] ? $params["itemqnt"][$k] : 1;
            $_items = [];
            $_items["name"] = $v;
            $_items["description"] = $v;
            $_items["quantity"] = $params["itemqnt"][$k];
            $_items["unit_amount"]["currency_code"] = $params["currency"];
            $_items["unit_amount"]["value"] = number_format($params["itemamt"][$k], 2, ".", "");
            $ItemTotal += $params["itemamt"][$k] * $params["itemqnt"][$k];
            $_items["category"] = $params["itemtype"][$k];
            $_purchase_units["items"][] = $_items;
        }
        $Taxamount = $params["totalamount"] - $ItemTotal;
        $_purchase_units["amount"]["currency_code"] = $params["currency"];
        $_purchase_units["amount"]["value"] = number_format($params["totalamount"], 2, ".", "");
        $_purchase_units["amount"]["breakdown"]["item_total"]["currency_code"] = $params["currency"];
        $_purchase_units["amount"]["breakdown"]["item_total"]["value"] = number_format($ItemTotal, 2, ".", "");
        if ($Taxamount) {
            $_purchase_units["amount"]["breakdown"]["tax_total"]["currency_code"] = $params["currency"];
            $_purchase_units["amount"]["breakdown"]["tax_total"]["value"] = number_format($Taxamount, 2, ".", "");
        }
    }
    $_purchase_units["custom_id"] = $tmpid;
    $_purchase_units["invoice_id"] = $params["invoiceid"] . uuid();
    $_purchase_units["soft_descriptor"] = $config["companyname"];
    $_ORDER["purchase_units"][0] = $_purchase_units;
    if ($type === "authorize") {
        $_alert = "Payment authorized waiting for confirmation";
    } else {
        $_alert = "Payment Success";
    }
    if ($params["creditcard"]) {
        $code = "<script\r\n        src=\"https://www.paypal.com/sdk/js?client-id=" . $_client_id . "&intent=" . strtolower($type) . "\"></script>";
    } else {
        $code = "<script\r\n        src=\"https://www.paypal.com/sdk/js?client-id=" . $_client_id . "&disable-funding=card&intent=" . strtolower($type) . "\"></script>";
    }
    if ($getorderjson) {
        ob_start();
        $_client_id = $params["clientid"];
        $_secret = $params["secretkey"];
        if ($params["testmode"]) {
            $_url123 = "https://api.sandbox.paypal.com/v2/checkout/orders";
        } else {
            $_url123 = "https://api.paypal.com/v2/checkout/orders";
        }
        $_token = base64_encode($_client_id . ":" . $_secret);
        $curl = curl_init();
        curl_setopt_array($curl, [CURLOPT_URL => $_url123, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => json_encode($_ORDER), CURLOPT_HTTPHEADER => ["Authorization: Basic " . $_token, "Content-Type: application/json", "PayPal-Request-Id: " . uuid(), "PayPal-Client-Metadata-Id: " . md5($params["invoiceid"])]]);
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
        ob_end_flush();
        if ($params["riskmanagement"]) {
            $POST = [];
            $OB["key"] = "sender_account_id";
            $OB["value"] = $params["clientdetails"]["id"];
            $POST["additional_data"][] = $OB;
            $OB["key"] = "sender_first_name";
            $OB["value"] = $params["clientdetails"]["firstname"];
            $POST["additional_data"][] = $OB;
            $OB["key"] = "sender_last_name";
            $OB["value"] = $params["clientdetails"]["lastname"];
            $POST["additional_data"][] = $OB;
            $OB["key"] = "sender_email";
            $OB["value"] = $params["clientdetails"]["email"];
            $POST["additional_data"][] = $OB;
            if ($params["clientdetails"]["verified"] && $params["clientdetails"]["phonenumber"]) {
                $OB["key"] = "sender_phone";
                $OB["value"] = $params["clientdetails"]["phonenumber"];
                $POST["additional_data"][] = $OB;
            }
            $OB["key"] = "sender_create_date";
            $OB["value"] = date(DATE_ISO8601, strtotime(date("Y-m-d h:i:s", $params["clientdetails"]["signupdate"])));
            $POST["additional_data"][] = $OB;
            $OB["key"] = "sender_country_code";
            $OB["value"] = $params["clientdetails"]["country"];
            $POST["additional_data"][] = $OB;
            $trackingid = md5($params["invoiceid"]);
            $Result = paypalexpress_callCUrl(1, "v1/risk/transaction-contexts/" . $params["merchant_id"] . "/" . $trackingid, "PUT", $params, $POST);
        }
        exit;
    }
    $code .= "<div id=\"paypal-button-container\"></div>\r\n<script>\r\n\r\n    paypal.Buttons({\r\n        createOrder: function(data, actions) {\r\n            return fetch(\"" . $jsonlink . "/getorderjson/true\", {\r\n                    method: \"get\"\r\n                }).then(function(res) {\r\n                    return res.json();\r\n                }).then(function(orderData) {\r\n                    return orderData.id;\r\n                });\r\n        },\r\n        onApprove: function(data, actions) {\r\n            \$(\"#payment_loader\").show();\r\n            //console.log(\"onApprove\",data,actions);\r\n            return actions.order." . strtolower($type) . "().then(function(details) {\r\n            //console.log(\"actions.order." . $type . "\",details);\r\n                return fetch('./modules/gateways/callback/paypalexpress.php', {\r\n                    method: 'post',\r\n                    headers: {\r\n                        'content-type': 'application/json'\r\n                    },\r\n                    body: JSON.stringify({\r\n                        details\r\n                    })\r\n                }).then(function(res) {\r\n                    console.log('res ',res);\r\n                    return res.json();\r\n                }).then(function(details) {\r\n                    console.log('success ',details);\r\n                    if(details.status == 'success'){\r\n                \r\n                       \r\n                         var invoiceid=details.invoiceid;\r\n                        \r\n                         location.href=\"viewinvoice/a/1/id/\"+invoiceid+\"/\";\r\n                         \r\n                }else{\r\n                    return actions.restart();\r\n                        alert(\"Payment Failed \");\r\n                }\r\n                \r\n                });\r\n            });\r\n        },\r\n        onCancel: function (data) {\r\n            console.log('onCancel',data);\r\n            // Show a cancel page, or return to cart\r\n        },\r\n        onError: function (err) {\r\n            console.log('err',err);\r\n            // Show an error page here, when an error occurs\r\n        }\r\n    }).render('#paypal-button-container');\r\n    \r\n    \r\n\r\n\r\n</script>";
    if ($params["clientdetails"]["paypalaccount"]) {
        $PaypalAc = json_decode($params["clientdetails"]["paypalaccount"]);
        $code .= " <div style='display:block;' class='alert alert-info'>Your account is verified with [" . implode(",", $PaypalAc) . "]  PayPal email(s). Please pay using this account to avoid re-verifaction process.</div>";
    }
    return $code;
}
function paypalexpress_viewcart($params)
{
    global $db;
    if (isset($_SESSION["CART"])) {
        $sessionid = session_id();
        if (!mysqli_num_rows(dquery("select id from tbl_tmp where uniqueid='" . $sessionid . "'"))) {
            $TMP["data"] = json_encode($_SESSION["CART"]);
            $TMP["uniqueid"] = $sessionid;
            $tmpid = $db->insert("tbl_tmp", $TMP);
        } else {
            $T = mysqli_fetch_assoc(dquery("select id from tbl_tmp where uniqueid='" . $sessionid . "'"));
            $tmpid = $T["id"];
            $TMP["data"] = json_encode($_SESSION["CART"]);
            $db->update("tbl_tmp", $TMP, "uniqueid='" . $sessionid . "'");
        }
    } else {
        $tmpid = $params["CART"]["PAYMENTREQUEST_1_CUSTOM"];
    }
    $_client_id = $params["clientid"];
    if ($params["creditcard"]) {
        $code = "<script\r\n        src=\"https://www.paypal.com/sdk/js?client-id=" . $_client_id . "\"></script>";
    } else {
        $code = "<script\r\n        src=\"https://www.paypal.com/sdk/js?client-id=" . $_client_id . "&disable-funding=card\"></script>";
    }
    $code .= "<div id=\"paypal-button-container\"></div>\r\n<script>\r\n    paypal.Buttons({\r\n        createOrder: function(data, actions) {\r\n            return actions.order.create({\r\n         \r\n                purchase_units: [{\r\n                    custom_id: '" . $tmpid . "',\r\n                    amount: {\r\n                        value: '" . number_format($params["totalamount"], 2, ".", "") . "',\r\n                        currency_code:  '" . $params["currency"] . "',\r\n                        breakdown: {\r\n                            item_total: {\r\n                                currency_code:  '" . $params["currency"] . "',\r\n                                value: " . $params["totalamount"] . "\r\n                            }\r\n                         }\r\n                         \r\n                      },\r\n                      items: [\r\n                          " . $params["js"] . "\r\n                      ]\r\n                }]\r\n            });\r\n        },\r\n        onApprove: function(data, actions) {\r\n            \r\n            return actions.order.capture().then(function(details) {\r\n                    \$(\"#payment_loader\").show();\r\n                return fetch('./modules/gateways/callback/paypalexpress.php', {\r\n                    method: 'post',\r\n                    headers: {\r\n                        'content-type': 'application/json'\r\n                    },\r\n                    body: JSON.stringify({\r\n                        details\r\n                    })\r\n                }).then(function(res) {\r\n                     \$(\"#payment_loader\").hide();\r\n                    return res.json();\r\n                }).then(function(details) {\r\n                       \$(\"#payment_loader\").hide(); \r\n                    // Verification fails .\r\n                    //console.log('Verification ',details);\r\n                    if(details.status == 'success'){\r\n                       //  alert(\"Payment Success \");\r\n                    var invoiceid=details.invoiceid;\r\n                         location.href=\"cart/ordersucceess/a/invoice/\"+invoiceid;\r\n                    }else{\r\n                        return actions.restart();\r\n                        //alert(\"Payment Failed \");\r\n                    }\r\n                    //if want restart.   return actions.restart();\r\n                });\r\n            });\r\n        },\r\n        onCancel: function (data) {\r\n      \$(\"#payment_loader\").hide();\r\n            //console.log('onCancel',data);\r\n            // Show a cancel page, or return to cart\r\n        },\r\n        onError: function (err) {\r\n      \$(\"#payment_loader\").hide();\r\n            //console.log('err',err);\r\n            // Show an error page here, when an error occurs\r\n        }\r\n    }).render('#paypal-button-container');\r\n</script>";
    return $code;
}
function paypalexpress_checkout($params)
{
    include_once ROOTDIR . "/includes/gateway.fun.php";
    include_once ROOTDIR . "/includes/invoice.fun.php";
    $postfields = [];
    $postfields["TOKEN"] = $_SESSION["paypalexpress"]["token"];
    $postfields["PAYERID"] = $_SESSION["paypalexpress"]["payerid"];
    $postfields["PAYMENTREQUEST_0_PAYMENTACTION"] = "SALE";
    $postfields["PAYMENTREQUEST_0_AMT"] = $params["amount"];
    $postfields["PAYMENTREQUEST_0_SHIPPINGAMT"] = 0;
    $postfields["PAYMENTREQUEST_0_HANDLINGAMT"] = 0;
    $postfields["PAYMENTREQUEST_0_SHIPDISCAMT"] = 0;
    $postfields["PAYMENTREQUEST_0_INSURANCEAMT"] = 0;
    $postfields["PAYMENTREQUEST_0_CURRENCYCODE"] = $params["currency"];
    $postfields["IPADDRESS"] = $_SERVER["SERVER_NAME"];
    foreach ($params["CART"] as $k => $v) {
        $postfields[$k] = $v;
    }
    $results = paypalexpress_api($params, "DoExpressCheckoutPayment", $postfields);
    logTransaction("paypalexpress", $results, "In Paypal Express");
    $ack = strtoupper(trim($results["ACK"]));
    if ($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING") {
        $transactionId = $results["PAYMENTINFO_0_TRANSACTIONID"];
        $transactionType = $results["PAYMENTINFO_0_TRANSACTIONTYPE"];
        $paymentType = $results["PAYMENTINFO_0_PAYMENTTYPE"];
        $orderTime = $results["PAYMENTINFO_0_ORDERTIME"];
        $amt = $results["PAYMENTINFO_0_AMT"];
        $currencyCode = $results["PAYMENTINFO_0_CURRENCYCODE"];
        $feeAmt = $results["PAYMENTINFO_0_FEEAMT"];
        $settleAmt = $results["PAYMENTINFO_0_SETTLEAMT"];
        $taxAmt = $results["PAYMENTINFO_0_TAXAMT"];
        $exchangeRate = $results["PAYMENTINFO_0_EXCHANGERATE"];
        $paymentStatus = $results["PAYMENTINFO_0_PAYMENTSTATUS"];
        if ($paymentStatus == "Completed") {
            addPayment($results["Invoice ID"], $transactionId, $results["Amount"], $feeAmt, "paypalexpress", true);
            return ["status" => "success", "transid" => $transactionId, "fee" => $feeAmt, "rawdata" => $results];
        }
        if ($paymentStatus == "Pending") {
            return ["status" => "payment pending", "rawdata" => implode(",", $results)];
        }
        return ["status" => "invalid status", "rawdata" => implode(",", $results)];
    }
    return ["status" => "error", "rawdata" => implode(",", $results)];
}
function paypalexpress_callCUrl($url = 0, $action, $method = "POST", $gatewayPara, $postData = [], $headers = [])
{
    if ($gatewayPara["testmode"]) {
        $_url[0] = "https://api.sandbox.paypal.com/" . $action;
        $_url[1] = "https://api-m.sandbox.paypal.com/" . $action;
    } else {
        $_url[0] = "https://api.paypal.com/" . $action;
        $_url[1] = "https://api-m.paypal.com/" . $action;
    }
    $_client_id = $gatewayPara["clientid"];
    $_secret = $gatewayPara["secretkey"];
    $_token = base64_encode($_client_id . ":" . $_secret);
    $_headers = ["Authorization: Basic " . $_token, "Content-Type: application/json"];
    if (count($headers)) {
        $_headers = array_merge($_headers, $headers);
    }
    $curl = curl_init();
    curl_setopt_array($curl, [CURLOPT_URL => $_url[$url], CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => $method, CURLOPT_POSTFIELDS => json_encode($postData), CURLOPT_HTTPHEADER => $_headers]);
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    return $data;
}
function paypalexpress_api($params, $methodName, $postfields)
{
    logTransaction("paypalexpress", $postfields, "in Paypal API");
    $postfields["METHOD"] = $methodName;
    $postfields["VERSION"] = "64";
    $postfields["PWD"] = trim($params["apipassword"]);
    $postfields["USER"] = trim($params["apiusername"]);
    $postfields["SIGNATURE"] = trim($params["apisignature"]);
    $postfields["BUTTONSOURCE"] = "DHRUFUSION_EXPRESSCHECKOUT";
    $postfields["L_PAYMENTREQUEST_0_AMT0"] = $postfields["L_PAYMENTREQUEST_0_AMT0"] - $postfields["PAYMENTREQUEST_0_TAXAMT"];
    $nvpreq = "";
    foreach ($postfields as $k => $v) {
        $nvpreq .= $k . "=" . urlencode($v) . "&";
    }
    $ch = curl_init();
    if ($params["testmode"]) {
        curl_setopt($ch, CURLOPT_URL, "https://api-3t.sandbox.paypal.com/nvp");
    } else {
        curl_setopt($ch, CURLOPT_URL, "https://api-3t.paypal.com/nvp");
    }
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
    }
    logTransaction("paypalexpress", json_encode($response), "Result Paypal API");
    curl_close($ch);
    return paypalexpress_deformatNVP($response);
}
function paypalexpress_deformatNVP($nvpstr)
{
    $intial = 0;
    $nvpArray = [];
    parse_str($nvpstr, $nvpArray);
    return $nvpArray;
}

?>