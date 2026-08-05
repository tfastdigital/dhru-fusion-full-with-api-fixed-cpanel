<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function paypal2_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "PayPal 2 [DEPRECATED]"], "email" => ["Name" => "PayPal Email", "Type" => "text", "Size" => "40", "Description" => "Login Mail."], "info" => ["Name" => "Other Information", "Type" => "textarea", "Cols" => "5", "Rows" => "10"], "forceshippingadd" => ["Type" => "yesno", "Name" => "Test Mode", "Description" => "forcefully add shipping address for all products include digital delivery and add fund"], "apiusername" => ["Name" => "PayPal APi Username ", "Type" => "text", "Size" => "50", "Description" => "Required for auto validate Transaction ID and Refund process"], "apipassword" => ["Name" => "PayPal APi Password", "Type" => "text", "Size" => "50", "Description" => "Required for auto validate Transaction ID and Refund process"], "apisignature" => ["Name" => "paypal2 APi signature", "Type" => "text", "Size" => "50", "Description" => "Required for auto validate Transaction ID and Refund process"]];
    return $configarray;
}
function paypal2_link($params)
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
    $code .= "<form action=\"" . $paypallink . "\" method=\"post\">\r\n    <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\r\n    <input type=\"hidden\" name=\"business\" value=\"" . $params["email"] . "\">";
    if ($params["style"]) {
        $code .= "<input type=\"hidden\" name=\"page_style\" value=\"" . $params["style"] . "\">";
    }
    if (!$params["forceshippingadd"]) {
        $asdfadfdsa = "\r\n        <input type=\"hidden\" name=\"no_shipping\" value=\"1\">    \r\n        ";
    }
    $code .= $asdfadfdsa . "\r\n    <input type=\"hidden\" name=\"item_name\" value=\"" . $params["description"] . "\">    \r\n    <input type=\"hidden\" name=\"invoice\" value=\"" . $invoiceid . "\">\r\n    <input type=\"hidden\" name=\"quantity\" value=\"1\">\r\n    <input type=\"hidden\" name=\"amount\" value=\"" . $invoicetotal . "\">\r\n    <input type=\"hidden\" name=\"tax\" value=\"0.00\">\r\n    <input type=\"hidden\" name=\"no_note\" value=\"1\">\r\n    <input type=\"hidden\" name=\"first_name\" value=\"" . $params["clientdetails"]["firstname"] . "\">\r\n    <input type=\"hidden\" name=\"last_name\" value=\"" . $params["clientdetails"]["lastname"] . "\">\r\n    <input type=\"hidden\" name=\"address1\" value=\"" . $params["clientdetails"]["address1"] . "\">\r\n    <input type=\"hidden\" name=\"city\" value=\"" . $params["clientdetails"]["city"] . "\">\r\n    <input type=\"hidden\" name=\"state\" value=\"" . $params["clientdetails"]["state"] . "\">\r\n    <input type=\"hidden\" name=\"zip\" value=\"" . $params["clientdetails"]["postcode"] . "\">\r\n    <input type=\"hidden\" name=\"country\" value=\"" . $params["clientdetails"]["country"] . "\">\r\n    <input type=\"hidden\" name=\"H_PhoneNumber\" value=\"" . $params["clientdetails"]["phonenumber"] . "\">\r\n    <input TYPE=\"hidden\" name=\"charset\" value=\"" . $config["charset"] . "\">\r\n    <input type=\"hidden\" name=\"currency_code\" value=\"" . $params["currency"] . "\">\r\n    <input type=\"hidden\" name=\"custom\" value=\"" . $params["invoiceid"] . "\">\r\n    <input type=\"hidden\" name=\"return\" value=\"" . $params["returnurl"] . "?paymentsuccess=true\">\r\n    <input type=\"hidden\" name=\"cancel_return\" value=\"" . $params["returnurl"] . "?paymentfailed=true\">\r\n    <input type=\"hidden\" name=\"notify_url\" value=\"" . $params["systemurl"] . "/modules/gateways/callback/paypal2.php\">\r\n    <input type=\"hidden\" name=\"bn\" value=\"DHRUFUSION\">\r\n    <input type=\"hidden\" name=\"rm\" value=\"2\">\r\n    <input type=\"submit\" class=\"btn btn-success btn-primary paymentbtn\" value=\"" . $lng_languag["invoicespaynow"] . "\" alt=\"" . $lng_languag["invoicespaynow"] . "\">\r\n    </form>";
    return $code;
}
function paypal2_quick($params)
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
    $code .= "<form action=\"" . $paypallink . "\" method=\"post\">\r\n    <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\r\n    <input type=\"hidden\" name=\"business\" value=\"" . $params["email"] . "\">";
    $code .= "<input type=\"hidden\" name=\"item_name\" value=\"" . $params["description"] . " [OID: #" . $params["id"] . "]\">\r\n    <input type=\"hidden\" name=\"amount\" value=\"" . $invoicetotal . "\">\r\n    <input type=\"hidden\" name=\"tax\" value=\"" . round($params["tax"], 2) . "\">\r\n    <input type=\"hidden\" name=\"no_note\" value=\"1\">\r\n    <input type=\"hidden\" name=\"no_shipping\" value=\"1\">\r\n    <input type=\"hidden\" name=\"first_name\" value=\"" . $params["clientdetails"]["firstname"] . "\">\r\n    <input type=\"hidden\" name=\"last_name\" value=\"" . $params["clientdetails"]["lastname"] . "\">\r\n    <input type=\"hidden\" name=\"address1\" value=\"" . $params["clientdetails"]["address1"] . "\">\r\n    <input type=\"hidden\" name=\"city\" value=\"" . $params["clientdetails"]["city"] . "\">\r\n    <input type=\"hidden\" name=\"state\" value=\"" . $params["clientdetails"]["state"] . "\">\r\n    <input type=\"hidden\" name=\"zip\" value=\"" . $params["clientdetails"]["postcode"] . "\">\r\n    <input type=\"hidden\" name=\"country\" value=\"" . $params["clientdetails"]["country"] . "\">\r\n    <input TYPE=\"hidden\" name=\"charset\" value=\"" . $config["charset"] . "\">\r\n    <input type=\"hidden\" name=\"currency_code\" value=\"" . $params["currency"] . "\">\r\n    <input type=\"hidden\" name=\"custom\" value=\"" . $orderid . "\">\r\n    <input type=\"hidden\" name=\"return\" value=\"" . $params["returnurl"] . "?paymentsuccess=true\">\r\n    <input type=\"hidden\" name=\"cancel_return\" value=\"" . $params["returnurl"] . "?paymentfailed=true\">\r\n    <input type=\"hidden\" name=\"notify_url\" value=\"" . $params["systemurl"] . "/modules/gateways/callback/quickcheckout.php\">\r\n    <input type=\"hidden\" name=\"bn\" value=\"DHRUFUSION\">\r\n    <input type=\"hidden\" name=\"rm\" value=\"2\">\r\n    <input type=\"submit\" class=\"btn btn-success\" value=\"" . $lng_languag["invoicespaynow"] . "\" alt=\"" . $lng_languag["invoicespaynow"] . "\">\r\n    </form>";
    return $code;
}

?>