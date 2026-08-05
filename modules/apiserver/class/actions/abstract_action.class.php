<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Provides common function for actions classes
 */
abstract class action
{
    /**
     * action name of the action object
     * @var string 
     */
    protected $action_name = "";
    /**
     * DCUnlockerAPI class handler
     * @var DCUnlockerAPI 
     */
    protected $APIhandler = NULL;
    /**
     *Test mode by default disabled
     * @var bool
     */
    protected $testMode = 0;
    public function __call($name, $arguments)
    {
        if (function_exists($name)) {
            $this->{$name}($arguments);
        } else {
            return $this;
        }
    }
    public function __construct($API)
    {
        $this->APIhandler = $API;
    }
    public abstract function getMsgVars();
    public function submit()
    {
        return $this->APIhandler->submit();
    }
    public function TestModeOn()
    {
        $this->testMode = 1;
        return $this;
    }
}

?>