<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DHRUSOFT") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function ipTrim($value)
{
    $value = trim($value);
}
function toXml($data, $rootNodeName = "data", $xml = NULL)
{
    if ($xml == NULL) {
        $xml = simplexml_load_string("<?xml version='1.0' encoding='UTF-8'?><" . $rootNodeName . " />");
    }
    foreach ($data as $key => $value) {
        if (is_numeric($key)) {
            $key = "RESULT" . (string) $key;
        }
        $key = preg_replace("/[^a-z]/i", "", $key);
        if (is_array($value)) {
            $node = $xml->addChild($key);
            toXml($value, $rootNodeName, $node);
        } else {
            $value = htmlentities($value);
            $xml->addChild($key, $value);
        }
    }
    return $xml->asXML();
}
function checkParameters($para = "")
{
    global $parameters;
    if (!is_array($parameters)) {
        $parameters = html_entity_decode($parameters);
        $parameters = XMLtoARRAY($parameters);
        $parameters = $parameters["PARAMETERS"];
    }
    if ($para) {
        foreach ($para as $k => $v) {
            if (!$parameters[$v]) {
                $apiresults["ERROR"][] = ["MESSAGE" => "Parameter '" . $v . "' Required"];
            } else {
                if ($k == "IMEI") {
                    $apiresults[$v] = preg_replace("/[^#0-9a-zA-Z,.-]/i", "", $parameters[$v]);
                } else {
                    $apiresults[$v] = preg_replace("/[^0-9a-zA-Z,.-]/i", "", $parameters[$v]);
                }
            }
        }
        if ($parameters) {
            foreach ($parameters as $k => $v) {
                if ($k == "IMEI") {
                    $apiresults[$k] = preg_replace("/[^#0-9a-zA-Z,.-]/i", "", $parameters[$k]);
                } else {
                    $apiresults[$k] = preg_replace("/[^0-9a-zA-Z,.-]/i", "", $parameters[$k]);
                }
            }
        }
        return $apiresults;
    }
}
function getParameters()
{
    $_POST =& $_POST;
    return XMLtoARRAY($_POST["parameters"]);
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