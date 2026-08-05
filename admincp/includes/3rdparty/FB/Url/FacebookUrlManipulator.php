<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Url;

/**
 * Class FacebookUrlManipulator
 *
 * @package Facebook
 */
class FacebookUrlManipulator
{
    public static function removeParamsFromUrl($url, $paramsToFilter)
    {
        $parts = parse_url($url);
        $query = "";
        if (isset($parts["query"])) {
            $params = [];
            parse_str($parts["query"], $params);
            foreach ($paramsToFilter as $paramName) {
                unset($params[$paramName]);
            }
            if (0 < count($params)) {
                $query = "?" . http_build_query($params, NULL, "&");
            }
        }
        $scheme = isset($parts["scheme"]) ? $parts["scheme"] . "://" : "";
        $host = isset($parts["host"]) ? $parts["host"] : "";
        $port = isset($parts["port"]) ? ":" . $parts["port"] : "";
        $path = isset($parts["path"]) ? $parts["path"] : "";
        $fragment = isset($parts["fragment"]) ? "#" . $parts["fragment"] : "";
        return $scheme . $host . $port . $path . $query . $fragment;
    }
    public static function appendParamsToUrl($url, $newParams = [])
    {
        if (!$newParams) {
            return $url;
        }
        if (strpos($url, "?") === false) {
            return $url . "?" . http_build_query($newParams, NULL, "&");
        }
        list($path, $query) = explode("?", $url, 2);
        $existingParams = [];
        parse_str($query, $existingParams);
        $newParams = array_merge($newParams, $existingParams);
        ksort($newParams);
        return $path . "?" . http_build_query($newParams, NULL, "&");
    }
    public static function getParamsAsArray($url)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if (!$query) {
            return [];
        }
        $params = [];
        parse_str($query, $params);
        return $params;
    }
    public static function mergeUrlParams($urlToStealFrom, $urlToAddTo)
    {
        $newParams = static::getParamsAsArray($urlToStealFrom);
        if (!$newParams) {
            return $urlToAddTo;
        }
        return static::appendParamsToUrl($urlToAddTo, $newParams);
    }
    public static function forceSlashPrefix($string)
    {
        if (!$string) {
            return $string;
        }
        return strpos($string, "/") === 0 ? $string : "/" . $string;
    }
    public static function baseGraphUrlEndpoint($urlToTrim)
    {
        return "/" . preg_replace("/^https:\\/\\/.+\\.facebook\\.com(\\/v.+?)?\\//", "", $urlToTrim);
    }
}

?>