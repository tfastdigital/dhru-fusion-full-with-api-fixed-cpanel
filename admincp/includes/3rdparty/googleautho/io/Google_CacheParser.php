<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Implement the caching directives specified in rfc2616. This
 * implementation is guided by the guidance offered in rfc2616-sec13.
 * @author Chirag Shah <chirags@google.com>
 */
class Google_CacheParser
{
    public static $CACHEABLE_STATUS_CODES = ["200", "203", "300", "301"];
    public static $CACHEABLE_HTTP_METHODS = ["GET", "HEAD"];
    private function __construct()
    {
    }
    public static function isRequestCacheable(Google_HttpRequest $resp)
    {
        $method = $resp->getRequestMethod();
        if (!in_array($method, self::$CACHEABLE_HTTP_METHODS)) {
            return false;
        }
        if ($resp->getRequestHeader("authorization")) {
            return false;
        }
        return true;
    }
    public static function isResponseCacheable(Google_HttpRequest $resp)
    {
        if (!self::isRequestCacheable($resp)) {
            return false;
        }
        $code = $resp->getResponseHttpCode();
        if (!in_array($code, self::$CACHEABLE_STATUS_CODES)) {
            return false;
        }
        $etag = $resp->getResponseHeader("etag");
        if (self::isExpired($resp) && !$etag) {
            return false;
        }
        $cacheControl = $resp->getParsedCacheControl();
        if (isset($cacheControl["no-store"])) {
            return false;
        }
        $pragma = $resp->getResponseHeader("pragma");
        if ($pragma == "no-cache" || strpos($pragma, "no-cache") !== false) {
            return false;
        }
        $vary = $resp->getResponseHeader("vary");
        if ($vary) {
            return false;
        }
        return true;
    }
    public static function isExpired(Google_HttpRequest $resp)
    {
        $parsedExpires = false;
        $responseHeaders = $resp->getResponseHeaders();
        if (isset($responseHeaders["expires"])) {
            $rawExpires = $responseHeaders["expires"];
            if (empty($rawExpires) || is_numeric($rawExpires) && $rawExpires <= 0) {
                return true;
            }
            $parsedExpires = strtotime($rawExpires);
            if (!$parsedExpires || $parsedExpires <= 0) {
                return true;
            }
        }
        $freshnessLifetime = false;
        $cacheControl = $resp->getParsedCacheControl();
        if (isset($cacheControl["max-age"])) {
            $freshnessLifetime = $cacheControl["max-age"];
        }
        $rawDate = $resp->getResponseHeader("date");
        $parsedDate = strtotime($rawDate);
        if (empty($rawDate) || !$parsedDate) {
            $parsedDate = time();
        }
        if (!$freshnessLifetime && isset($responseHeaders["expires"])) {
            $freshnessLifetime = $parsedExpires - $parsedDate;
        }
        if (!$freshnessLifetime) {
            return true;
        }
        $age = max(0, time() - $parsedDate);
        if (isset($responseHeaders["age"])) {
            $age = max($age, strtotime($responseHeaders["age"]));
        }
        return $freshnessLifetime <= $age;
    }
    public static function mustRevalidate(Google_HttpRequest $response)
    {
        return self::isExpired($response);
    }
}

?>