<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Actions with credits transfers
 * @example TransferCreditsExample.php
 */
class transferCredits extends action
{
    private $name = NULL;
    private $creditsAction = NULL;
    private $creditsAmount = 0;
    private $type = 0;
    protected $action_name = "transfercredits";
    public function __construct($API)
    {
        parent::__construct($API);
    }
    public function getMsgVars()
    {
        return ["action_name" => urlencode($this->action_name), "user_name" => urlencode($this->name), "type" => urlencode($this->type), "credits_action" => urlencode($this->creditsAction), "credits_amount" => urlencode($this->creditsAmount), "test_mode" => urlencode($this->testMode)];
    }
    public function toDongle($name)
    {
        $this->name = $name;
        $this->type = 2;
        return $this;
    }
    public function toUser($name)
    {
        $this->name = $name;
        $this->type = 1;
        return $this;
    }
    public function add($credits)
    {
        $this->creditsAction = "add";
        $this->creditsAmount = (int) $credits;
        return $this;
    }
    public function subtract($credits)
    {
        $this->creditsAction = "subtract";
        $this->creditsAmount = (int) $credits;
        return $this;
    }
}

?>