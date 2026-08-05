<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * DC-Unlocker API
 * @author DC-unlocker.com
 * @copyright DC-unlocker.com
 */
class createNewUser extends action
{
    protected $action_name = "CreateNewUser";
    private $credits = NULL;
    protected $userName = NULL;
    private $reseller = 0;
    private $license = 0;
    public function __construct($API)
    {
        parent::__construct($API);
    }
    public function setName($name)
    {
        $this->userName = $name;
        return $this;
    }
    public function getMsgVars()
    {
        return ["action_name" => urlencode($this->action_name), "user_name" => urlencode($this->userName), "credits" => urlencode($this->credits), "reseller" => urlencode($this->reseller), "user_license" => urlencode($this->license), "test_mode" => urlencode($this->testMode)];
    }
    public function setCredits($credits)
    {
        $this->credits = (int) $credits;
    }
    public function setReseller($reseller)
    {
        $this->reseller = (int) $reseller;
    }
    public function setLicense($license)
    {
        $this->license = (int) $license;
    }
}

?>