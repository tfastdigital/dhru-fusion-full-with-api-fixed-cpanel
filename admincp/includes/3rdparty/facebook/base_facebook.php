<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!function_exists("curl_init")) {
    throw new Exception("Facebook needs the CURL PHP extension.");
}
if (!function_exists("json_decode")) {
    throw new Exception("Facebook needs the JSON PHP extension.");
}
/**
 * Thrown when an API call returns an exception.
 *
 * @author Naitik Shah <naitik@facebook.com>
 */
class FacebookApiException extends Exception
{
    /**
     * The result from the API server that represents the exception information.
     */
    protected $result = NULL;
    public function __construct($result)
    {
        $this->result = $result;
        $code = isset($result["error_code"]) ? $result["error_code"] : 0;
        if (isset($result["error_description"])) {
            $msg = $result["error_description"];
        } else {
            if (isset($result["error"]) && is_array($result["error"])) {
                $msg = $result["error"]["message"];
            } else {
                if (isset($result["error_msg"])) {
                    $msg = $result["error_msg"];
                } else {
                    $msg = "Unknown Error. Check getResult()";
                }
            }
        }
        parent::__construct($msg, $code);
    }
    public function getResult()
    {
        return $this->result;
    }
    public function getType()
    {
        if (isset($this->result["error"])) {
            $error = $this->result["error"];
            if (is_string($error)) {
                return $error;
            }
            if (is_array($error) && isset($error["type"])) {
                return $error["type"];
            }
        }
        return "Exception";
    }
    public function __toString()
    {
        $str = $this->getType() . ": ";
        if ($this->code != 0) {
            $str .= $this->code . ": ";
        }
        return $str . $this->message;
    }
}
/**
 * Provides access to the Facebook Platform.  This class provides
 * a majority of the functionality needed, but the class is abstract
 * because it is designed to be sub-classed.  The subclass must
 * implement the four abstract methods listed at the bottom of
 * the file.
 *
 * @author Naitik Shah <naitik@facebook.com>
 */
