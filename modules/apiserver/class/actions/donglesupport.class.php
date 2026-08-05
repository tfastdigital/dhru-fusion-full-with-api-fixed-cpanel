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
class DongleSupport extends action
{
    /**
     * Dongle name. Only in hex format (8 or 16 chars long)
     *
     * @var string 
     * @see dongleName()
     */
    private $dongle_name = "";
    /**
     * Dongle support length
     * 
     * @var int <br/>
     * 1 = 1 year
     * 2 = 2 years
     */
    private $support_time = 1;
    protected $action_name = "renewdonglesupport";
    public function __construct($API)
    {
        parent::__construct($API);
    }
    public function getMsgVars()
    {
        return ["action_name" => urlencode($this->action_name), "dongle_name" => urlencode($this->dongle_name), "support_type" => $this->support_time, "test_mode" => urlencode($this->testMode)];
    }
    public function dongleName($dongle_name)
    {
        $this->dongle_name = $dongle_name;
        return $this;
    }
    public function supportType($type)
    {
        if ($type == 1 || $type == 2) {
            $this->support_time = $type;
        }
        return $this;
    }
}

?>