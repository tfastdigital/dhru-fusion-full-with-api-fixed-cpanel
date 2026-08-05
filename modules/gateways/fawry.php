<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function fawry_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "Fawry Pay"], "merchantcode" => ["Name" => "Merchant Code", "Type" => "text", "Size" => "50"], "securekey" => ["Name" => "Secure key", "Type" => "text", "Size" => "50"], "sandbox" => ["Name" => "Sandbox/Testing", "Type" => "yesno"]];
    return $configarray;
}
function fawry_link($params)
{
    global $config;
    $invoiceid = $params["invoiceid"];
    if (isset($_SESSION["fawry_" . $invoiceid])) {
        $ChangeResp["merchantRefNumber"] = $invoiceid;
        $ChangeResp["fawryRefNumber"] = $_SESSION["fawry_" . $invoiceid];
        $ChangeResp["paymentMethod"] = "PAYATFAWRY";
        $ChangeResp = json_encode($ChangeResp);
        $CODE .= "<form method='post' action='" . _url("placeholder/chargeResponse/" . $ChangeResp, true) . "'>\n\n<input type='submit' name='checkpayment' value='Check Payment' />\n<br />Payment Reference No : " . $_SESSION["fawry_" . $invoiceid] . "\n</form>";
    } else {
        $INV = mysqli_fetch_assoc(dquery("select total,(select description from tbl_invoiceitems\n where invoiceid=tbl_invoices.id limit 1) as item from tbl_invoices where id='" . $invoiceid . "'"));
        $MERCHANTCODE = $params["merchantcode"];
        $SECUREKEY = $params["securekey"];
        $AMOUNT = $INV["total"];
        if ($_SESSION["currency"]["code"] != "EGP") {
            $AMOUNT = round(convertCurrency($AMOUNT, $_SESSION["currency"]["code"], "EGP", "", "code"), 2);
        }
        $PAYMETNMETHOD = "PAYATFAWRY";
        $AMOUNT = number_format((double) $AMOUNT, 2, ".", "");
        $SIGNATURE = hash("sha256", $MERCHANTCODE . $invoiceid . $_SESSION["uid"] . $PAYMETNMETHOD . $AMOUNT . $SECUREKEY);
        $SiteAddress = $config["site_address"];
        if ($config["config_ssl_allow"]) {
            $SiteAddress = $config["config_ssl_allow"];
        }
        $CODE = "";
        if ($params["sandbox"]) {
            $CODE .= "<script src=\"https://atfawry.fawrystaging.com/ECommercePlugin/scripts/FawryPay.js\"></script>";
        } else {
            $CODE .= "<script src=\"https://www.atfawry.com/ECommercePlugin/scripts/FawryPay.js\"></script>";
        }
        $CODE .= "<script>\n        var changeRequest={\n            \"language\": \"en-us\",\n            \"merchantCode\": \"" . $MERCHANTCODE . "\",\n            \"merchantRefNumber\": \"" . $invoiceid . "\",\n            \"customer\": {\n                \"name\": \"" . $_SESSION["fullname"] . "\"\n            },\n            \"order\": {\n                \"description\": \"" . $INV["item"] . "\",\n                \"expiry\": \"2\",\n                \"orderItems\": [\n                    {\n                        \"productSKU\": \"12222\",\n                        \"description\": \"" . $INV["item"] . "\",\n                        \"price\": \"" . $AMOUNT . "\",\n                        \"quantity\": \"1\"\n                    }\n                ]\n            },\n            \"signature\": \"" . $SIGNATURE . "\"\n        };\n\n        var failerPageUrl = \"" . _url("viewinvoice/id/" . md5($invoiceid), true) . "\";\n        var successPageUrl = \"" . _url("placeholder/", true) . "\";\n    </script>";
        $CODE .= "<button type=\"button\" class=\"btn btn-primary paymentbtn\" onclick=\"FawryPay.checkout(changeRequest,successPageUrl, failerPageUrl)\" ;\n           value=\"Pay Now\" >Pay Now</button>";
    }
    return $CODE;
}

?>