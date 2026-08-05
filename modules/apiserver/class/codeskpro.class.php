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
echo "\n";
class CodeskPro
{
    public $xmlData = NULL;
    public $xmlResult = NULL;
    public $debug = NULL;
    public $action = NULL;
    public $_errors = ["10" => "API interface deactivated.", "50" => "Login error, missed username or API-Key.", "51" => "Login error, incorrect username or Key.", "60" => "Cmd error, incorrect command name.", "70" => "User inactive.", "80" => "Error, not enough params.", "90" => "Error, product not found.", "100" => "Error, empty list.", "110" => "Not enough credit.", "120" => "Product not found.", "130" => "One of sent fields is invalid.", "140" => "List not found.", "160" => "Error, duplicate order ( you have sent same order previously )", "999" => "Unknown error."];
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
                $request = $this->xmlData->createElement("PARAMS");
                $this->xmlData->appendChild($request);
                foreach ($arr as $key => $val) {
                    $key = strtoupper($key);
                    $request->appendChild($this->xmlData->createElement($key, $val));
                }
            }
            $posted = ["login" => USERNAME, "apikey" => API_ACCESS_KEY, "cmd" => $action, "format" => REQUESTFORMAT, "params" => $this->xmlData->saveHTML()];
            $crul = curl_init();
            curl_setopt($crul, CURLOPT_HEADER, false);
            curl_setopt($crul, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            curl_setopt($crul, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crul, CURLOPT_URL, CODESK_URL . "/api/api.php");
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
                    echo "<textarea rows='20' cols='200'> ";
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