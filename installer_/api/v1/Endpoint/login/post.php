<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Dhru\Endpoint\login;

class post extends Login
{
    public function __construct()
    {
        $dbc = new \Dhru\Lib\DBCompare("localhost", "newinstall", "fusion", "DHRU()()1");
        $json = file_get_contents(ROOTDIR . "/Lib/schema.json");
        $dbc->differ($json);
        $RETURN = $dbc->exec();
        throw new \SuccessOut("Login POST Loaded", $RETURN);
    }
    public static function config()
    {
        $RETURN["name"] = "Login";
        $RETURN["description"] = "Login to system and get token";
        $BODY["username"]["type"] = "string";
        $BODY["username"]["isrequired"] = true;
        $BODY["username"]["example"] = "UserName";
        $BODY["password"]["type"] = "string";
        $BODY["password"]["isrequired"] = true;
        $BODY["password"]["example"] = "Password";
        $RETURN["body"] = $BODY;
        return $RETURN;
    }
}

?>