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
class GsmPortal
{
    public $xmlData = NULL;
    public $xmlResult = NULL;
    public $debug = NULL;
    public $API_KEY = NULL;
    public $USERNAME = NULL;
    public $GSMPORTAL_URL = NULL;
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
            $action = strtoupper($action);
            $request = $this->xmlData->createElement("REQUEST");
            $act = $this->xmlData->createElement("ACTION", $action);
            $this->xmlData->appendChild($request);
            $request->appendChild($act);
            foreach ($arr as $key => $val) {
                $key = strtoupper($key);
                $request->appendChild($this->xmlData->createElement($key, $val));
            }
            $this->USERNAME;
            $posted = ["USERNAME" => $this->USERNAME, "API_KEY" => $this->API_KEY, "DATA" => $this->xmlData->saveHTML()];
            $crul = curl_init();
            curl_setopt($crul, CURLOPT_HEADER, false);
            curl_setopt($crul, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            curl_setopt($crul, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($crul, CURLOPT_URL, $this->GSMPORTAL_URL . "/sendbox/apiv2.php");
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
                    echo "<textarea rows='10' cols='100'>" . $response . "</textarea>";
                }
                $response = new SimpleXMLElement($response);
                if ($this->debug) {
                    echo "<pre>";
                    print_r($response);
                    echo "</pre>";
                }
                return $response;
            }
        }
        return false;
    }
}

?>