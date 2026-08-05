<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class ChimeraApi
{
    private $username = NULL;
    private $apiKey = NULL;
    const URL = "https://chimeratool.com/rapi/";
    public function __construct($username, $apiKey)
    {
        $this->username = $username;
        $this->apiKey = $apiKey;
    }
    private function sendCmd($cmd, $params = [])
    {
        $params["username"] = $this->username;
        $params["apikey"] = $this->apiKey;
        foreach ($params as $key => $value) {
            $up[] = $key . "=" . urlencode($value);
        }
        $r = file_get_contents("https://chimeratool.com/rapi/" . $cmd . "?" . join("&", $up));
        if ($r === false) {
            return ["success" => false, "code" => "000", "message" => "Couldn't connect to API!"];
        }
        if (empty($r)) {
            return ["success" => false, "code" => "001", "message" => "No response from API server!"];
        }
        return json_decode($r, true);
    }
    public function getTransferList($page = 1, $limit = 50)
    {
        return $this->sendCmd("list", ["page" => $page, "limit" => $limit]);
    }
    public function getInfo()
    {
        return $this->sendCmd("info", []);
    }
    public function transferCredit($userId, $amount)
    {
        return $this->sendCmd("transfer", ["userId" => $userId, "amount" => $amount]);
    }
    public function revokeTransfer($transferId)
    {
        return $this->sendCmd("revoke", ["transferId" => $transferId]);
    }
    public function checkUser($username, $email = "")
    {
        return $this->sendCmd("checkuser", ["user" => $username, "email" => $email]);
    }
    public function checkChimeraCard($serialnumber)
    {
        return $this->sendCmd("checkuser", ["serialnumber" => $serialnumber]);
    }
    public function sellLicence($targetid, $targettype, $licencename)
    {
        return $this->sendCmd("selllicence", ["targetid" => $targetid, "targettype" => $targettype, "licencename" => $licencename]);
    }
    public function extendLicence($userlicenceid)
    {
        return $this->sendCmd("extendlicence", ["userlicenceid" => $userlicenceid]);
    }
    public function upgradeLicence($username, $email)
    {
        return $this->sendCmd("upgradelicence", ["userlicenceid" => $userlicenceid]);
    }
    public function availableLicences()
    {
        return $this->sendCmd("availableLicences", []);
    }
    public function getSoldLicenceList($page = 1, $limit = 50)
    {
        return $this->sendCmd("listsoldlicences", ["page" => $page, "limit" => $limit]);
    }
    public function revokeLicence($actionId)
    {
        return $this->sendCmd("revokelicence", ["actionId" => $actionId]);
    }
}

?>