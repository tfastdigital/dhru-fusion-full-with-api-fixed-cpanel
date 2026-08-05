<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

error_reporting(0);
class XML
{
    public $parser = NULL;
    public $document = NULL;
    public $parent = NULL;
    public $stack = NULL;
    public $last_opened_tag = NULL;
    public function XML()
    {
        $this->parser =& xml_parser_create();
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, "open", "close");
        xml_set_character_data_handler($this->parser, "data");
    }
    public function destruct()
    {
        xml_parser_free($this->parser);
    }
    public function &parse($data)
    {
        $this->document = [];
        $this->stack = [];
        $this->parent = $this->document;
        $var = xml_parse($this->parser, $data, true) ? $this->document : NULL;
        return $var;
    }
    public function open($parser, $tag, $attributes)
    {
        $this->data = "";
        $this->last_opened_tag = $tag;
        if (is_array($this->parent) && array_key_exists($tag, $this->parent)) {
            if (is_array($this->parent[$tag]) && array_key_exists(0, $this->parent[$tag])) {
                $key = count_numeric_items($this->parent[$tag]);
            } else {
                if (array_key_exists($tag . " attr", $this->parent)) {
                    $arr = ["0 attr" => $this->parent[$tag . " attr"], $this->parent[$tag]];
                    unset($this->parent[$tag . " attr"]);
                } else {
                    $arr = [$this->parent[$tag]];
                }
                $this->parent[$tag] = $arr;
                $key = 1;
            }
            $this->parent = $this->parent[$tag];
        } else {
            $key = $tag;
        }
        if ($attributes) {
            $this->parent[$key . " attr"] = $attributes;
        }
        $this->parent = $this->parent[$key];
        $this->stack[] = $this->parent;
    }
    public function data($parser, $data)
    {
        if ($this->last_opened_tag != NULL) {
            $this->data .= $data;
        }
    }
    public function close($parser, $tag)
    {
        if ($this->last_opened_tag == $tag) {
            $this->parent = $this->data;
            $this->last_opened_tag = NULL;
        }
        array_pop($this->stack);
        if ($this->stack) {
            $this->parent = $this->stack[count($this->stack) - 1];
        }
    }
}
function XML_unserialize($xml)
{
    if (function_exists(simplexml_load_string)) {
        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $array = json_decode($json, true);
    } else {
        $array["Error"] = "PHP function simplexml_load_string not found , contact hosting provider  ";
    }
    return $array;
}
function count_numeric_items($array)
{
    return is_array($array) ? count(array_filter(array_keys($array), "is_numeric")) : 0;
}
function callApi($key, $service, $url, $extra = NULL)
{
    $a_data = "api_key=" . $key;
    $a_data .= "&service=" . $service;
    if (is_array($extra)) {
        foreach ($extra as $k => $v) {
            $a_data .= "&" . $k . "=" . $v;
        }
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    $post_fields = $a_data;
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

?>