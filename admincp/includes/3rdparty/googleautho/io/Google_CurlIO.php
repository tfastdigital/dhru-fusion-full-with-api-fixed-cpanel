<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "Google_CacheParser.php";
/**
 * Curl based implementation of apiIO.
 *
 * @author Chris Chabot <chabotc@google.com>
 * @author Chirag Shah <chirags@google.com>
 */
class Google_CurlIO implements Google_IO
{
    private $curlParams = NULL;
    private static $ENTITY_HTTP_METHODS = ["POST" => NULL, "PUT" => NULL];
    private static $HOP_BY_HOP = ["connection", "keep-alive", "proxy-authenticate", "proxy-authorization", "te", "trailers", "transfer-encoding", "upgrade"];
    const CONNECTION_ESTABLISHED = "HTTP/1.0 200 Connection established\r\n\r\n";
    const FORM_URLENCODED = "application/x-www-form-urlencoded";
    public function authenticatedRequest(Google_HttpRequest $request)
    {
        $request = Google_Client::$auth->sign($request);
        return $this->makeRequest($request);
    }
    public function makeRequest(Google_HttpRequest $request)
    {
        $cached = $this->getCachedRequest($request);
        if ($cached !== false) {
            if (Google_CacheParser::mustRevalidate($cached)) {
                $addHeaders = [];
                if ($cached->getResponseHeader("etag")) {
                    $addHeaders["If-None-Match"] = $cached->getResponseHeader("etag");
                } else {
                    if ($cached->getResponseHeader("date")) {
                        $addHeaders["If-Modified-Since"] = $cached->getResponseHeader("date");
                    }
                }
                $request->setRequestHeaders($addHeaders);
            } else {
                return $cached;
            }
        }
        if (array_key_exists($request->getRequestMethod(), self::$ENTITY_HTTP_METHODS)) {
            $request = $this->processEntityRequest($request);
        }
        $ch = curl_init();
        curl_setopt_array($ch, $this->curlParams);
        curl_setopt($ch, CURLOPT_URL, $request->getUrl());
        if ($request->getPostBody()) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getPostBody());
        }
        $requestHeaders = $request->getRequestHeaders();
        if ($requestHeaders && is_array($requestHeaders)) {
            $parsed = [];
            foreach ($requestHeaders as $k => $v) {
                $parsed[] = $k . ": " . $v;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $parsed);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request->getRequestMethod());
        curl_setopt($ch, CURLOPT_USERAGENT, $request->getUserAgent());
        $respData = curl_exec($ch);
        if (curl_errno($ch) == CURLE_SSL_CACERT) {
            error_log("SSL certificate problem, verify that the CA cert is OK. Retrying with the CA cert bundle from google-api-php-client.");
            curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/cacerts.pem");
            $respData = curl_exec($ch);
        }
        $respHeaderSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $respHttpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrorNum = curl_errno($ch);
        $curlError = curl_error($ch);
        curl_close($ch);
        if ($curlErrorNum != CURLE_OK) {
            throw new Google_IOException("HTTP Error: (" . $respHttpCode . ") " . $curlError);
        }
        list($responseHeaders, $responseBody) = self::parseHttpResponse($respData, $respHeaderSize);
        if ($respHttpCode == 304 && $cached) {
            if (isset($responseHeaders["connection"])) {
                $hopByHop = array_merge(self::$HOP_BY_HOP, explode(",", $responseHeaders["connection"]));
                $endToEnd = [];
                foreach ($hopByHop as $key) {
                    if (isset($responseHeaders[$key])) {
                        $endToEnd[$key] = $responseHeaders[$key];
                    }
                }
                $cached->setResponseHeaders($endToEnd);
            }
            return $cached;
        } else {
            $request->setResponseHttpCode($respHttpCode);
            $request->setResponseHeaders($responseHeaders);
            $request->setResponseBody($responseBody);
            $this->setCachedRequest($request);
            return $request;
        }
    }
    public function setCachedRequest(Google_HttpRequest $request)
    {
        if (Google_CacheParser::isResponseCacheable($request)) {
            Google_Client::$cache->set($request->getCacheKey(), $request);
            return true;
        }
        return false;
    }
    public function getCachedRequest(Google_HttpRequest $request)
    {
        if (!Google_CacheParser::isRequestCacheable($request)) {
        }
        return Google_Client::$cache->get($request->getCacheKey());
    }
    public static function parseHttpResponse($respData, $headerSize)
    {
        if (stripos($respData, "HTTP/1.0 200 Connection established\r\n\r\n") !== false) {
            $respData = str_ireplace("HTTP/1.0 200 Connection established\r\n\r\n", "", $respData);
        }
        if ($headerSize) {
            $responseBody = substr($respData, $headerSize);
            $responseHeaders = substr($respData, 0, $headerSize);
        } else {
            list($responseHeaders, $responseBody) = explode("\r\n\r\n", $respData, 2);
        }
        $responseHeaders = self::parseResponseHeaders($responseHeaders);
        return [$responseHeaders, $responseBody];
    }
    public static function parseResponseHeaders($rawHeaders)
    {
        $responseHeaders = [];
        $responseHeaderLines = explode("\r\n", $rawHeaders);
        foreach ($responseHeaderLines as $headerLine) {
            if ($headerLine && strpos($headerLine, ":") !== false) {
                list($header, $value) = explode(": ", $headerLine, 2);
                $header = strtolower($header);
                if (isset($responseHeaders[$header])) {
                    $responseHeaders[$header] .= "\n" . $value;
                } else {
                    $responseHeaders[$header] = $value;
                }
            }
        }
        return $responseHeaders;
    }
    public function processEntityRequest(Google_HttpRequest $request)
    {
        $postBody = $request->getPostBody();
        $contentType = $request->getRequestHeader("content-type");
        if (!$contentType) {
            $contentType = "application/x-www-form-urlencoded";
            $request->setRequestHeaders(["content-type" => $contentType]);
        }
        if ($contentType == "application/x-www-form-urlencoded" && is_array($postBody)) {
            $postBody = http_build_query($postBody, "", "&");
            $request->setPostBody($postBody);
        }
        if (!$postBody || is_string($postBody)) {
            $postsLength = strlen($postBody);
            $request->setRequestHeaders(["content-length" => $postsLength]);
        }
        return $request;
    }
    public function setOptions($optCurlParams)
    {
        foreach ($optCurlParams as $key => $val) {
            $this->curlParams[$key] = $val;
        }
    }
}

?>