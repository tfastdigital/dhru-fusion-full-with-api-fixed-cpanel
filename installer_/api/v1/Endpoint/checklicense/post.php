<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Dhru\Endpoint\checklicense;

class post extends Checklicense
{
    public $para = NULL;
    public function __construct($Base)
    {
        global $conn;
        //$this->para = $Base->parameters;
        
        $usersip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];
        $_post["json"] = true;
        $_post["licensekey"] = $this->para["licensekey"];
        $req = \Dhru\Lib\Comm::initCurl("https://cp.dhru.com/submit/verifylicense", $_post);
        $req = json_decode($req, true);
        if (1==1 && ($req["productid"] == 40 || $req["productid"] == 42 || $req["productid"] == 43)) {
            $RETURN["firstname"] = $req["firstname"];
            $RETURN["lastname"] = $req["lastname"];
            $RETURN["companyname"] = $req["companyname"];
            $RETURN["email"] = $req["email"];
            throw new \SuccessOut("License Details", $RETURN);
        }
        $RETURN["firstname"] = $req["firstname"];
            $RETURN["lastname"] = $req["lastname"];
            $RETURN["companyname"] = $req["companyname"];
            $RETURN["email"] = $req["email"];
            throw new \SuccessOut("License Details", $RETURN);
    }
    public static function config()
    {
        $RETURN["name"] = "Check License";
        $BODY["licensekey"]["type"] = "string";
        $BODY["licensekey"]["isrequired"] = true;
        $BODY["licensekey"]["example"] = "XXXX-XXXX-XXXX-XXXX-XXXX";
        $RETURN["body"] = $BODY;
        return $RETURN;
    }
}

?>