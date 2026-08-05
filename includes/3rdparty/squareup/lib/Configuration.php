<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect;

/**
 * Configuration Class Doc Comment
 * PHP version 5
 *
 * @category Class
 * @package  SquareConnect
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Configuration
{
    /**
     * Associate array to store API key(s)
     *
     * @var string[]
     */
    protected $apiKeys = [];
    /**
     * Associate array to store API prefix (e.g. Bearer)
     *
     * @var string[]
     */
    protected $apiKeyPrefixes = [];
    /**
     * Access token for OAuth
     *
     * @var string
     */
    protected $accessToken = "";
    /**
     * Username for HTTP basic authentication
     *
     * @var string
     */
    protected $username = "";
    /**
     * Password for HTTP basic authentication
     *
     * @var string
     */
    protected $password = "";
    /**
     * The default instance of ApiClient
     *
     * @var \SquareConnect\ApiClient
     */
    protected $defaultHeaders = [];
    /**
     * The host
     *
     * @var string
     */
    protected $host = "https://connect.squareup.com";
    /**
     * Timeout (second) of the HTTP request, by default set to 0, no timeout
     *
     * @var string
     */
    protected $curlTimeout = 0;
    /**
     * User agent of the HTTP request.
     *
     * @var string
     */
    protected $userAgent = "Square-Connect-PHP/2.20190612.0";
    /**
     * Debug switch (default set to false)
     *
     * @var bool
     */
    protected $debug = false;
    /**
     * Debug file location (log to STDOUT by default)
     *
     * @var string
     */
    protected $debugFile = "php://output";
    /**
     * Debug file location (log to STDOUT by default)
     *
     * @var string
     */
    protected $tempFolderPath = NULL;
    /**
     * Indicates if SSL verification should be enabled or disabled.
     *
     * This is useful if the host uses a self-signed SSL certificate.
     *
     * @var boolean True if the certificate should be validated, false otherwise.
     */
    protected $sslVerification = true;
    private static $_defaultConfiguration = NULL;
    public function __construct()
    {
        $this->tempFolderPath = sys_get_temp_dir();
    }
    public function setApiKey($apiKeyIdentifier, $key)
    {
        $this->apiKeys[$apiKeyIdentifier] = $key;
        return $this;
    }
    public function getApiKey($apiKeyIdentifier)
    {
        return isset($this->apiKeys[$apiKeyIdentifier]) ? $this->apiKeys[$apiKeyIdentifier] : NULL;
    }
    public function setApiKeyPrefix($apiKeyIdentifier, $prefix)
    {
        $this->apiKeyPrefixes[$apiKeyIdentifier] = $prefix;
        return $this;
    }
    public function getApiKeyPrefix($apiKeyIdentifier)
    {
        return isset($this->apiKeyPrefixes[$apiKeyIdentifier]) ? $this->apiKeyPrefixes[$apiKeyIdentifier] : NULL;
    }
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }
    public function getAccessToken()
    {
        return $this->accessToken;
    }
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function addDefaultHeader($headerName, $headerValue)
    {
        if (!is_string($headerName)) {
            throw new \InvalidArgumentException("Header name must be a string.");
        }
        $this->defaultHeaders[$headerName] = $headerValue;
        return $this;
    }
    public function getDefaultHeaders()
    {
        return $this->defaultHeaders;
    }
    public function deleteDefaultHeader($headerName)
    {
        unset($this->defaultHeaders[$headerName]);
    }
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }
    public function getHost()
    {
        return $this->host;
    }
    public function setUserAgent($userAgent)
    {
        if (!is_string($userAgent)) {
            throw new \InvalidArgumentException("User-agent must be a string.");
        }
        $this->userAgent = $userAgent;
        return $this;
    }
    public function getUserAgent()
    {
        return $this->userAgent;
    }
    public function setCurlTimeout($seconds)
    {
        if (!is_numeric($seconds) || $seconds < 0) {
            throw new \InvalidArgumentException("Timeout value must be numeric and a non-negative number.");
        }
        $this->curlTimeout = $seconds;
        return $this;
    }
    public function getCurlTimeout()
    {
        return $this->curlTimeout;
    }
    public function setDebug($debug)
    {
        $this->debug = $debug;
        return $this;
    }
    public function getDebug()
    {
        return $this->debug;
    }
    public function setDebugFile($debugFile)
    {
        $this->debugFile = $debugFile;
        return $this;
    }
    public function getDebugFile()
    {
        return $this->debugFile;
    }
    public function setTempFolderPath($tempFolderPath)
    {
        $this->tempFolderPath = $tempFolderPath;
        return $this;
    }
    public function getTempFolderPath()
    {
        return $this->tempFolderPath;
    }
    public function setSSLVerification($sslVerification)
    {
        $this->sslVerification = $sslVerification;
        return $this;
    }
    public function getSSLVerification()
    {
        return $this->sslVerification;
    }
    public static function getDefaultConfiguration()
    {
        if (self::$_defaultConfiguration == NULL) {
            self::$_defaultConfiguration = new Configuration();
        }
        return self::$_defaultConfiguration;
    }
    public static function setDefaultConfiguration(Configuration $config)
    {
        self::$_defaultConfiguration = $config;
    }
    public static function toDebugReport()
    {
        $report = "PHP SDK (SquareConnect) Debug Report:\n";
        $report .= "    OS: " . php_uname() . "\n";
        $report .= "    PHP Version: " . phpversion() . "\n";
        $report .= "    OpenAPI Spec Version: 2.0\n";
        $report .= "    SDK Package Version: 2.20190612.0\n";
        $report .= "    Temp Folder Path: " . self::getDefaultConfiguration()->getTempFolderPath() . "\n";
        return $report;
    }
}

?>