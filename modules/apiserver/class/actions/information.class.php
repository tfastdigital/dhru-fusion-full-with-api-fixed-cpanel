<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Information about user / dongle specific data.
 * @example checkCreditsExample.php example how to check remaining credits
 * @example checkAllDongleInfoExample.php example how to get all related dongle information 
 * @example checkUserNameExample.php example how to check existence of userName
 * @example checkDongleSnExample.php example how to check existence of Dongle Sn
 */
class ActionInformation extends action
{
    protected $action_name = "information";
    private $type = 1;
    /**
     * @var string User name or Dongle HID <br/>
     * default: API user username
     */
    private $checkUser = "";
    /**
     * @var string Specify what information to retrieve <br/>
     * 'credits' - returns user's remaining credit amount
     */
    private $operation = NULL;
    public function __construct($API)
    {
        parent::__construct($API);
    }
    public function getMsgVars()
    {
        if ($this->checkUser === "") {
            $this->checkUser = $this->APIhandler->getUsername();
        }
        return ["action_name" => urlencode($this->action_name), "type" => urlencode($this->type), "checked_name" => urlencode($this->checkUser), "operation" => urlencode($this->operation), "test_mode" => urlencode($this->testMode)];
    }
    public function checkDongle($serial)
    {
        $this->checkUser = $serial;
        $this->type = 2;
        return $this;
    }
    public function checkUser($userName)
    {
        $this->checkUser = $userName;
        $this->type = 1;
        return $this;
    }
    public function checkUserName($userName)
    {
        $this->checkUser = $userName;
        $this->operation = "check_user_name";
        $this->type = 1;
        return $this;
    }
    public function checkDongleSN($dongleSn)
    {
        $this->checkUser = $dongleSn;
        $this->operation = "check_dongle_name_exists";
        $this->type = 2;
        return $this;
    }
    public function creditsLeft()
    {
        $this->operation = "view_credits";
        return $this;
    }
    public function getAllInfo()
    {
        $this->operation = "view_all_info";
        return $this;
    }
    public function getDongleSupportStatus()
    {
        $this->operation = "view_support";
        return $this;
    }
    public function getTimedLicenseStatus()
    {
        $this->operation = "view_license";
        return $this;
    }
    public function getDongleActiveFeatures()
    {
        $this->operation = "view_features";
        return $this;
    }
    public function getFeaturesList()
    {
        $this->operation = "get_features_list";
        return $this;
    }
    public function getTimedLicenseList()
    {
        $this->operation = "get_license_list";
        return $this;
    }
    public function getDongleSupportList()
    {
        $this->operation = "get_support_list";
        return $this;
    }
    public function getDongleActivationList()
    {
        $this->operation = "get_activation_list";
        return $this;
    }
}

?>