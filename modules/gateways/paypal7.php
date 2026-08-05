<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function paypal7_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "PayPal 7 [DEPRECATED]"], "email" => ["Name" => "PayPal Email", "Type" => "text", "Size" => "40", "Description" => "Login Mail."], "info" => ["Name" => "Other Information", "Type" => "textarea", "Cols" => "5", "Rows" => "10"], "forceshippingadd" => ["Type" => "yesno", "Name" => "Test Mode", "Description" => "forcefully add shipping address for all products include digital delivery and add fund"], "apiusername" => ["Name" => "PayPal APi Username ", "Type" => "text", "Size" => "50", "Description" => "Required for auto validate Transaction ID and Refund process"], "apipassword" => ["Name" => "PayPal APi Password", "Type" => "text", "Size" => "50", "Description" => "Required for auto validate Transaction ID and Refund process"], "apisignature" => ["Name" => "paypal APi signature", "Type" => "text", "Size" => "50", "Description" => "Required for auto validate Transaction ID and Refund process"]];
    return $configarray;
}
function paypal7_link($params)
{
    global $config;
    global $lng_languag;
    $code = "";
    $invoiceid = $params["invoiceid"];
    $invoicetotal = $params["amount"];
    $invoicetotal = formatCurrency2($invoicetotal);
    $paypallink = "https://www.paypal.com/cgi-bin/webscr";
    if ($params["SendBox"]) {
        $paypallink = "https://www.sandbox.paypal.com/cgi-bin/webscr";
    }
    $code .= "<form action=\"" . $paypallink . "\" method=\"post\">\n    <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\n    <input type=\"hidden\" name=\"business\" value=\"" . $params["email"] . "\">";
    if ($params["style"]) {
        $code .= "<input type=\"hidden\" name=\"page_style\" value=\"" . $params["style"] . "\">";
    }
    if (!$params["forceshippingadd"]) {
        $asdfadfdsa = "\n        <input type=\"hidden\" name=\"no_shipping\" value=\"1\">    \n        ";
    }
    $code .= $asdfadfdsa . "\n    <input type=\"hidden\" name=\"item_name\" value=\"" . $params["description"] . "\">    \n    <input type=\"hidden\" name=\"invoice\" value=\"" . $invoiceid . "\">\n    <input type=\"hidden\" name=\"quantity\" value=\"1\">\n    <input type=\"hidden\" name=\"amount\" value=\"" . $invoicetotal . "\">\n    <input type=\"hidden\" name=\"tax\" value=\"0.00\">\n    <input type=\"hidden\" name=\"no_note\" value=\"1\">\n    <input type=\"hidden\" name=\"first_name\" value=\"" . $params["clientdetails"]["firstname"] . "\">\n    <input type=\"hidden\" name=\"last_name\" value=\"" . $params["clientdetails"]["lastname"] . "\">\n    <input type=\"hidden\" name=\"address1\" value=\"" . $params["clientdetails"]["address1"] . "\">\n    <input type=\"hidden\" name=\"city\" value=\"" . $params["clientdetails"]["city"] . "\">\n    <input type=\"hidden\" name=\"state\" value=\"" . $params["clientdetails"]["state"] . "\">\n    <input type=\"hidden\" name=\"zip\" value=\"" . $params["clientdetails"]["postcode"] . "\">\n    <input type=\"hidden\" name=\"country\" value=\"" . $params["clientdetails"]["country"] . "\">\n    <input type=\"hidden\" name=\"H_PhoneNumber\" value=\"" . $params["clientdetails"]["phonenumber"] . "\">\n    <input TYPE=\"hidden\" name=\"charset\" value=\"" . $config["charset"] . "\">\n    <input type=\"hidden\" name=\"currency_code\" value=\"" . $params["currency"] . "\">\n    <input type=\"hidden\" name=\"custom\" value=\"" . $params["invoiceid"] . "\">\n    <input type=\"hidden\" name=\"return\" value=\"" . $params["returnurl"] . "?paymentsuccess=true\">\n    <input type=\"hidden\" name=\"cancel_return\" value=\"" . $params["returnurl"] . "?paymentfailed=true\">\n    <input type=\"hidden\" name=\"notify_url\" value=\"" . $params["systemurl"] . "/modules/gateways/callback/paypal2.php?g=paypal7\">\n    <input type=\"hidden\" name=\"bn\" value=\"DHRUFUSION\">\n    <input type=\"hidden\" name=\"rm\" value=\"2\">\n    <input type=\"submit\" class=\"btn btn-success btn-primary paymentbtn\" value=\"" . $lng_languag["invoicespaynow"] . "\" alt=\"" . $lng_languag["invoicespaynow"] . "\">\n    </form>";
    return $code;
}
function paypal7_quick($params)
{
    global $config;
    global $lng_languag;
    $code = "";
    $orderid = $params["orderid"];
    $invoicetotal = $params["amount"];
    $invoicetotal = formatCurrency2($invoicetotal);
    $paypallink = "https://www.paypal.com/cgi-bin/webscr";
    if ($params["SendBox"]) {
        $paypallink = "https://www.sandbox.paypal.com/cgi-bin/webscr";
    }
    $code .= "<form action=\"" . $paypallink . "\" method=\"post\">\n    <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\n    <input type=\"hidden\" name=\"business\" value=\"" . $params["email"] . "\">";
    $code .= "<input type=\"hidden\" name=\"item_name\" value=\"" . $params["description"] . " [OID: #" . $params["id"] . "]\">\n    <input type=\"hidden\" name=\"amount\" value=\"" . $invoicetotal . "\">\n    <input type=\"hidden\" name=\"tax\" value=\"" . round($params["tax"], 2) . "\">\n    <input type=\"hidden\" name=\"no_note\" value=\"1\">\n    <input type=\"hidden\" name=\"no_shipping\" value=\"1\">\n    <input type=\"hidden\" name=\"first_name\" value=\"" . $params["clientdetails"]["firstname"] . "\">\n    <input type=\"hidden\" name=\"last_name\" value=\"" . $params["clientdetails"]["lastname"] . "\">\n    <input type=\"hidden\" name=\"address1\" value=\"" . $params["clientdetails"]["address1"] . "\">\n    <input type=\"hidden\" name=\"city\" value=\"" . $params["clientdetails"]["city"] . "\">\n    <input type=\"hidden\" name=\"state\" value=\"" . $params["clientdetails"]["state"] . "\">\n    <input type=\"hidden\" name=\"zip\" value=\"" . $params["clientdetails"]["postcode"] . "\">\n    <input type=\"hidden\" name=\"country\" value=\"" . $params["clientdetails"]["country"] . "\">\n    <input TYPE=\"hidden\" name=\"charset\" value=\"" . $config["charset"] . "\">\n    <input type=\"hidden\" name=\"currency_code\" value=\"" . $params["currency"] . "\">\n    <input type=\"hidden\" name=\"custom\" value=\"" . $orderid . "\">\n    <input type=\"hidden\" name=\"return\" value=\"" . $params["returnurl"] . "?paymentsuccess=true\">\n    <input type=\"hidden\" name=\"cancel_return\" value=\"" . $params["returnurl"] . "?paymentfailed=true\">\n    <input type=\"hidden\" name=\"notify_url\" value=\"" . $params["systemurl"] . "/modules/gateways/callback/quickcheckout.php\">\n    <input type=\"hidden\" name=\"bn\" value=\"DHRUFUSION\">\n    <input type=\"hidden\" name=\"rm\" value=\"2\">\n    <input type=\"submit\" class=\"btn btn-success\" value=\"" . $lng_languag["invoicespaynow"] . "\" alt=\"" . $lng_languag["invoicespaynow"] . "\">\n    </form>";
    return $code;
}

?>