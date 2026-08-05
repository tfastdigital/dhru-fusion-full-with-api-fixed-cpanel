<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!extension_loaded("curl")) {
    trigger_error("cURL extension not installed", 256);
}
class DhruFusion
{
    public $xmlData = NULL;
    public $xmlResult = NULL;
    public $debug = NULL;
    public $action = NULL;
    public $apiurl = NULL;
    public $username = NULL;
    public $apikey = NULL;
    public $removeindex = NULL;
    public function __construct()
    {
        $this->xmlData = new DOMDocument();
    }
    public function getResult()
    {
        return $this->xmlResult;
    }
    public function action($action, $arr = [], $json = false)
    {
        global $debug_output;
        if (is_string($action) && is_array($arr)) {
            if (count($arr)) {
                if ($json) {
                    $request = base64_encode(json_encode($arr));
                } else {
                    $request = $this->xmlData->createElement("PARAMETERS");
                    $this->xmlData->appendChild($request);
                    foreach ($arr as $key => $val) {
                        $key = strtoupper($key);
                        $request->appendChild($this->xmlData->createElement($key, $val));
                    }
                    $request = $this->xmlData->saveHTML();
                }
            }
            $posted = ["username" => $this->username, "apiaccesskey" => $this->apikey, "action" => $action, "requestformat" => REQUESTFORMAT, "parameters" => $request, "version" => VERSION];
            logActivity($this->username . "|" . $this->apikey . "+" . $action . "+REQUESTFORMAT+" . $request);
            logActivity(implode(",", $request));
            $crul = curl_init();
            curl_setopt($crul, CURLOPT_HEADER, false);
            curl_setopt($crul, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            curl_setopt($crul, CURLOPT_RETURNTRANSFER, true);
            if ($this->removeindex) {
                curl_setopt($crul, CURLOPT_URL, $this->apiurl . "/api");
            } else {
                curl_setopt($crul, CURLOPT_URL, $this->apiurl . "/api/index.php");
            }
            curl_setopt($crul, CURLOPT_POST, true);
            curl_setopt($crul, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($crul, CURLOPT_POSTFIELDS, $posted);
            $headers = ["X-Powered-By: DHRU-FUSION"];
            $response = curl_exec($crul);
            curl_error($crul);
            if (curl_errno($crul) != CURLE_OK) {
                echo curl_error($crul);
                curl_close($crul);
            } else {
                curl_close($crul);
                if ($this->debug || $debug_output) {
                    echo "<textarea rows='20' cols='200'> ";
                    echo $response;
                    echo "</textarea>";
                }
                return json_decode($response, true);
            }
        }
        return false;
    }
}
function XMLtoARRAY($rawxml)
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