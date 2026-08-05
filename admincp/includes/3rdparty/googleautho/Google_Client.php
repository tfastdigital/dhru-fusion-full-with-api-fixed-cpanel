<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!function_exists("curl_init")) {
    throw new Exception("Google PHP API Client requires the CURL PHP extension");
}
if (!function_exists("json_decode")) {
    throw new Exception("Google PHP API Client requires the JSON PHP extension");
}
if (!function_exists("http_build_query")) {
    throw new Exception("Google PHP API Client requires http_build_query()");
}
if (!ini_get("date.timezone") && function_exists("date_default_timezone_set")) {
    date_default_timezone_set("UTC");
}
set_include_path(dirname(__FILE__) . PATH_SEPARATOR . get_include_path());
require_once "config.php";
if (file_exists(dirname(__FILE__) . "/local_config.php")) {
    $defaultConfig = $apiConfig;
    require_once dirname(__FILE__) . "/local_config.php";
    $apiConfig = array_merge($defaultConfig, $apiConfig);
}
require_once "service/Google_Model.php";
require_once "service/Google_Service.php";
require_once "service/Google_ServiceResource.php";
require_once "auth/Google_AssertionCredentials.php";
require_once "auth/Google_Signer.php";
require_once "auth/Google_P12Signer.php";
require_once "service/Google_BatchRequest.php";
require_once "external/URITemplateParser.php";
require_once "auth/Google_Auth.php";
require_once "cache/Google_Cache.php";
require_once "io/Google_IO.php";
require_once "service/Google_MediaFileUpload.php";
class Google_Exception extends Exception
{
}
class Google_AuthException extends Google_Exception
{
}
class Google_CacheException extends Google_Exception
{
}
class Google_IOException extends Google_Exception
{
}
class Google_ServiceException extends Google_Exception
{
    /**
     * Optional list of errors returned in a JSON body of an HTTP error response.
     */
    protected $errors = [];
    public function __construct($message, $code = 0, Exception $previous = NULL, $errors = [])
    {
        if (0 <= version_compare(PHP_VERSION, "5.3.0")) {
            parent::__construct($message, $code, $previous);
        } else {
            parent::__construct($message, $code);
        }
        $this->errors = $errors;
    }
    public function getErrors()
    {
        return $this->errors;
    }
}
/**
 * The Google API Client
 * http://code.google.com/p/google-api-php-client/
 *
 * @author Chris Chabot <chabotc@google.com>
 * @author Chirag Shah <chirags@google.com>
 */
class Google_Client
{
    /** @var array $scopes */
    protected $scopes = [];
    /** @var bool $useObjects */
    protected $useObjects = false;
    protected $services = [];
    private $authenticated = false;
    /**
     * @static
     * @var Google_Auth $auth
     */
    public static $auth = NULL;
    /**
     * @static
     * @var Google_IO $io
     */
    public static $io = NULL;
    /**
     * @static
     * @var Google_Cache $cache
     */
    public static $cache = NULL;
    /**
     * @static
     * @var boolean $useBatch
     */
    public static $useBatch = false;
    public function __construct($config = [])
    {
        global $apiConfig;
        $apiConfig = array_merge($apiConfig, $config);
        self::$cache = new $apiConfig["cacheClass"]();
        self::$auth = new $apiConfig["authClass"]();
        self::$io = new $apiConfig["ioClass"]();
    }
    public function addService($service, $version = false)
    {
        global $apiConfig;
        if ($this->authenticated) {
            throw new Google_Exception("Cant add services after having authenticated");
        }
        $this->services[$service] = [];
        if (isset($apiConfig["services"][$service])) {
            $this->services[$service] = array_merge($this->services[$service], $apiConfig["services"][$service]);
        }
    }
    public function authenticate($code = NULL)
    {
        $service = $this->prepareService();
        $this->authenticated = true;
        return self::$auth->authenticate($service, $code);
    }
    public function prepareService()
    {
        $service = [];
        $scopes = [];
        if ($this->scopes) {
            $scopes = $this->scopes;
        } else {
            foreach ($this->services as $key => $val) {
                if (isset($val["scope"])) {
                    if (is_array($val["scope"])) {
                        $scopes = array_merge($val["scope"], $scopes);
                    } else {
                        $scopes[] = $val["scope"];
                    }
                } else {
                    $scopes[] = "https://www.googleapis.com/auth/" . $key;
                }
                unset($val["discoveryURI"]);
                unset($val["scope"]);
                $service = array_merge($service, $val);
            }
        }
        $service["scope"] = implode(" ", $scopes);
        return $service;
    }
    public function setAccessToken($accessToken)
    {
        if ($accessToken == NULL || "null" == $accessToken) {
            $accessToken = NULL;
        }
        self::$auth->setAccessToken($accessToken);
    }
    public function setAuthClass($authClassName)
    {
        self::$auth = new $authClassName();
    }
    public function createAuthUrl()
    {
        $service = $this->prepareService();
        return self::$auth->createAuthUrl($service["scope"]);
    }
    public function getAccessToken()
    {
        $token = self::$auth->getAccessToken();
        return NULL == $token || "null" == $token ? NULL : $token;
    }
    public function isAccessTokenExpired()
    {
        return self::$auth->isAccessTokenExpired();
    }
    public function setDeveloperKey($developerKey)
    {
        self::$auth->setDeveloperKey($developerKey);
    }
    public function setState($state)
    {
        self::$auth->setState($state);
    }
    public function setAccessType($accessType)
    {
        self::$auth->setAccessType($accessType);
    }
    public function setApprovalPrompt($approvalPrompt)
    {
        self::$auth->setApprovalPrompt($approvalPrompt);
    }
    public function setApplicationName($applicationName)
    {
        global $apiConfig;
        $apiConfig["application_name"] = $applicationName;
    }
    public function setClientId($clientId)
    {
        global $apiConfig;
        $apiConfig["oauth2_client_id"] = $clientId;
        self::$auth->clientId = $clientId;
    }
    public function getClientId()
    {
        return self::$auth->clientId;
    }
    public function setClientSecret($clientSecret)
    {
        global $apiConfig;
        $apiConfig["oauth2_client_secret"] = $clientSecret;
        self::$auth->clientSecret = $clientSecret;
    }
    public function getClientSecret()
    {
        return self::$auth->clientSecret;
    }
    public function setRedirectUri($redirectUri)
    {
        global $apiConfig;
        $apiConfig["oauth2_redirect_uri"] = $redirectUri;
        self::$auth->redirectUri = $redirectUri;
    }
    public function getRedirectUri()
    {
        return self::$auth->redirectUri;
    }
    public function refreshToken($refreshToken)
    {
        self::$auth->refreshToken($refreshToken);
    }
    public function revokeToken($token = NULL)
    {
        self::$auth->revokeToken($token);
    }
    public function verifyIdToken($token = NULL)
    {
        return self::$auth->verifyIdToken($token);
    }
    public function setAssertionCredentials(Google_AssertionCredentials $creds)
    {
        self::$auth->setAssertionCredentials($creds);
    }
    public function setScopes($scopes)
    {
        $this->scopes = is_string($scopes) ? explode(" ", $scopes) : $scopes;
    }
    public function setUseObjects($useObjects)
    {
        global $apiConfig;
        $apiConfig["use_objects"] = $useObjects;
    }
    public function setUseBatch($useBatch)
    {
        self::$useBatch = $useBatch;
    }
    public static function getAuth()
    {
        return Google_Client::$auth;
    }
    public static function getIo()
    {
        return Google_Client::$io;
    }
    public function getCache()
    {
        return Google_Client::$cache;
    }
}

?>