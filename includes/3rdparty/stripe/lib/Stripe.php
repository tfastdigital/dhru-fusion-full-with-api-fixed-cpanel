<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Stripe
 *
 * @package Stripe
 */
class Stripe
{
    private static $initialNetworkRetryDelay = 0.5;
    public static $apiKey = NULL;
    public static $clientId = NULL;
    public static $apiBase = "https://api.stripe.com";
    public static $connectBase = "https://connect.stripe.com";
    public static $apiUploadBase = "https://files.stripe.com";
    public static $apiVersion = NULL;
    public static $accountId = NULL;
    public static $caBundlePath = NULL;
    public static $verifySslCerts = true;
    public static $appInfo = NULL;
    public static $logger = NULL;
    public static $maxNetworkRetries = 0;
    public static $enableTelemetry = false;
    private static $maxNetworkRetryDelay = 2;
    const VERSION = "6.34.6";
    public static function getApiKey()
    {
        return self::$apiKey;
    }
    public static function getClientId()
    {
        return self::$clientId;
    }
    public static function getLogger()
    {
        if (self::$logger == NULL) {
            return new Util\DefaultLogger();
        }
        return self::$logger;
    }
    public static function setLogger($logger)
    {
        self::$logger = $logger;
    }
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }
    public static function setClientId($clientId)
    {
        self::$clientId = $clientId;
    }
    public static function getApiVersion()
    {
        return self::$apiVersion;
    }
    public static function setApiVersion($apiVersion)
    {
        self::$apiVersion = $apiVersion;
    }
    private static function getDefaultCABundlePath()
    {
        return realpath(dirname(__FILE__) . "/../data/ca-certificates.crt");
    }
    public static function getCABundlePath()
    {
        return self::$caBundlePath ?: self::getDefaultCABundlePath();
    }
    public static function setCABundlePath($caBundlePath)
    {
        self::$caBundlePath = $caBundlePath;
    }
    public static function getVerifySslCerts()
    {
        return self::$verifySslCerts;
    }
    public static function setVerifySslCerts($verify)
    {
        self::$verifySslCerts = $verify;
    }
    public static function getAccountId()
    {
        return self::$accountId;
    }
    public static function setAccountId($accountId)
    {
        self::$accountId = $accountId;
    }
    public static function getAppInfo()
    {
        return self::$appInfo;
    }
    public static function setAppInfo($appName, $appVersion = NULL, $appUrl = NULL, $appPartnerId = NULL)
    {
        self::$appInfo = self::$appInfo ?: [];
        self::$appInfo["name"] = $appName;
        self::$appInfo["partner_id"] = $appPartnerId;
        self::$appInfo["url"] = $appUrl;
        self::$appInfo["version"] = $appVersion;
    }
    public static function getMaxNetworkRetries()
    {
        return self::$maxNetworkRetries;
    }
    public static function setMaxNetworkRetries($maxNetworkRetries)
    {
        self::$maxNetworkRetries = $maxNetworkRetries;
    }
    public static function getMaxNetworkRetryDelay()
    {
        return self::$maxNetworkRetryDelay;
    }
    public static function getInitialNetworkRetryDelay()
    {
        return self::$initialNetworkRetryDelay;
    }
    public static function getEnableTelemetry()
    {
        return self::$enableTelemetry;
    }
    public static function setEnableTelemetry($enableTelemetry)
    {
        self::$enableTelemetry = $enableTelemetry;
    }
}

?>