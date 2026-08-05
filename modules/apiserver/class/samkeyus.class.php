<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class SAMKEYFusion
{
    public $xmlData = NULL;
    public $xmlResult = NULL;
    public $debug = NULL;
    public $action = NULL;
    public function __construct()
    {
        $this->xmlData = new DOMDocument();
    }
    public function getResult()
    {
        return $this->xmlResult;
    }
    public function action($action, $arr = [])
    {
        if (is_string($action) && is_array($arr)) {
            if (count($arr)) {
                $request = $this->xmlData->createElement("PARAMETERS");
                $this->xmlData->appendChild($request);
                foreach ($arr as $key => $val) {
                    $key = strtoupper($key);
                    $request->appendChild($this->xmlData->createElement($key, $val));
                }
            }
            $posted = ["username" => USERNAME, "apiaccesskey" => API_ACCESS_KEY, "action" => $action, "requestformat" => REQUESTFORMAT, "parameters" => $this->xmlData->saveHTML()];
            $crul = curl_init();
            curl_setopt($crul, CURLOPT_HEADER, false);
            curl_setopt($crul, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            curl_setopt($crul, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crul, CURLOPT_URL, SAMKEY_URL . "/api");
            curl_setopt($crul, CURLOPT_POST, true);
            curl_setopt($crul, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($crul, CURLOPT_POSTFIELDS, $posted);
            $response = curl_exec($crul);
            if (curl_errno($crul) != CURLE_OK) {
                echo curl_error($crul);
                curl_close($crul);
            } else {
                curl_close($crul);
                if ($this->debug) {
                    echo "<textarea  style='width:100%; height:300px;' > ";
                    print_r($response);
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