abstract class BaseFacebook
{
    /**
     * The Application ID.
     *
     * @var string
     */
    protected $appId = NULL;
    /**
     * The Application App Secret.
     *
     * @var string
     */
    protected $appSecret = NULL;
    /**
     * The ID of the Facebook user, or 0 if the user is logged out.
     *
     * @var integer
     */
    protected $user = NULL;
    /**
     * The data from the signed_request token.
     */
    protected $signedRequest = NULL;
    /**
     * A CSRF state variable to assist in the defense against CSRF attacks.
     */
    protected $state = NULL;
    /**
     * The OAuth access token received in exchange for a valid authorization
     * code.  null means the access token has yet to be determined.
     *
     * @var string
     */
    protected $accessToken = NULL;
    /**
     * Indicates if the CURL based @ syntax for file uploads is enabled.
     *
     * @var boolean
     */
    protected $fileUploadSupport = false;
    /**
     * Default options for curl.
     */
    public static $CURL_OPTS = NULL;
    /**
     * List of query parameters that get automatically dropped when rebuilding
     * the current URL.
     */
    protected static $DROP_QUERY_PARAMS = ["code", "state", "signed_request"];
    /**
     * Maps aliases to Facebook domains.
     */
    public static $DOMAIN_MAP = ["api" => "https://api.facebook.com/", "api_video" => "https://api-video.facebook.com/", "api_read" => "https://api-read.facebook.com/", "graph" => "https://graph.facebook.com/", "graph_video" => "https://graph-video.facebook.com/", "www" => "https://www.facebook.com/"];
    const VERSION = "3.1.1";
    public function __construct($config)
    {
        $this->setAppId($config["appId"]);
        $this->setAppSecret($config["secret"]);
        if (isset($config["fileUpload"])) {
            $this->setFileUploadSupport($config["fileUpload"]);
        }
        $state = $this->getPersistentData("state");
        if (!empty($state)) {
            $this->state = $this->getPersistentData("state");
        }
    }
    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }
    public function getAppId()
    {
        return $this->appId;
    }
    public function setApiSecret($apiSecret)
    {
        $this->setAppSecret($apiSecret);
        return $this;
    }
    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
        return $this;
    }
    public function getApiSecret()
    {
        return $this->getAppSecret();
    }
    public function getAppSecret()
    {
        return $this->appSecret;
    }
    public function setFileUploadSupport($fileUploadSupport)
    {
        $this->fileUploadSupport = $fileUploadSupport;
        return $this;
    }
    public function getFileUploadSupport()
    {
        return $this->fileUploadSupport;
    }
    public function useFileUploadSupport()
    {
        return $this->getFileUploadSupport();
    }
    public function setAccessToken($access_token)
    {
        $this->accessToken = $access_token;
        return $this;
    }
    public function getAccessToken()
    {
        if ($this->accessToken !== NULL) {
            return $this->accessToken;
        }
        $this->setAccessToken($this->getApplicationAccessToken());
        $user_access_token = $this->getUserAccessToken();
        if ($user_access_token) {
            $this->setAccessToken($user_access_token);
        }
        return $this->accessToken;
    }
    protected function getUserAccessToken()
    {
        $signed_request = $this->getSignedRequest();
        if ($signed_request) {
            if (array_key_exists("oauth_token", $signed_request)) {
                $access_token = $signed_request["oauth_token"];
                $this->setPersistentData("access_token", $access_token);
                return $access_token;
            }
            if (array_key_exists("code", $signed_request)) {
                $code = $signed_request["code"];
                $access_token = $this->getAccessTokenFromCode($code, "");
                if ($access_token) {
                    $this->setPersistentData("code", $code);
                    $this->setPersistentData("access_token", $access_token);
                    return $access_token;
                }
            }
            $this->clearAllPersistentData();
            return false;
        }
        $code = $this->getCode();
        if ($code && $code != $this->getPersistentData("code")) {
            $access_token = $this->getAccessTokenFromCode($code);
            if ($access_token) {
                $this->setPersistentData("code", $code);
                $this->setPersistentData("access_token", $access_token);
                return $access_token;
            }
            $this->clearAllPersistentData();
            return false;
        }
        return $this->getPersistentData("access_token");
    }
    public function getSignedRequest()
    {
        if (!$this->signedRequest) {
            if (isset($_REQUEST["signed_request"])) {
                $this->signedRequest = $this->parseSignedRequest($_REQUEST["signed_request"]);
            } else {
                if (isset($_COOKIE[$this->getSignedRequestCookieName()])) {
                    $this->signedRequest = $this->parseSignedRequest($_COOKIE[$this->getSignedRequestCookieName()]);
                }
            }
        }
        return $this->signedRequest;
    }
    public function getUser()
    {
        if ($this->user !== NULL) {
            return $this->user;
        }
        return $this->user = $this->getUserFromAvailableData();
    }
    protected function getUserFromAvailableData()
    {
        $signed_request = $this->getSignedRequest();
        if ($signed_request) {
            if (array_key_exists("user_id", $signed_request)) {
                $user = $signed_request["user_id"];
                $this->setPersistentData("user_id", $signed_request["user_id"]);
                return $user;
            }
            $this->clearAllPersistentData();
            return 0;
        }
        $user = $this->getPersistentData("user_id", $default = 0);
        $persisted_access_token = $this->getPersistentData("access_token");
        $access_token = $this->getAccessToken();
        if ($access_token && $access_token != $this->getApplicationAccessToken() && !($user && $persisted_access_token == $access_token)) {
            $user = $this->getUserFromAccessToken();
            if ($user) {
                $this->setPersistentData("user_id", $user);
            } else {
                $this->clearAllPersistentData();
            }
        }
        return $user;
    }
    public function getLoginUrl($params = [])
    {
        $this->establishCSRFTokenState();
        $currentUrl = $this->getCurrentUrl();
        $scopeParams = isset($params["scope"]) ? $params["scope"] : NULL;
        if ($scopeParams && is_array($scopeParams)) {
            $params["scope"] = implode(",", $scopeParams);
        }
        return $this->getUrl("www", "dialog/oauth", array_merge(["client_id" => $this->getAppId(), "redirect_uri" => $currentUrl, "state" => $this->state], $params));
    }
    public function getLogoutUrl($params = [])
    {
        return $this->getUrl("www", "logout.php", array_merge(["next" => $this->getCurrentUrl(), "access_token" => $this->getAccessToken()], $params));
    }
    public function getLoginStatusUrl($params = [])
    {
        return $this->getUrl("www", "extern/login_status.php", array_merge(["api_key" => $this->getAppId(), "no_session" => $this->getCurrentUrl(), "no_user" => $this->getCurrentUrl(), "ok_session" => $this->getCurrentUrl(), "session_version" => 3], $params));
    }
    public function api()
    {
        $args = func_get_args();
        if (is_array($args[0])) {
            return $this->_restserver($args[0]);
        }
        return call_user_func_array([$this, "_graph"], $args);
    }
    protected function getSignedRequestCookieName()
    {
        return "fbsr_" . $this->getAppId();
    }
    protected function getMetadataCookieName()
    {
        return "fbm_" . $this->getAppId();
    }
    protected function getCode()
    {
        if (isset($_REQUEST["code"])) {
            if ($this->state !== NULL && isset($_REQUEST["state"]) && $this->state === $_REQUEST["state"]) {
                $this->state = NULL;
                $this->clearPersistentData("state");
                return $_REQUEST["code"];
            }
            self::errorLog("CSRF state token does not match one provided.");
            return false;
        }
        return false;
    }
    protected function getUserFromAccessToken()
    {
        try {
            $user_info = $this->api("/me");
            return $user_info["id"];
        } catch (FacebookApiException $e) {
            return 0;
        }
    }
    protected function getApplicationAccessToken()
    {
        return $this->appId . "|" . $this->appSecret;
    }
    protected function establishCSRFTokenState()
    {
        if ($this->state === NULL) {
            $this->state = md5(uniqid(mt_rand(), true));
            $this->setPersistentData("state", $this->state);
        }
    }
    protected function getAccessTokenFromCode($code, $redirect_uri = NULL)
    {
        if (empty($code)) {
            return false;
        }
        if ($redirect_uri === NULL) {
            $redirect_uri = $this->getCurrentUrl();
        }
        try {
            $access_token_response = $this->_oauthRequest($this->getUrl("graph", "/oauth/access_token"), $params = ["client_id" => $this->getAppId(), "client_secret" => $this->getAppSecret(), "redirect_uri" => $redirect_uri, "code" => $code]);
        } catch (FacebookApiException $e) {
            return false;
        }
        if (empty($access_token_response)) {
            return false;
        }
        $response_params = [];
        parse_str($access_token_response, $response_params);
        if (!isset($response_params["access_token"])) {
            return false;
        }
        return $response_params["access_token"];
    }
    protected function _restserver($params)
    {
        $params["api_key"] = $this->getAppId();
        $params["format"] = "json-strings";
        $result = json_decode($this->_oauthRequest($this->getApiUrl($params["method"]), $params), true);
        if (is_array($result) && isset($result["error_code"])) {
            $this->throwAPIException($result);
        }
        if ($params["method"] === "auth.expireSession" || $params["method"] === "auth.revokeAuthorization") {
            $this->destroySession();
        }
        return $result;
    }
    protected function isVideoPost($path, $method = "GET")
    {
        if ($method == "POST" && preg_match("/^(\\/)(.+)(\\/)(videos)\$/", $path)) {
            return true;
        }
        return false;
    }
    protected function _graph($path, $method = "GET", $params = [])
    {
        if (is_array($method) && empty($params)) {
            $params = $method;
            $method = "GET";
        }
        $params["method"] = $method;
        if ($this->isVideoPost($path, $method)) {
            $domainKey = "graph_video";
        } else {
            $domainKey = "graph";
        }
        $result = json_decode($this->_oauthRequest($this->getUrl($domainKey, $path), $params), true);
        if (is_array($result) && isset($result["error"])) {
            $this->throwAPIException($result);
        }
        return $result;
    }
    protected function _oauthRequest($url, $params)
    {
        if (!isset($params["access_token"])) {
            $params["access_token"] = $this->getAccessToken();
        }
        foreach ($params as $key => $value) {
            if (!is_string($value)) {
                $params[$key] = json_encode($value);
            }
        }
        return $this->makeRequest($url, $params);
    }
    protected function makeRequest($url, $params, $ch = NULL)
    {
        if (!$ch) {
            $ch = curl_init();
        }
        $opts = self::$CURL_OPTS;
        if ($this->getFileUploadSupport()) {
            $opts[CURLOPT_POSTFIELDS] = $params;
        } else {
            $opts[CURLOPT_POSTFIELDS] = http_build_query($params, NULL, "&");
        }
        $opts[CURLOPT_URL] = $url;
        if (isset($opts[CURLOPT_HTTPHEADER])) {
            $existing_headers = $opts[CURLOPT_HTTPHEADER];
            $existing_headers[] = "Expect:";
            $opts[CURLOPT_HTTPHEADER] = $existing_headers;
        } else {
            $opts[CURLOPT_HTTPHEADER] = ["Expect:"];
        }
        curl_setopt_array($ch, $opts);
        $result = curl_exec($ch);
        if (curl_errno($ch) == 60) {
            self::errorLog("Invalid or no certificate authority found, using bundled information");
            curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/fb_ca_chain_bundle.crt");
            $result = curl_exec($ch);
        }
        if ($result === false) {
            $e = new FacebookApiException(["error_code" => curl_errno($ch), "error" => ["message" => curl_error($ch), "type" => "CurlException"]]);
            curl_close($ch);
            throw $e;
        }
        curl_close($ch);
        return $result;
    }
    protected function parseSignedRequest($signed_request)
    {
        list($encoded_sig, $payload) = explode(".", $signed_request, 2);
        $sig = self::base64UrlDecode($encoded_sig);
        $data = json_decode(self::base64UrlDecode($payload), true);
        if (strtoupper($data["algorithm"]) !== "HMAC-SHA256") {
            self::errorLog("Unknown algorithm. Expected HMAC-SHA256");
        } else {
            $expected_sig = hash_hmac("sha256", $payload, $this->getAppSecret(), $raw = true);
            if ($sig !== $expected_sig) {
                self::errorLog("Bad Signed JSON signature!");
            } else {
                return $data;
            }
        }
    }
    protected function getApiUrl($method)
    {
        $name = "api";
        if (isset($READ_ONLY_CALLS[strtolower($method)])) {
            $name = "api_read";
        } else {
            if (strtolower($method) == "video.upload") {
                $name = "api_video";
            }
        }
        return self::getUrl($name, "restserver.php");
    }
    protected function getUrl($name, $path = "", $params = [])
    {
        $url = self::$DOMAIN_MAP[$name];
        if ($path) {
            if ($path[0] === "/") {
                $path = substr($path, 1);
            }
            $url .= $path;
        }
        if ($params) {
            $url .= "?" . http_build_query($params, NULL, "&");
        }
        return $url;
    }
    protected function getCurrentUrl()
    {
        if (isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on" || $_SERVER["HTTPS"] == 1) || isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) && $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https") {
            $protocol = "https://";
        } else {
            $protocol = "http://";
        }
        $currentUrl = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $parts = parse_url($currentUrl);
        $query = "";
        if (!empty($parts["query"])) {
            $params = explode("&", $parts["query"]);
            $retained_params = [];
            foreach ($params as $param) {
                if ($this->shouldRetainParam($param)) {
                    $retained_params[] = $param;
                }
            }
            if (!empty($retained_params)) {
                $query = "?" . implode($retained_params, "&");
            }
        }
        $port = isset($parts["port"]) && ($protocol === "http://" && $parts["port"] !== 80 || $protocol === "https://" && $parts["port"] !== 443) ? ":" . $parts["port"] : "";
        return $protocol . $parts["host"] . $port . $parts["path"] . $query;
    }
    protected function shouldRetainParam($param)
    {
        foreach (self::$DROP_QUERY_PARAMS as $drop_query_param) {
            if (strpos($param, $drop_query_param . "=") === 0) {
                return false;
            }
        }
        return true;
    }
    protected function throwAPIException($result)
    {
        $e = new FacebookApiException($result);
        $e->getType();
        switch ($e->getType()) {
            case "OAuthException":
            case "invalid_token":
            case "Exception":
                $message = $e->getMessage();
                if (strpos($message, "Error validating access token") !== false || strpos($message, "Invalid OAuth access token") !== false || strpos($message, "An active access token must be used") !== false) {
                    $this->destroySession();
                }
                break;
            default:
                throw $e;
        }
    }
    protected static function errorLog($msg)
    {
        if (php_sapi_name() != "cli") {
            error_log($msg);
        }
    }
    protected static function base64UrlDecode($input)
    {
        return base64_decode(strtr($input, "-_", "+/"));
    }
    public function destroySession()
    {
        $this->accessToken = NULL;
        $this->signedRequest = NULL;
        $this->user = NULL;
        $this->clearAllPersistentData();
        $cookie_name = $this->getSignedRequestCookieName();
        if (array_key_exists($cookie_name, $_COOKIE)) {
            unset($_COOKIE[$cookie_name]);
            if (!headers_sent()) {
                $base_domain = "." . $_SERVER["HTTP_HOST"];
                $metadata = $this->getMetadataCookie();
                if (array_key_exists("base_domain", $metadata) && !empty($metadata["base_domain"])) {
                    $base_domain = $metadata["base_domain"];
                }
                setcookie($cookie_name, "", 0, "/", $base_domain);
            } else {
                self::errorLog("There exists a cookie that we wanted to clear that we couldn't clear because headers was already sent. Make sure to do the first API call before outputing anything");
            }
        }
    }
    protected function getMetadataCookie()
    {
        $cookie_name = $this->getMetadataCookieName();
        if (!array_key_exists($cookie_name, $_COOKIE)) {
            return [];
        }
        $cookie_value = trim($_COOKIE[$cookie_name], "\"");
        if (empty($cookie_value)) {
            return [];
        }
        $parts = explode("&", $cookie_value);
        $metadata = [];
        foreach ($parts as $part) {
            $pair = explode("=", $part, 2);
            if (!empty($pair[0])) {
                $metadata[urldecode($pair[0])] = 1 < count($pair) ? urldecode($pair[1]) : "";
            }
        }
        return $metadata;
    }
    protected abstract function setPersistentData($key, $value);
    protected abstract function getPersistentData($key, $default);
    protected abstract function clearPersistentData($key);
    protected abstract function clearAllPersistentData();
}

?>