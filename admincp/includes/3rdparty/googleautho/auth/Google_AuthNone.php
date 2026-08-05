<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Do-nothing authentication implementation, use this if you want to make un-authenticated calls
 * @author Chris Chabot <chabotc@google.com>
 * @author Chirag Shah <chirags@google.com>
 */
class Google_AuthNone extends Google_Auth
{
    public $key = NULL;
    public function __construct()
    {
        global $apiConfig;
        if (!empty($apiConfig["developer_key"])) {
            $this->setDeveloperKey($apiConfig["developer_key"]);
        }
    }
    public function setDeveloperKey($key)
    {
        $this->key = $key;
    }
    public function authenticate($service)
    {
    }
    public function setAccessToken($accessToken)
    {
    }
    public function getAccessToken()
    {
        return NULL;
    }
    public function createAuthUrl($scope)
    {
    }
    public function refreshToken($refreshToken)
    {
    }
    public function revokeToken()
    {
    }
    public function sign(Google_HttpRequest $request)
    {
        if ($this->key) {
            $request->setUrl($request->getUrl() . (strpos($request->getUrl(), "?") === false ? "?" : "&") . "key=" . urlencode($this->key));
        }
        return $request;
    }
}

?>