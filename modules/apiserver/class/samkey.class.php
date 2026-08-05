<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class SAMKEYAPI
{
    public $objCurl = NULL;
    public $result = [];
    public $API_KEY = "XXXX-XXXX-XXXX-XXXX-XXXX";
    public $USER_NAME = "XXXXXX";
    public $URL = "http://samkey.org/api/index.php";
    public function action($action, $credits = "", $UN = "", $refNo = "", $fingerPrint = "", $quantity = "", $serviceId = "")
    {
        if (is_string($action)) {
            $posted = ["uName" => $this->USER_NAME, "apiKey" => $this->API_KEY, "action" => $action, "credits" => $credits, "userName" => $UN, "fingerPrint" => $fingerPrint, "refNo" => $refNo, "quantity" => $quantity, "serviceId" => $serviceId, "requestformat" => "JSON"];
            $this->objCurl = curl_init();
            curl_setopt($this->objCurl, CURLOPT_HEADER, false);
            curl_setopt($this->objCurl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            curl_setopt($this->objCurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->objCurl, CURLOPT_URL, $this->URL);
            curl_setopt($this->objCurl, CURLOPT_POST, true);
            curl_setopt($this->objCurl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->objCurl, CURLOPT_POSTFIELDS, $posted);
            $response = curl_exec($this->objCurl);
            if (curl_errno($this->objCurl) != CURLE_OK) {
                echo curl_error($this->objCurl);
                curl_close($this->objCurl);
            } else {
                curl_close($this->objCurl);
                return json_decode($response, true);
            }
        }
    }
}

?>