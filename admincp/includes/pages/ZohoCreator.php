<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
include_once "ZohoCreatorApplication.php";
class ZohoCreator extends Zoho
{
    protected $applications = [];
    public function __construct($authToken)
    {
        parent::__construct("creatorapi", "https://creator.zoho.com/api", $authToken);
    }
    public function application($name)
    {
        if (!array_key_exists($name, $this->applications)) {
            $this->applications[$name] = new ZohoCreatorApplication($name, $this);
        }
        return $this->applications[$name];
    }
    public function applications()
    {
        return $this->call("applications");
    }
}
$fileverioncheck = "6.1.0";

?>