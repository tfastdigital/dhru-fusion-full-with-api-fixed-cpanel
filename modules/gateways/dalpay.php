<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") or exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function dalpay_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "DalPay"], "mer_id" => ["Name" => "Merchant Number", "Type" => "text", "Size" => "6", "Description" => "6 digit merchant number"], "pageid" => ["Name" => "Page Id", "Type" => "text", "Size" => "6", "Description" => "The order page sub account\n                        within the merchant account\n                        specified by mer_id. Each\n                        selling URL or currency should\n                        have its own order page.\n                "], "info" => ["Name" => "Other Information", "Type" => "textarea", "Cols" => "5", "Rows" => "10"]];
    return $configarray;
}
function dalpay_link($params)
{
    global $config;
    global $lng_languag;
    $code = "";
    $invoiceid = $params["invoiceid"];
    $invoicetotal = $params["amount"];
    $invoicetotal = formatCurrency2($invoicetotal);
    $paypallink = "https://secure.dalpay.is/cgi-bin/order2/processorder1.pl?mer_id=" . $params["mer_id"] . "&pageid=" . $params["pageid"] . "&next_phase=paydata&pay_type=&cust_name=" . urlencode($params["clientdetails"]["firstname"]) . "&cust_address1=" . urlencode($params["clientdetails"]["address1"]) . "&cust_city=" . urlencode($params["clientdetails"]["city"]) . "&cust_state=" . urlencode($params["clientdetails"]["state"]) . "&cust_zip=" . urlencode($params["clientdetails"]["postcode"]) . "&cust_country_code=" . urlencode($params["clientdetails"]["country"]) . "&cust_email=" . urlencode($params["clientdetails"]["email"]) . "&cust_phone=" . urlencode($params["clientdetails"]["phonenumber"]) . "&num_items=1&item1_desc=" . urlencode(trim(str_replace("#", "", $params["description"]))) . "&item1_price=" . $invoicetotal . "&item1_qty=1&valuta_code=" . $params["currency"];
    $code .= "\n    <input type=\"button\" onclick=\"window.location='" . $paypallink . "'\" value=\"" . $lng_languag["invoicespaynow"] . "\" class=\"btn btn-success btn-primary paymentbtn\" />\n    ";
    return $code;
}

?>