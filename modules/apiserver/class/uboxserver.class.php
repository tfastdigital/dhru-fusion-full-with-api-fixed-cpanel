<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require "nusoap/nusoap.php";
define("UBOX_API_URL", "http://codes.ath.cx/UBoxAPI.asmx?WSDL");
if (!extension_loaded("curl")) {
    trigger_error("cURL extension not installed", 256);
}
class APIUBOX
{
    public static function GetApiSign($User, $Pass, $Key)
    {
        $Sign = hash("sha512", $User . $Pass . $Key);
        return $Sign;
    }
    public static function CallMethod($Action, $Parameters = [])
    {
        if (is_string($Action)) {
            if (is_array($Parameters)) {
                $client = new nusoap_client(UBOX_API_URL, true);
                $client->soap_defencoding = "utf-8";
                $client->decode_utf8 = false;
                $client->xml_encoding = "utf-8";
                $Data = $client->call($Action, $Parameters);
                if (is_array($Data)) {
                    $Data = join($Data);
                }
                return $Data;
            }
            return false;
        }
        trigger_error("Action must be a string", 512);
        return false;
    }
    public static function HasError($XML)
    {
        $doc = new DOMDocument();
        $loaded = $doc->loadXML($XML);
        if (!$loaded) {
            echo "Could not load the XML";
        }
        $errors = $doc->getElementsByTagName("haserrors");
        foreach ($errors as $error) {
            $haserror = $error->nodeValue;
            if ($haserror == "false") {
                return false;
            }
            return true;
        }
    }
    public static function GetErrorDescription($XML)
    {
        $doc = new DOMDocument();
        $loaded = $doc->loadXML($XML);
        if (!$loaded) {
            echo "Could not load the XML";
        }
        $errors = $doc->getElementsByTagName("message");
        foreach ($errors as $error) {
            $errorDesc = $error->nodeValue;
            return $errorDesc;
        }
    }
}

?>