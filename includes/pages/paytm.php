<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<html>\r\n<head>\r\n    <title>Merchant Check Out Page</title>\r\n</head>\r\n";
$paytmParams["MID"] = "TQoWKM24614518880575";
$paytmParams["ORDER_ID"] = "SER123";
$paytmParams["CUST_ID"] = "CUST2929";
$paytmParams["MOBILE_NO"] = "7777777777";
$paytmParams["EMAIL"] = "username@emailprovider.com";
$paytmParams["CHANNEL_ID"] = "WEB";
$paytmParams["TXN_AMOUNT"] = "100.12";
$paytmParams["WEBSITE"] = "DEFAULT";
$paytmParams["INDUSTRY_TYPE_ID"] = "Retail";
$paytmParams["CALLBACK_URL"] = "https://www.phoneunlockshop.com";
$checksum = getchecksumfromarray($paytmParams, "hMKbfLN8rDQFB&2I");
echo "<body>\r\n<center><h1>Please do not refresh this page...</h1></center>\r\n<form method=\"post\" action=\"https://securegw.paytm.in/theia/processTransaction\" name=\"f1\">\r\n    <table border=\"1\">\r\n        <tbody>\r\n        <input type=\"hidden\" name=\"MID\" value=\"TQoWKM24614518880575\">\r\n        <input type=\"hidden\" name=\"WEBSITE\" value=\"DEFAULT\">\r\n        <input type=\"hidden\" name=\"ORDER_ID\" value=\"SER123\">\r\n        <input type=\"hidden\" name=\"CUST_ID\" value=\"CUST2929\">\r\n        <input type=\"hidden\" name=\"MOBILE_NO\" value=\"7777777777\">\r\n        <input type=\"hidden\" name=\"EMAIL\" value=\"username@emailprovider.com\">\r\n        <input type=\"hidden\" name=\"INDUSTRY_TYPE_ID\" value=\"Retail\">\r\n        <input type=\"hidden\" name=\"CHANNEL_ID\" value=\"WEB\">\r\n        <input type=\"hidden\" name=\"TXN_AMOUNT\" value=\"100.12\">\r\n        <input type=\"hidden\" name=\"CALLBACK_URL\" value=\"https://www.phoneunlockshop.com\">\r\n        <input type=\"hidden\" name=\"CHECKSUMHASH\" value=\"";
echo $checksum;
echo "\">\r\n        </tbody>\r\n    </table>\r\n    <input type='submit' name='submit' value='submit' />\r\n</form>\r\n</body>\r\n</html>";
function getChecksumFromArray($arrayList, $key)
{
    ksort($arrayList);
    $str = getArray2Str($arrayList);
    $salt = generateSalt_e(4);
    $finalString = $str . "|" . $salt;
    $hash = hash("sha256", $finalString);
    $hashString = $hash . $salt;
    $checksum = encrypt_e($hashString, $key);
    return $checksum;
}
function generateSalt_e($length)
{
    $random = "";
    srand((double) microtime() * 1000000);
    $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
    $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
    $data .= "0FGH45OP89";
    for ($i = 0; $i < $length; $i++) {
        $random .= substr($data, rand() % strlen($data), 1);
    }
    return $random;
}
function encrypt_e($input, $ky)
{
    $key = html_entity_decode($ky);
    $iv = "@@@@&&&&####\$\$\$\$";
    $data = openssl_encrypt($input, "AES-128-CBC", $key, 0, $iv);
    return $data;
}
function checkString_e($value)
{
    $myvalue = ltrim($value);
    $myvalue = rtrim($myvalue);
    if ($myvalue == "null") {
        $myvalue = "";
    }
    return $myvalue;
}
function getArray2Str($arrayList)
{
    $paramStr = "";
    $flag = 1;
    foreach ($arrayList as $key => $value) {
        if ($flag) {
            $paramStr .= checkstring_e($value);
            $flag = 0;
        } else {
            $paramStr .= "|" . checkstring_e($value);
        }
    }
    return $paramStr;
}

?>