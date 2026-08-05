<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "Google_AuthNone.php";
require_once "Google_OAuth2.php";
/**
 * Abstract class for the Authentication in the API client
 * @author Chris Chabot <chabotc@google.com>
 *
 */
abstract class Google_Auth
{
    public abstract function authenticate($service);
    public abstract function sign(Google_HttpRequest $request);
    public abstract function createAuthUrl($scope);
    public abstract function getAccessToken();
    public abstract function setAccessToken($accessToken);
    public abstract function setDeveloperKey($developerKey);
    public abstract function refreshToken($refreshToken);
    public abstract function revokeToken();
}

?>