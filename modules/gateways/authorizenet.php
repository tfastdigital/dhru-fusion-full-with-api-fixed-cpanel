<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function authorizenet_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "authorize.net"], "loginid" => ["Name" => "Login ID", "Type" => "text", "Size" => "50"], "transactionkey" => ["Name" => "Transaction Key", "Type" => "text", "Size" => "50"]];
    return $configarray;
}
function authorizenet_link($params)
{
    global $config;
    $month = "<select name='month' class='form-control'>";
    for ($i = 1; $i <= 12; $i++) {
        $month .= "<option>" . $i . "</option>";
    }
    $month .= "</select>";
    $year = "<select name='year'  class='form-control'>";
    for ($i = date("Y"); $i <= date("Y") + 10; $i++) {
        $year .= "<option>" . $i . "</option>";
    }
    $year .= "</select>";
    if ($config["config_ssl_allow"]) {
        $siteaddress = $config["config_ssl_allow"];
    } else {
        $siteaddress = $config["site_address"];
    }
    $code = "\r\n\r\n<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#stripemodal\">\r\n   Pay with Authorize.net\r\n</button>\r\n\r\n <div class=\"modal fade\" tabindex=\"-1\" role=\"dialog\" id=\"stripemodal\" data-backdrop=\"static\" data-keyboard=\"false\">\r\n\r\n  <div class=\"modal-dialog modal-dialog-centered\" role=\"document\">\r\n    <div class=\"modal-content\">\r\n      <div class=\"modal-header\">\r\n        <h5 class=\"modal-title\">Authorize.net Gateway</h5>\r\n        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">\r\n          <span aria-hidden=\"true\">&times;</span>\r\n        </button>\r\n      </div>\r\n      <div class=\"modal-body\" style=\"padding:15px\">\r\n      \r\n    <form method=\"post\" action=\"" . _url("viewinvoice/id/" . md5($params["invoiceid"]), true) . "\">\r\n    <input type=\"hidden\" name=\"authorize\" value=\"1\" />\r\n\r\n<table class=\"w-100\" style=\"text-align:left\">\r\n    <tr>\r\n    <td colspan=\"3\">Card Number : <br/><input name=\"card\" type=\"text\" size=\"16\" class=\"form-control\" placeholder=\"Card Number\" /> </td>\r\n    </tr>\r\n    <tr>\r\n        <td>Expiry On : <br/>" . $month . "</td>\r\n        <td><br/>" . $year . "</td>\r\n        <td>CVV : <br/><input type=\"text\" class=\"form-control\" style=\"width:70px;\" name=\"cvv\" size=\"3\" /> </td>\r\n    </tr>\r\n    <tr>     \r\n    <td colspan=\"3\">\r\n    <br/>\r\n    <input type=\"submit\" name=\"submit\" class=\"btn btn-primary paymentbtn\" value=\"Pay Now\" />\r\n    </td>\r\n</tr>\r\n</table>\r\n    </form>\r\n    </div>\r\n    </div>\r\n    </div>\r\n   ";
    return $code;
}

?>