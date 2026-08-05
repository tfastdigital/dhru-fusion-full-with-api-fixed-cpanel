<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\HttpClient;

if (!defined("CURL_SSLVERSION_TLSv1")) {
    define("CURL_SSLVERSION_TLSv1", 1);
}
if (!defined("CURL_SSLVERSION_TLSv1_2")) {
    define("CURL_SSLVERSION_TLSv1_2", 6);
}
if (!defined("CURL_HTTP_VERSION_2TLS")) {
    define("CURL_HTTP_VERSION_2TLS", 4);
}
class CurlClient implements ClientInterface
{
    protected $defaultOptions = NULL;
    protected $userAgentInfo = NULL;
    protected $enablePersistentConnections = NULL;
    protected $enableHttp2 = NULL;
    protected $curlHandle = NULL;
    private $timeout = self::DEFAULT_TIMEOUT;
    private $connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;
    private static $instance = NULL;
    const DEFAULT_TIMEOUT = 80;
    const DEFAULT_CONNECT_TIMEOUT = 30;
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __construct($defaultOptions = NULL, $randomGenerator = NULL)
    {
        $this->defaultOptions = $defaultOptions;
        $this->randomGenerator = $randomGenerator ?: new \Stripe\Util\RandomGenerator();
        $this->initUserAgentInfo();
        $this->enablePersistentConnections = function_exists("curl_reset");
        $this->enableHttp2 = $this->canSafelyUseHttp2();
    }
    public function __destruct()
    {
        $this->closeCurlHandle();
    }
    public function initUserAgentInfo()
    {
        $curlVersion = curl_version();
        $this->userAgentInfo = ["httplib" => "curl " . $curlVersion["version"], "ssllib" => $curlVersion["ssl_version"]];
    }
    public function getDefaultOptions()
    {
        return $this->defaultOptions;
    }
    public function getUserAgentInfo()
    {
        return $this->userAgentInfo;
    }
    public function getEnablePersistentConnections()
    {
        return $this->enablePersistentConnections;
    }
    public function setEnablePersistentConnections($enable)
    {
        $this->enablePersistentConnections = $enable;
    }
    public function getEnableHttp2()
    {
        return $this->enableHttp2;
    }
    public function setEnableHttp2($enable)
    {
        $this->enableHttp2 = $enable;
    }
    public function setTimeout($seconds)
    {
        $this->timeout = (int) max($seconds, 0);
        return $this;
    }
    public function setConnectTimeout($seconds)
    {
        $this->connectTimeout = (int) max($seconds, 0);
        return $this;
    }
    public function getTimeout()
    {
        return $this->timeout;
    }
    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }
    public function request($method, $absUrl, $headers, $params, $hasFile)
    {
        $method = strtolower($method);
        $opts = [];
        if (is_callable($this->defaultOptions)) {
            $opts = call_user_func_array($this->defaultOptions, func_get_args());
            if (!is_array($opts)) {
                throw new \Stripe\Error\Api("Non-array value returned by defaultOptions CurlClient callback");
            }
        } else {
            if (is_array($this->defaultOptions)) {
                $opts = $this->defaultOptions;
            }
        }
        $params = \Stripe\Util\Util::objectsToIds($params);
        if ($method == "get") {
            if ($hasFile) {
                throw new \Stripe\Error\Api("Issuing a GET request with a file parameter");
            }
            $opts[CURLOPT_HTTPGET] = 1;
            if (0 < count($params)) {
                $encoded = \Stripe\Util\Util::encodeParameters($params);
                $absUrl = $absUrl . "?" . $encoded;
            }
        } else {
            if ($method == "post") {
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $hasFile ? $params : \Stripe\Util\Util::encodeParameters($params);
            } else {
                if ($method == "delete") {
                    $opts[CURLOPT_CUSTOMREQUEST] = "DELETE";
                    if (0 < count($params)) {
                        $encoded = \Stripe\Util\Util::encodeParameters($params);
                        $absUrl = $absUrl . "?" . $encoded;
                    }
                } else {
                    throw new \Stripe\Error\Api("Unrecognized method " . $method);
                }
            }
        }
        if ($method == "post" && 0 < \Stripe\Stripe::$maxNetworkRetries && !$this->hasHeader($headers, "Idempotency-Key")) {
            array_push($headers, "Idempotency-Key: " . $this->randomGenerator->uuid());
        }
        $rheaders = new \Stripe\Util\CaseInsensitiveArray();
        $headerCallback = function ($curl, $header_line) {
            static $rheaders = NULL;
            if (strpos($header_line, ":") === false) {
                return strlen($header_line);
            }
            list($key, $value) = explode(":", trim($header_line), 2);
            $rheaders[trim($key)] = trim($value);
            return strlen($header_line);
        };
        array_push($headers, "Expect: ");
        $absUrl = \Stripe\Util\Util::utf8($absUrl);
        $opts[CURLOPT_URL] = $absUrl;
        $opts[CURLOPT_RETURNTRANSFER] = true;
        $opts[CURLOPT_CONNECTTIMEOUT] = $this->connectTimeout;
        $opts[CURLOPT_TIMEOUT] = $this->timeout;
        $opts[CURLOPT_HEADERFUNCTION] = $headerCallback;
        $opts[CURLOPT_HTTPHEADER] = $headers;
        $opts[CURLOPT_CAINFO] = \Stripe\Stripe::getCABundlePath();
        if (!\Stripe\Stripe::getVerifySslCerts()) {
            $opts[CURLOPT_SSL_VERIFYPEER] = false;
        }
        if (!isset($opts[CURLOPT_HTTP_VERSION]) && $this->getEnableHttp2()) {
            $opts[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_2TLS;
        }
        list($rbody, $rcode) = $this->executeRequestWithRetries($opts, $absUrl);
        return [$rbody, $rcode, $rheaders];
    }
    private function executeRequestWithRetries($opts, $absUrl)
    {
        $numRetries = 0;
        while (true) {
            $rcode = 0;
            $errno = 0;
            $this->resetCurlHandle();
            curl_setopt_array($this->curlHandle, $opts);
            $rbody = curl_exec($this->curlHandle);
            if ($rbody === false) {
                $errno = curl_errno($this->curlHandle);
                $message = curl_error($this->curlHandle);
            } else {
                $rcode = curl_getinfo($this->curlHandle, CURLINFO_HTTP_CODE);
            }
            if (!$this->getEnablePersistentConnections()) {
                $this->closeCurlHandle();
            }
            if ($this->shouldRetry($errno, $rcode, $numRetries)) {
                $numRetries += 1;
                $sleepSeconds = $this->sleepTime($numRetries);
                usleep(intval($sleepSeconds * 1000000));
            }
        }
        if ($rbody === false) {
            $this->handleCurlError($absUrl, $errno, $message, $numRetries);
        }
        return [$rbody, $rcode];
    }
    private function handleCurlError($url, $errno, $message, $numRetries)
    {
        switch ($errno) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                $msg = "Could not connect to Stripe (" . $url . ").  Please check your " . "internet connection and try again.  If this problem persists, " . "you should check Stripe's service status at " . "https://twitter.com/stripestatus, or";
                break;
            case CURLE_SSL_CACERT:
            case CURLE_SSL_PEER_CERTIFICATE:
                $msg = "Could not verify Stripe's SSL certificate.  Please make sure that your network is not intercepting certificates.  " . "(Try going to " . $url . " in your browser.)  " . "If this problem persists,";
                break;
            default:
                $msg = "Unexpected error communicating with Stripe.  If this problem persists,";
                $msg .= " let us know at support@stripe.com.";
                $msg .= "\n\n(Network error [errno " . $errno . "]: " . $message . ")";
                if (0 < $numRetries) {
                    $msg .= "\n\nRequest was retried " . $numRetries . " times.";
                }
                throw new \Stripe\Error\ApiConnection($msg);
        }
    }
    private function shouldRetry($errno, $rcode, $numRetries)
    {
        if (\Stripe\Stripe::getMaxNetworkRetries() <= $numRetries) {
            return false;
        }
        if ($errno === CURLE_OPERATION_TIMEOUTED) {
            return true;
        }
        if ($errno === CURLE_COULDNT_CONNECT) {
            return true;
        }
        if ($rcode === 409) {
            return true;
        }
        return false;
    }
    private function sleepTime($numRetries)
    {
        $sleepSeconds = min(\Stripe\Stripe::getInitialNetworkRetryDelay() * 0 * pow(2, $numRetries - 1), \Stripe\Stripe::getMaxNetworkRetryDelay());
        $sleepSeconds *= 0 * (1 + $this->randomGenerator->randFloat());
        $sleepSeconds = max(\Stripe\Stripe::getInitialNetworkRetryDelay(), $sleepSeconds);
        return $sleepSeconds;
    }
    private function initCurlHandle()
    {
        $this->closeCurlHandle();
        $this->curlHandle = curl_init();
    }
    private function closeCurlHandle()
    {
        if (!is_null($this->curlHandle)) {
            curl_close($this->curlHandle);
            $this->curlHandle = NULL;
        }
    }
    private function resetCurlHandle()
    {
        if (!is_null($this->curlHandle) && $this->getEnablePersistentConnections()) {
            curl_reset($this->curlHandle);
        } else {
            $this->initCurlHandle();
        }
    }
    private function canSafelyUseHttp2()
    {
        $curlVersion = curl_version()["version"];
        return 0 <= version_compare($curlVersion, "7.60.0");
    }
    private function hasHeader($headers, $name)
    {
        foreach ($headers as $header) {
            if (strncasecmp($header, $name . ": ", strlen($name) + 2) === 0) {
                return true;
            }
        }
        return false;
    }
}

?>