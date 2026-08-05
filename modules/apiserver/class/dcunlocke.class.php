<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require "actions/abstract_action.class.php";
require "actions/information.class.php";
require "actions/activatedongle.class.php";
require "actions/transfercredits.class.php";
require "actions/createNewUser.class.php";
require "actions/userblock.class.php";
require "actions/donglesupport.class.php";
require "actions/activatefeature.class.php";
require "actions/activatelicense.class.php";
require "actions/message.class.php";
/**
 * DC-Unlocker API
 * @author DC-unlocker.com
 * @copyright DC-unlocker.com
 */
class DCUnlockerAPI
{
    /**
     * @access private
     * @var Abstract_action Hold information about available actions
     */
    private $action = NULL;
    /**
     * Client API version number
     * @var integer
     */
    private $version = 202;
    /**
     * DC-unlocker user
     * @var string
     */
    private $username = "";
    /**
     * DC-unlocker user password
     * @var string
     */
    private $password = "";
    /**
     * @var Message stores data for sending to API server, and gets response
     */
    private $message = NULL;
    public function __construct($username = "", $password = "")
    {
        $this->username = $username;
        $this->password = $password;
        $this->message = new Message();
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function information()
    {
        $this->action = new ActionInformation($this);
        return $this->action;
    }
    public function activateVygisDongle()
    {
        $this->action = new ActivateDongle($this);
        $this->action->dongleType(2);
        return $this->action;
    }
    public function activateRockerDongle()
    {
        $this->action = new ActivateDongle($this);
        $this->action->dongleType(3);
        return $this->action;
    }
    public function activateInfinityDongle()
    {
        $this->action = new ActivateDongle($this);
        $this->action->dongleType(4);
        return $this->action;
    }
    public function activateDongle()
    {
        $this->action = new ActivateDongle($this);
        $this->action->dongleType(0);
        return $this->action;
    }
    public function addCreditsToDongle($serial = "00000000", $credits = 0)
    {
        $this->action = new transferCredits($this);
        $this->action->toDongle($serial);
        $this->action->add($credits);
        return $this;
    }
    public function addCreditsToUser($name = "00000000", $credits = 0)
    {
        $this->action = new transferCredits($this);
        $this->action->toUser($name);
        $this->action->add($credits);
        return $this;
    }
    public function subtractCreditsFromUser($name = "00000000", $credits = 0)
    {
        $this->action = new transferCredits($this);
        $this->action->toUser($name);
        $this->action->subtract($credits);
        return $this;
    }
    public function TestModeOn()
    {
        $this->action->TestModeOn();
        return $this;
    }
    public function createNewUser($userName, $credits, $reseller = false, $license = 0)
    {
        $this->action = new createNewUser($this);
        $this->action->setName($userName);
        $this->action->setCredits($credits);
        $this->action->setReseller($reseller);
        $this->action->setLicense($license);
        return $this;
    }
    public function blockUser($name)
    {
        $this->action = new userBlock($this);
        $this->action->setName($name);
        return $this;
    }
    public function renewDongleSupport()
    {
        $this->action = new DongleSupport($this);
        return $this->action;
    }
    public function activateFeature()
    {
        $this->action = new ActivateFeature($this);
        return $this->action;
    }
    public function activateLicense()
    {
        $this->action = new ActivateLicense($this);
        return $this->action;
    }
    public function submit()
    {
        $this->message->buildrequest($this->action, $this->username, $this->password, $this->version);
        return $this->message->send();
    }
}

?>