<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Dhru\Lib;

class Comm
{
    public function __construct()
    {
    }
    public static function initCurl($url, $postfields = [], $curlopts = [], $userpwd = "", $postjson = "")
    {
        $curlopts["CURLOPT_TIMEOUT"] = 300;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($userpwd) {
            curl_setopt($ch, CURLOPT_USERPWD, "api:" . $userpwd);
        }
        if ($postfields) {
            $fieldstring = urldecode(http_build_query($postfields));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldstring);
        } else {
            if ($postjson) {
                if (is_array($postjson)) {
                    $postjson = json_encode($postjson);
                }
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postjson);
            }
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $curlopts["CURLOPT_TIMEOUT"]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        if ($curlopts["HEADER"]) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $curlopts["HEADER"]);
        }
        $retval = curl_exec($ch);
        if (curl_errno($ch)) {
            $retval = "CURL Error: " . curl_errno($ch) . " - " . curl_error($ch);
        }
        curl_close($ch);
        return $retval;
    }
}

?>