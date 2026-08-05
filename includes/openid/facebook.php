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
 * Provides access to the Facebook Platform.
 *
 * @author Naitik Shah <naitik@facebook.com>
 */
class Facebook
{
    /**
     * The Application ID.
     */
    protected $appId = NULL;
    /**
     * The Application API Secret.
     */
    protected $apiSecret = NULL;
    /**
     * The active user session, if one is available.
     */
    protected $session = NULL;
    /**
     * The data from the signed_request token.
     */
    protected $signedRequest = NULL;
    /**
     * Indicates that we already loaded the session as best as we could.
     */
    protected $sessionLoaded = false;
    /**
     * Indicates if Cookie support should be enabled.
     */
    protected $cookieSupport = false;
    /**
     * Base domain for the Cookie.
     */
    protected $baseDomain = "";
    /**
     * Indicates if the CURL based @ syntax for file uploads is enabled.
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
    protected static $DROP_QUERY_PARAMS = ["session", "signed_request"];
    /**
     * Maps aliases to Facebook domains.
     */
    public static $DOMAIN_MAP = ["api" => "https://api.facebook.com/", "api_read" => "https://api-read.facebook.com/", "graph" => "https://graph.facebook.com/", "www" => "https://www.facebook.com/"];
    const VERSION = "2.1.2";
    public function __construct($config)
    {
        $this->setAppId($config["appId"]);
        $this->setApiSecret($config["secret"]);
        if (isset($config["cookie"])) {
            $this->setCookieSupport($config["cookie"]);
        }
        if (isset($config["domain"])) {
            $this->setBaseDomain($config["domain"]);
        }
        if (isset($config["fileUpload"])) {
            $this->setFileUploadSupport($config["fileUpload"]);
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
        $this->apiSecret = $apiSecret;
        return $this;
    }
    public function getApiSecret()
    {
        return $this->apiSecret;
    }
    public function setCookieSupport($cookieSupport)
    {
        $this->cookieSupport = $cookieSupport;
        return $this;
    }
    public function useCookieSupport()
    {
        return $this->cookieSupport;
    }
    public function setBaseDomain($domain)
    {
        $this->baseDomain = $domain;
        return $this;
    }
    public function getBaseDomain()
    {
        return $this->baseDomain;
    }
    public function setFileUploadSupport($fileUploadSupport)
    {
        $this->fileUploadSupport = $fileUploadSupport;
        return $this;
    }
    public function useFileUploadSupport()
    {
        return $this->fileUploadSupport;
    }
    public function getSignedRequest()
    {
        if (!$this->signedRequest && isset($_REQUEST["signed_request"])) {
            $this->signedRequest = $this->parseSignedRequest($_REQUEST["signed_request"]);
        }
        return $this->signedRequest;
    }
    public function setSession($session = NULL, $write_cookie = true)
    {
        $session = $this->validateSessionObject($session);
        $this->sessionLoaded = true;
        $this->session = $session;
        if ($write_cookie) {
            $this->setCookieFromSession($session);
        }
        return $this;
    }
    public function getSession()
    {
        if (!$this->sessionLoaded) {
            $session = NULL;
            $write_cookie = true;
            $signedRequest = $this->getSignedRequest();
            if ($signedRequest) {
                $session = $this->createSessionFromSignedRequest($signedRequest);
            }
            if (!$session && isset($_REQUEST["session"])) {
                $session = json_decode(get_magic_quotes_gpc() ? stripslashes($_REQUEST["session"]) : $_REQUEST["session"], true);
                $session = $this->validateSessionObject($session);
            }
            if (!$session && $this->useCookieSupport()) {
                $cookieName = $this->getSessionCookieName();
                if (isset($_COOKIE[$cookieName])) {
                    $session = [];
                    parse_str(trim(get_magic_quotes_gpc() ? stripslashes($_COOKIE[$cookieName]) : $_COOKIE[$cookieName], "\""), $session);
                    $session = $this->validateSessionObject($session);
                    $write_cookie = empty($session);
                }
            }
            $this->setSession($session, $write_cookie);
        }
        return $this->session;
    }
    public function getUser()
    {
        $session = $this->getSession();
        return $session ? $session["uid"] : NULL;
    }
    public function getAccessToken()
    {
        $session = $this->getSession();
        if ($session) {
            return $session["access_token"];
        }
        return $this->getAppId() . "|" . $this->getApiSecret();
    }
    public function getLoginUrl($params = [])
    {
        $currentUrl = $this->getCurrentUrl();
        return $this->getUrl("www", "login.php", array_merge(["api_key" => $this->getAppId(), "cancel_url" => $currentUrl, "display" => "page", "fbconnect" => 1, "next" => $currentUrl, "return_session" => 1, "session_version" => 3, "v" => "1.0"], $params));
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
    protected function _restserver($params)
    {
        $params["api_key"] = $this->getAppId();
        $params["format"] = "json-strings";
        $result = json_decode($this->_oauthRequest($this->getApiUrl($params["method"]), $params), true);
        if (is_array($result) && isset($result["error_code"])) {
            throw new FacebookApiException($result);
        }
        return $result;
    }
    protected function _graph($path, $method = "GET", $params = [])
    {
        while (is_array($method) && empty($params)) {
            $params = $method;
            $method = "GET";
        }
        $params["method"] = $method;
        $result = json_decode($this->_oauthRequest($this->getUrl("graph", $path), $params), true);
        if (is_array($result) && isset($result["error"])) {
            $e = new FacebookApiException($result);
            $e->getType();
            switch ($e->getType()) {
                case "OAuthException":
                case "invalid_token":
                    $this->setSession(NULL);
                    break;
                default:
                    throw $e;
            }
        } else {
            return $result;
        }
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
        if ($this->useFileUploadSupport()) {
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
    protected function getSessionCookieName()
    {
        return "fbs_" . $this->getAppId();
    }
    protected function setCookieFromSession($session = NULL)
    {
        if (!$this->useCookieSupport()) {
            return NULL;
        }
        $cookieName = $this->getSessionCookieName();
        $value = "deleted";
        $expires = time() - 3600;
        $domain = $this->getBaseDomain();
        if ($session) {
            $value = "\"" . http_build_query($session, NULL, "&") . "\"";
            if (isset($session["base_domain"])) {
                $domain = $session["base_domain"];
            }
            $expires = $session["expires"];
        }
        if ($domain) {
            $domain = "." . $domain;
        }
        if ($value == "deleted" && empty($_COOKIE[$cookieName])) {
            return NULL;
        }
        if (headers_sent()) {
            self::errorLog("Could not set cookie. Headers already sent.");
        } else {
            setcookie($cookieName, $value, $expires, "/", $domain);
        }
    }
    protected function validateSessionObject($session)
    {
        if (is_array($session) && isset($session["uid"]) && isset($session["access_token"]) && isset($session["sig"])) {
            $session_without_sig = $session;
            unset($session_without_sig["sig"]);
            $expected_sig = self::generateSignature($session_without_sig, $this->getApiSecret());
            if ($session["sig"] != $expected_sig) {
                self::errorLog("Got invalid session signature in cookie.");
                $session = NULL;
            }
        } else {
            $session = NULL;
        }
        return $session;
    }
    protected function createSessionFromSignedRequest($data)
    {
        if (!isset($data["oauth_token"])) {
            return NULL;
        }
        $session = ["uid" => $data["user_id"], "access_token" => $data["oauth_token"], "expires" => $data["expires"]];
        $session["sig"] = self::generateSignature($session, $this->getApiSecret());
        return $session;
    }
    protected function parseSignedRequest($signed_request)
    {
        list($encoded_sig, $payload) = explode(".", $signed_request, 2);
        $sig = self::base64UrlDecode($encoded_sig);
        $data = json_decode(self::base64UrlDecode($payload), true);
        if (strtoupper($data["algorithm"]) !== "HMAC-SHA256") {
            self::errorLog("Unknown algorithm. Expected HMAC-SHA256");
        } else {
            $expected_sig = hash_hmac("sha256", $payload, $this->getApiSecret(), $raw = true);
            if ($sig !== $expected_sig) {
                self::errorLog("Bad Signed JSON signature!");
            } else {
                return $data;
            }
        }
    }
    protected function getApiUrl($method)
    {
        static $READ_ONLY_CALLS = ["admin.getallocation" => 1, "admin.getappproperties" => 1, "admin.getbannedusers" => 1, "admin.getlivestreamvialink" => 1, "admin.getmetrics" => 1, "admin.getrestrictioninfo" => 1, "application.getpublicinfo" => 1, "auth.getapppublickey" => 1, "auth.getsession" => 1, "auth.getsignedpublicsessiondata" => 1, "comments.get" => 1, "connect.getunconnectedfriendscount" => 1, "dashboard.getactivity" => 1, "dashboard.getcount" => 1, "dashboard.getglobalnews" => 1, "dashboard.getnews" => 1, "dashboard.multigetcount" => 1, "dashboard.multigetnews" => 1, "data.getcookies" => 1, "events.get" => 1, "events.getmembers" => 1, "fbml.getcustomtags" => 1, "feed.getappfriendstories" => 1, "feed.getregisteredtemplatebundlebyid" => 1, "feed.getregisteredtemplatebundles" => 1, "fql.multiquery" => 1, "fql.query" => 1, "friends.arefriends" => 1, "friends.get" => 1, "friends.getappusers" => 1, "friends.getlists" => 1, "friends.getmutualfriends" => 1, "gifts.get" => 1, "groups.get" => 1, "groups.getmembers" => 1, "intl.gettranslations" => 1, "links.get" => 1, "notes.get" => 1, "notifications.get" => 1, "pages.getinfo" => 1, "pages.isadmin" => 1, "pages.isappadded" => 1, "pages.isfan" => 1, "permissions.checkavailableapiaccess" => 1, "permissions.checkgrantedapiaccess" => 1, "photos.get" => 1, "photos.getalbums" => 1, "photos.gettags" => 1, "profile.getinfo" => 1, "profile.getinfooptions" => 1, "stream.get" => 1, "stream.getcomments" => 1, "stream.getfilters" => 1, "users.getinfo" => 1, "users.getloggedinuser" => 1, "users.getstandardinfo" => 1, "users.hasapppermission" => 1, "users.isappuser" => 1, "users.isverified" => 1, "video.getuploadlimits" => 1];
        $name = "api";
        if (isset($READ_ONLY_CALLS[strtolower($method)])) {
            $name = "api_read";
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
        $protocol = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ? "https://" : "http://";
        $currentUrl = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $parts = parse_url($currentUrl);
        $query = "";
        if (!empty($parts["query"])) {
            $params = [];
            parse_str($parts["query"], $params);
            foreach (self::$DROP_QUERY_PARAMS as $key) {
                unset($params[$key]);
            }
            if (!empty($params)) {
                $query = "?" . http_build_query($params, NULL, "&");
            }
        }
        $port = isset($parts["port"]) && ($protocol === "http://" && $parts["port"] !== 80 || $protocol === "https://" && $parts["port"] !== 443) ? ":" . $parts["port"] : "";
        return $protocol . $parts["host"] . $port . $parts["path"] . $query;
    }
    protected static function generateSignature($params, $secret)
    {
        ksort($params);
        $base_string = "";
        foreach ($params as $key => $value) {
            $base_string .= $key . "=" . $value;
        }
        $base_string .= $secret;
        return md5($base_string);
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
}

?>