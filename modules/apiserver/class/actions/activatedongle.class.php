<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 *Activate Dongle action. Needs dongle name (hex format), type for dongle
 * activation.
 * @example ActiveDongleExample.php
 */
class ActivateDongle extends action
{
    /**
     *Dongle name. Only in hex format (8 or 16 chars long)
     * @var string 
     * @see dongleName()
     */
    private $dongle_name = "";
    /**
     *Dongle type
     * @var int 
     * @see dongleType()
     */
    private $dongleType = NULL;
    /**
     *Dongle activation type:
     * @var int <br/>
     * 1 Full
     * 2 Lite
     */
    private $activationType = "full";
    protected $action_name = "activatedongle";
    public function __construct($API)
    {
        parent::__construct($API);
    }
    public function getMsgVars()
    {
        return ["action_name" => urlencode($this->action_name), "dongle_name" => urlencode($this->dongle_name), "dongle_type" => urlencode($this->dongleType), "act_type" => urlencode($this->activationType), "test_mode" => urlencode($this->testMode)];
    }
    public function dongleName($dongle_name)
    {
        $this->dongle_name = $dongle_name;
        return $this;
    }
    public function dongleType($dongleType)
    {
        $this->dongleType = $dongleType;
        return $this;
    }
    public function activationFull()
    {
        $this->activationType = 1;
        return $this;
    }
    public function activationLite()
    {
        $this->activationType = 2;
        return $this;
    }
}

?>