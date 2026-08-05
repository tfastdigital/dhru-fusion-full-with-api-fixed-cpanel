<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 *Activate Feature action. Needs dongle name (hex format) and feature id.
 * @example ActiveFeatureExample.php
 */
class ActivateFeature extends action
{
    /**
     * Dongle name. Only in hex format (8 chars long)
     * @var string 
     * @see dongleName()
     */
    private $dongle_name = "";
    /**
     * Dongle feature
     * @var int
     */
    private $feature = 0;
    protected $action_name = "activatefeature";
    public function __construct($API)
    {
        parent::__construct($API);
    }
    public function getMsgVars()
    {
        return ["action_name" => urlencode($this->action_name), "dongle_name" => urlencode($this->dongle_name), "dongle_feature" => urlencode($this->feature), "test_mode" => urlencode($this->testMode)];
    }
    public function dongleName($dongle_name)
    {
        $this->dongle_name = $dongle_name;
        return $this;
    }
    public function featureId($feature_id)
    {
        $this->feature = $feature_id;
        return $this;
    }
}

?>