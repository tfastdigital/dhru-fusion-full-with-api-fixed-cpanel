<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("BBC_API_DEBUG", false);
define("blockchecknet_API_URL", "http://blockcheck.net/api/");
if (!extension_loaded("curl")) {
    trigger_error("cURL extension not installed", 256);
}
class blockchecknet_API
{
    public $gf_channel = NULL;
    public $result = [];
    public function getResult()
    {
        return $this->result;
    }
    public function checkError($result)
    {
        if (isset($result["ERR"])) {
            echo "<h2> Error Code: " . $result["STATUS"] . "</h2>";
            echo "<h3>" . $result["ERR"] . "</h3>";
            exit;
        }
    }
    public function sendCommand($command, $params = [])
    {
        if (is_string($command) && is_array($params)) {
            $params["api_key"] = blockchecknet_API_ACCESS_KEY;
            $params["command"] = $command;
            $this->gf_channel = curl_init();
            curl_setopt($this->gf_channel, CURLOPT_HEADER, false);
            curl_setopt($this->gf_channel, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            curl_setopt($this->gf_channel, CURLOPT_RETURNTRANSFER, true);
            if (is_array($params)) {
                $vars = implode("&", $params);
            }
            curl_setopt($this->gf_channel, CURLOPT_URL, blockchecknet_API_URL);
            curl_setopt($this->gf_channel, CURLOPT_POST, true);
            curl_setopt($this->gf_channel, CURLOPT_POSTFIELDS, $params);
            $this->result = curl_exec($this->gf_channel);
            if (BBC_API_DEBUG && curl_errno($this->gf_channel) != CURLE_OK) {
                trigger_error(curl_error($this->gf_channel), 512);
            }
            curl_close($this->gf_channel);
        }
    }
    public function parse2Array($xml)
    {
        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $xml, $vals, $index);
        xml_parser_free($xml_parser);
        $params = [];
        $level = [];
        foreach ($vals as $xml_elem) {
            if ($xml_elem["type"] == "open") {
                if (array_key_exists("attributes", $xml_elem)) {
                    list($level[$xml_elem["level"]], $extra) = array_values($xml_elem["attributes"]);
                } else {
                    $level[$xml_elem["level"]] = $xml_elem["tag"];
                }
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
}

?>