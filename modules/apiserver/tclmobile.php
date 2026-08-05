<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["tclmobilename"] = "tclmobile";
$APIMODULE["tclmobilevisiblename"] = "Tclmobile Custom api";
$APIMODULE["tclmobilenotes"] = "Custom api for tclmobile";
global $activationkey;
$activationkey = "OP38DJADG3";
function tclmobile_activate()
{
    GatewayField("tclmobile", "text", "activationkey", "", "Activation Key", "500", "");
}
function tclmobile_accoutinfo($VAL)
{
    global $activationkey;
    if ($VAL["activationkey"] != $activationkey) {
        $return["ERROR"] = "Activation Key Not Valid!";
    }
    return $return;
}
function tclmobile_services($VAL)
{
    $return["Group"][0]["ID"] = "tclmobile";
    $return["Group"][0]["Name"] = "Tcl Mobile";
    $return["Group"][0]["GroupType"] = "IMEI";
    $return["Group"][0]["Tool"][0]["ID"] = 1;
    $return["Group"][0]["Tool"][0]["ToolType"] = "IMEI";
    $return["Group"][0]["Tool"][0]["Name"] = "Tcl Mobile ImeiList";
    $return["Group"][0]["Tool"][0]["Credits"] = "1";
    return $return;
}
function tclmobile_send($VAL)
{
    global $activationkey;
    if ($VAL["activationkey"] != $activationkey) {
        $return["ERROR"] = "No Result Found";
        $return["MESSAGE"] = "Activation Key Not Valid!";
        return $return;
    }
    $imei = $VAL["IMEI"];
    $body = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<SOAP-ENV:Envelope xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ns1=\"http://tempuri.org/\">\n  <SOAP-ENV:Body>\n    <ns1:GetImeiInfoByImei>\n      <ns1:strImei>" . $imei . "</ns1:strImei>\n    </ns1:GetImeiInfoByImei>\n  </SOAP-ENV:Body>\n</SOAP-ENV:Envelope>";
    $headers = ["Content-Type: text/xml; charset=\"utf-8\"", "Content-Length: " . strlen($body), "Accept: text/xml", "Cache-Control: no-cache", "Pragma: no-cache"];
    $curl = curl_init("http://iplan.tclmobile.cn:8000/TCTService/Customer/ImeiList.asmx?wsdl");
    curl_setopt($curl, CURLOPT_TIMEOUT, 24);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($curl);
    curl_close($curl);
    $GetImeiInfoByImeiResult = trim(XMLtoARRAYss(trim($response))["SOAP:ENVELOPE"]["SOAP:BODY"]["GETIMEIINFOBYIMEIRESPONSE"]["GETIMEIINFOBYIMEIRESULT"]);
    $result = XMLtoARRAYss($GetImeiInfoByImeiResult)["IMEI"];
    $code = NULL;
    foreach ($result as $k => $v) {
        if (isset($v) && trim($v) != "") {
            $code .= $k . " : " . $v . " <br />";
        }
    }
    if ($code) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = json_encode($result);
        $return["CODES"] = $code;
    } else {
        $return["ERROR"] = "No Result Found";
        $return["MESSAGE"] = "No Result Found";
    }
    return $return;
}
function XMLtoARRAYss($rawxml)
{
    $xml_parser = xml_parser_create();
    xml_parse_into_struct($xml_parser, $rawxml, $vals, $index);
    xml_parser_free($xml_parser);
    $params = [];
    $level = [];
    $alreadyused = [];
    $x = 0;
    foreach ($vals as $xml_elem) {
        if ($xml_elem["type"] == "open") {
            if (in_array($xml_elem["tag"], $alreadyused)) {
                $x++;
                $xml_elem["tag"] = $xml_elem["tag"] . $x;
            }
            $level[$xml_elem["level"]] = $xml_elem["tag"];
            $alreadyused[] = $xml_elem["tag"];
        }
        if ($xml_elem["type"] == "complete") {
            $start_level = 1;
            for ($php_stmt = "\$params"; $start_level < $xml_elem["level"]; $start_level++) {
                $php_stmt .= "[\$level[" . $start_level . "]]";
            }
            $php_stmt .= "[\$xml_elem['tag']] = \$xml_elem['value'];";
            eval($php_stmt);
        }
    }
    return $params;
}

?>