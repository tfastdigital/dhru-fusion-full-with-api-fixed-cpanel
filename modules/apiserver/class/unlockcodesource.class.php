<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class UCS
{
    public $username = NULL;
    public $pass = NULL;
    public $apikey = NULL;
    public $response = NULL;
    public function action($action, $params = [])
    {
        $datarequest["API"]["username"] = $this->username;
        $datarequest["API"]["pass"] = $this->pass;
        $datarequest["API"]["key"] = $this->apikey;
        $datarequest["API"]["action"] = $action;
        switch ($action) {
            case "get_accountinfo":
                $datarequest["API"]["action"] = "get_accountinfo";
                break;
            case "get_unlocktools":
                isset($params["method_id"]);
                isset($params["method_id"]) ? $datarequest["API"]["method_id"] : $datarequest["API"]["method_id"];
                isset($params["cust_id"]);
                isset($params["cust_id"]) ? $datarequest["API"]["cust_id"] : $datarequest["API"]["cust_id"];
                $datarequest["API"]["action"] = "get_unlocktools";
                break;
            case "get_instructions":
                isset($params["instruction_id"]);
                isset($params["instruction_id"]) ? $datarequest["API"]["instruction_id"] : $datarequest["API"]["instruction_id"];
                $datarequest["API"]["action"] = "get_instructions";
                break;
            case "submit_order":
                isset($params["imei"]);
                isset($params["imei"]) ? $datarequest["API"]["imei"] : $datarequest["API"]["imei"];
                isset($params["phonemake_id"]);
                isset($params["phonemake_id"]) ? $datarequest["API"]["phonemake_id"] : $datarequest["API"]["phonemake_id"];
                isset($params["model"]);
                isset($params["model"]) ? $datarequest["API"]["model"] : $datarequest["API"]["model"];
                isset($params["tool_id"]);
                isset($params["tool_id"]) ? $datarequest["API"]["tool_id"] : $datarequest["API"]["tool_id"];
                isset($params["notes"]);
                isset($params["notes"]) ? $datarequest["API"]["notes"] : $datarequest["API"]["notes"];
                isset($params["cust_id"]);
                isset($params["cust_id"]) ? $datarequest["API"]["cust_id"] : $params["cust_id"];
                isset($params["params"]);
                isset($params["params"]) ? $datarequest["API"]["params"] : $params["params"];
                break;
            case "get_orderID":
                isset($params["orderID"]);
                isset($params["orderID"]) ? $datarequest["API"]["orderID"] : $datarequest["API"]["orderID"];
                $datarequest["API"]["action"] = "get_orderID";
                break;
            case "get_imei":
                isset($params["imei"]);
                isset($params["imei"]) ? $datarequest["API"]["imei"] : $datarequest["API"]["imei"];
                $datarequest["API"]["action"] = "get_imei";
                break;
            case "VIP_authuser":
                isset($params["vipuser"]);
                isset($params["vipuser"]) ? $datarequest["API"]["vipuser"] : $datarequest["API"]["vipuser"];
                isset($params["vippass"]);
                isset($params["vippass"]) ? $datarequest["API"]["vippass"] : $datarequest["API"]["vippass"];
                $datarequest["API"]["action"] = "VIP_authuser";
                break;
            case "VIP_orderhistory":
                isset($params["vip_id"]);
                isset($params["vip_id"]) ? $datarequest["API"]["vip_id"] : $datarequest["API"]["vip_id"];
                $datarequest["API"]["action"] = "VIP_orderhistory";
                break;
            case "VIP_balance":
                isset($params["vip_id"]);
                isset($params["vip_id"]) ? $datarequest["API"]["vip_id"] : $datarequest["API"]["vip_id"];
                $datarequest["API"]["action"] = "VIP_balance";
                break;
            case "VIP_pending":
                isset($params["vip_id"]);
                isset($params["vip_id"]) ? $datarequest["API"]["vip_id"] : $datarequest["API"]["vip_id"];
                $datarequest["API"]["action"] = "VIP_pending";
                break;
            case "VIP_changepass":
                isset($params["vip_id"]);
                isset($params["vip_id"]) ? $datarequest["API"]["vip_id"] : $datarequest["API"]["vip_id"];
                $datarequest["API"]["action"] = "VIP_changepass";
                isset($params["old_pass"]);
                isset($params["old_pass"]) ? $datarequest["API"]["old_pass"] : $datarequest["API"]["old_pass"];
                isset($params["new_pass"]);
                isset($params["new_pass"]) ? $datarequest["API"]["new_pass"] : $datarequest["API"]["new_pass"];
                break;
            case "VIP_getorder":
            case "get_RequiredParams":
                isset($params["tool_id"]);
                isset($params["tool_id"]) ? $datarequest["API"]["tool_id"] : $datarequest["API"]["tool_id"];
                break;
            case "get_SortedMethodList":
                $datarequest["API"]["action"] = "get_SortedMethodList";
                isset($params["vip_id"]);
                isset($params["vip_id"]) ? $datarequest["API"]["vip_id"] : $datarequest["API"]["vip_id"];
                break;
            default:
                $this->response = $this->sendQuery($datarequest);
        }
    }
    public function sendQuery($data)
    {
        $xmlrequest = XML_serialize($data);
        $xmlrequest = "data=" . $xmlrequest;
        $timeout = 90;
        $url = "http://www.unlockcodesource.com/API_v2/ucs_apiv3.php";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlrequest);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result["xml"] = curl_exec($ch);
        curl_close($ch);
        $result["data"] = XML_unserialize($result["xml"]);
        return $result;
    }
}
class Xml
{
    private $cdata = false;
    public static function serialize($data)
    {
        $instance = new Xml();
        return $instance->serializeArray($data);
    }
    public static function toXML($data)
    {
        $instance = new Xml();
        return $instance->serializeArray($data);
    }
    public static function unserialize($data, $hasCdata = false)
    {
        $instance = new Xml();
        if ($hasCdata) {
            $instance->setCdata(true);
        }
        return $instance->unserializeXml($data);
    }
    public static function toArray($data, $hasCdata)
    {
        $instance = new Xml();
        if ($hasCdata) {
            $instance->setCdata(true);
        }
        return $instance->unserializeXml($data);
    }
    public function __construct()
    {
    }
    private function unserializeXml($data)
    {
        return $this->xmlToArray($data);
    }
    private function xmlToArray($xmlstr)
    {
        if ($this->cdata) {
            $xmlstr = preg_replace("~<!\\[CDATA\\[\\s*|\\s*\\]\\]>~", "", $xmlstr);
        }
        $old = libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($xmlstr);
        libxml_use_internal_errors($old);
        $sxe = simplexml_import_dom($dom);
        $rxml = preg_replace(["/^<html><body>/", "/<\\/body><\\/html>\$/"], "", $sxe->asXML());
        $sx = simplexml_load_string($rxml);
        $rootNode = $sx->getName();
        $array = json_decode(json_encode((array) $sx), 1);
        return [$rootNode => $array];
    }
    private function setCdata($cdata)
    {
        $this->cdata = $cdata;
    }
    private function serializeArray($data)
    {
        $keys = array_keys($data);
        $xml = new SimpleXMLElement("<" . $keys[0] . ">" . "</" . $keys[0] . ">");
        $this->arrayToXml($data[$keys[0]], $xml);
        return $xml->asXML();
    }
    private function arrayToXml($data, &$xml, $currentKey = "key", $wasNumeric = false)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $currentKey = $key;
                    $keys = array_keys($value);
                    if (is_numeric($keys[0])) {
                        $wasNumeric = true;
                        $this->arrayToXml($value, $xml, $currentKey, $wasNumeric);
                    } else {
                        $wasNumeric = false;
                        $subnode = $xml->addChild((string) $currentKey);
                        $this->arrayToXml($value, $subnode, $currentKey, $wasNumeric);
                    }
                } else {
                    $subnode = $xml->addChild((string) $currentKey);
                    $this->arrayToXml($value, $subnode, $currentKey, $wasNumeric);
                }
            } else {
                if (is_numeric($key)) {
                    $xml->addChild((string) $currentKey, (string) $value);
                } else {
                    $xml->addChild((string) $key, (string) $value);
                }
            }
        }
    }
}
function XML_unserialize($param)
{
    return Xml::unserialize($param);
}
function XML_serialize($data)
{
    return Xml::serialize($data);
}

?>