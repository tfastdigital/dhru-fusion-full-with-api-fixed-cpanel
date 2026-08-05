<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 *Activate License action. Needs user name and license id.
 * @example ActivateLicenseExample.php
 */
class ActivateLicense extends action
{
    private $user_name = "";
    private $license = 0;
    protected $action_name = "activatelicense";
    public function __construct($API)
    {
        parent::__construct($API);
    }
    public function getMsgVars()
    {
        return ["action_name" => urlencode($this->action_name), "user_name" => urlencode($this->user_name), "user_license" => urlencode($this->license), "test_mode" => urlencode($this->testMode)];
    }
    public function userName($user_name)
    {
        $this->user_name = $user_name;
        return $this;
    }
    public function licenseId($license_id)
    {
        $this->license = $license_id;
        return $this;
    }
}

?>