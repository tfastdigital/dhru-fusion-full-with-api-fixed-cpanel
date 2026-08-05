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
class userBlock extends action
{
    /**
     *User specific action name
     * @var string 
     */
    protected $action_name = "blockuser";
    protected $userName = NULL;
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
        return ["action_name" => urlencode($this->action_name), "user_name" => urlencode($this->userName), "test_mode" => urlencode($this->testMode)];
    }
}

?>