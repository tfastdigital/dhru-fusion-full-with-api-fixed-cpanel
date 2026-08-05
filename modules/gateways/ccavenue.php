<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function ccavenue_config()
{
    $configarray = ["name" => ["Type" => "System", "Value" => "ccAvenue"], "merchantid" => ["Type" => "text", "Name" => "Merchant ID", "Size" => "20", "Description" => "Enter your User ID for CCAvenue here"], "workingkey" => ["Type" => "text", "Name" => "Working Key", "Size" => "40", "Description" => "Enter the Working Key here"]];
    return $configarray;
}
function ccavenue_link($params)
{
    global $lng_languag;
    $Merchant_Id = $params["merchantid"];
    $Amount = sprintf("%.2f", $params["amount"]);
    $Order_Id = $params["invoiceid"] . "_" . date("YmdHis");
    $Redirect_Url = $params["systemurl"] . "/modules/gateways/callback/ccavenue.php";
    $WorkingKey = $params["workingkey"];
    $Checksum = ccavenue_getCheckSum($Merchant_Id, $Amount, $Order_Id, $Redirect_Url, $WorkingKey);
    $strRet = "<form name=ccavenue method=\"post\" action=\"https://www.ccavenue.com/shopzone/cc_details.jsp\">";
    $strRet .= "<input type=hidden name=Merchant_Id value=\"" . $Merchant_Id . "\">";
    $strRet .= "<input type=hidden name=Amount value=\"" . $Amount . "\">";
    $strRet .= "<input type=hidden name=Order_Id value=\"" . $Order_Id . "\">";
    $strRet .= "<input type=hidden name=Redirect_Url value=\"" . $Redirect_Url . "\">";
    $strRet .= "<input type=hidden name=Checksum value=\"" . $Checksum . "\">";
    $strRet .= "<input type=\"hidden\" name=\"billing_cust_name\" value=\"" . $params["clientdetails"]["firstname"] . " " . $params["clientdetails"]["lastname"] . "\">";
    $strRet .= "<input type=\"hidden\" name=\"billing_cust_address\" value=\"" . $params["clientdetails"]["address1"] . "\">";
    $strRet .= "<input type=\"hidden\" name=\"billing_cust_country\" value=\"" . $params["clientdetails"]["country"] . "\">";
    $strRet .= "<input type=\"hidden\" name=\"billing_cust_tel\" value=\"" . $params["clientdetails"]["phonenumber"] . "\">";
    $strRet .= "<input type=\"hidden\" name=\"billing_cust_email\" value=\"" . $params["clientdetails"]["email"] . "\">";
    $strRet .= "<input type=\"hidden\" name=\"delivery_cust_name\" value=\"" . $params["clientdetails"]["firstname"] . " " . $params["clientdetails"]["lastname"] . "\">";
    $strRet .= "<input type=\"hidden\" name=\"delivery_cust_address\" value=\"" . $params["clientdetails"]["address1"] . "\">";
    $strRet .= "<input type=\"hidden\" name=\"delivery_cust_tel\" value=\"" . $params["clientdetails"]["phonenumber"] . "\">";
    $strRet .= "<input type=\"hidden\" name=\"delivery_cust_notes\" value=\"Invoice #" . $Order_Id . "\">";
    $strRet .= "<input type=\"submit\" class=\"btn btn-success btn-primary paymentbtn\" value=\"" . $lng_languag["invoicespaynow"] . "\">";
    $strRet .= "</form>";
    return $strRet;
}
function ccavenue_getchecksum($MerchantId, $Amount, $OrderId, $URL, $WorkingKey)
{
    $str = $MerchantId . "|" . $OrderId . "|" . $Amount . "|" . $URL . "|" . $WorkingKey;
    $adler = 1;
    $adler = ccavenue_adler32($adler, $str);
    return $adler;
}
function ccavenue_adler32($adler, $str)
{
    $BASE = 65521;
    $s1 = $adler & 65535;
    $s2 = $adler >> 16 & 65535;
    for ($i = 0; $i < strlen($str); $i++) {
        $s1 = ($s1 + Ord($str[$i])) % $BASE;
        $s2 = ($s2 + $s1) % $BASE;
    }
    return ccavenue_leftshift($s2, 16) + $s1;
}
function ccavenue_leftshift($str, $num)
{
    $str = DecBin($str);
    for ($i = 0; $i < 64 - strlen($str); $i++) {
        $str = "0" . $str;
    }
    for ($i = 0; $i < $num; $i++) {
        $str = $str . "0";
        $str = substr($str, 1);
    }
    return ccavenue_cdec($str);
}
function ccavenue_cdec($num)
{
    for ($n = 0; $n < strlen($num); $n++) {
        $temp = $num[$n];
        $dec = $dec + $temp * pow(2, strlen($num) - $n - 1);
    }
    return $dec;
}

?>