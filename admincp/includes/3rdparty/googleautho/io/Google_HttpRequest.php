<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * HTTP Request to be executed by apiIO classes. Upon execution, the
 * responseHttpCode, responseHeaders and responseBody will be filled in.
 *
 * @author Chris Chabot <chabotc@google.com>
 * @author Chirag Shah <chirags@google.com>
 *
 */
class Google_HttpRequest
{
    private $batchHeaders = ["Content-Type" => "application/http", "Content-Transfer-Encoding" => "binary", "MIME-Version" => "1.0", "Content-Length" => ""];
    protected $url = NULL;
    protected $requestMethod = NULL;
    protected $requestHeaders = NULL;
    protected $postBody = NULL;
    protected $userAgent = NULL;
    protected $responseHttpCode = NULL;
    protected $responseHeaders = NULL;
    protected $responseBody = NULL;
    public $accessKey = NULL;
    const USER_AGENT_SUFFIX = "google-api-php-client/0.6.0";
    public function __construct($url, $method = "GET", $headers = [], $postBody = NULL)
    {
        $this->setUrl($url);
        $this->setRequestMethod($method);
        $this->setRequestHeaders($headers);
        $this->setPostBody($postBody);
        global $apiConfig;
        if (empty($apiConfig["application_name"])) {
            $this->userAgent = "google-api-php-client/0.6.0";
        } else {
            $this->userAgent = $apiConfig["application_name"] . " " . "google-api-php-client/0.6.0";
        }
    }
    public function getBaseUrl()
    {
        if ($pos = strpos($this->url, "?")) {
            return substr($this->url, 0, $pos);
        }
        return $this->url;
    }
    public function getQueryParams()
    {
        if ($pos = strpos($this->url, "?")) {
            $queryStr = substr($this->url, $pos + 1);
            $params = [];
            parse_str($queryStr, $params);
            return $params;
        }
        return [];
    }
    public function getResponseHttpCode()
    {
        return (int) $this->responseHttpCode;
    }
    public function setResponseHttpCode($responseHttpCode)
    {
        $this->responseHttpCode = $responseHttpCode;
    }
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }
    public function getResponseBody()
    {
        return $this->responseBody;
    }
    public function setResponseHeaders($headers)
    {
        $headers = Google_Utils::normalize($headers);
        if ($this->responseHeaders) {
            $headers = array_merge($this->responseHeaders, $headers);
        }
        $this->responseHeaders = $headers;
    }
    public function getResponseHeader($key)
    {
        return isset($this->responseHeaders[$key]) ? $this->responseHeaders[$key] : false;
    }
    public function setResponseBody($responseBody)
    {
        $this->responseBody = $responseBody;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }
    public function getRequestHeaders()
    {
        return $this->requestHeaders;
    }
    public function getRequestHeader($key)
    {
        return isset($this->requestHeaders[$key]) ? $this->requestHeaders[$key] : false;
    }
    public function getPostBody()
    {
        return $this->postBody;
    }
    public function setUrl($url)
    {
        if (substr($url, 0, 4) == "http") {
            $this->url = $url;
        } else {
            if (substr($url, 0, 1) !== "/") {
                $url = "/" . $url;
            }
            global $apiConfig;
            $this->url = $apiConfig["basePath"] . $url;
        }
    }
    public function setRequestMethod($method)
    {
        $this->requestMethod = strtoupper($method);
    }
    public function setRequestHeaders($headers)
    {
        $headers = Google_Utils::normalize($headers);
        if ($this->requestHeaders) {
            $headers = array_merge($this->requestHeaders, $headers);
        }
        $this->requestHeaders = $headers;
    }
    public function setPostBody($postBody)
    {
        $this->postBody = $postBody;
    }
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }
    public function getUserAgent()
    {
        return $this->userAgent;
    }
    public function getCacheKey()
    {
        $key = $this->getUrl();
        if (isset($this->accessKey)) {
            $key .= $this->accessKey;
        }
        if (isset($this->requestHeaders["authorization"])) {
            $key .= $this->requestHeaders["authorization"];
        }
        return md5($key);
    }
    public function getParsedCacheControl()
    {
        $parsed = [];
        $rawCacheControl = $this->getResponseHeader("cache-control");
        if ($rawCacheControl) {
            $rawCacheControl = str_replace(", ", "&", $rawCacheControl);
            parse_str($rawCacheControl, $parsed);
        }
        return $parsed;
    }
    public function toBatchString($id)
    {
        $str = "";
        foreach ($this->batchHeaders as $key => $val) {
            $str .= $key . ": " . $val . "\n";
        }
        $str .= "Content-ID: " . $id . "\n";
        $str .= "\n";
        $path = parse_url($this->getUrl(), PHP_URL_PATH);
        $str .= $this->getRequestMethod() . " " . $path . " HTTP/1.1\n";
        foreach ($this->getRequestHeaders() as $key => $val) {
            $str .= $key . ": " . $val . "\n";
        }
        if ($this->getPostBody()) {
            $str .= "\n";
            $str .= $this->getPostBody();
        }
        return $str;
    }
}

?>