<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect;

/**
 * ApiClient Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://squareup.com/developers
 */
class ApiClient
{
    /**
     * Configuration
     * @var Configuration
     */
    protected $config = NULL;
    /**
     * Object Serializer
     * @var ObjectSerializer
     */
    protected $serializer = NULL;
    public static $PATCH = "PATCH";
    public static $POST = "POST";
    public static $GET = "GET";
    public static $HEAD = "HEAD";
    public static $OPTIONS = "OPTIONS";
    public static $PUT = "PUT";
    public static $DELETE = "DELETE";
    public function __construct(Configuration $config = NULL)
    {
        if ($config == NULL) {
            $config = Configuration::getDefaultConfiguration();
        }
        $this->config = $config;
        $this->serializer = new ObjectSerializer();
    }
    public function getConfig()
    {
        return $this->config;
    }
    public function getSerializer()
    {
        return $this->serializer;
    }
    public function getApiKeyWithPrefix($apiKeyIdentifier)
    {
        $prefix = $this->config->getApiKeyPrefix($apiKeyIdentifier);
        $apiKey = $this->config->getApiKey($apiKeyIdentifier);
        if (!isset($apiKey)) {
            return NULL;
        }
        if (isset($prefix)) {
            $keyWithPrefix = $prefix . " " . $apiKey;
        } else {
            $keyWithPrefix = $apiKey;
        }
        return $keyWithPrefix;
    }
    public function callApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType = NULL)
    {
        $headers = [];
        $headerParams = array_merge((array) $this->config->getDefaultHeaders(), (array) $headerParams);
        foreach ($headerParams as $key => $val) {
            if (strcasecmp($key, "Authorization") == 0 && strrpos($val, "Bearer", -1 * strlen($val)) === false) {
                $headers[] = $key . ": Bearer " . $val;
            } else {
                $headers[] = $key . ": " . $val;
            }
        }
        if ($postData && in_array("Content-Type: application/x-www-form-urlencoded", $headers)) {
            $postData = http_build_query($postData);
        } else {
            if ((is_object($postData) || is_array($postData)) && !in_array("Content-Type: multipart/form-data", $headers)) {
                $postData = json_encode(ObjectSerializer::sanitizeForSerialization($postData));
            }
        }
        $url = $this->config->getHost() . $resourcePath;
        $curl = curl_init();
        if ($this->config->getCurlTimeout() != 0) {
            curl_setopt($curl, CURLOPT_TIMEOUT, $this->config->getCurlTimeout());
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        if (!$this->config->getSSLVerification()) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        }
        if (!empty($queryParams)) {
            $url = $url . "?" . http_build_query($queryParams);
        }
        if ($method == self::$POST) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        } else {
            if ($method == self::$HEAD) {
                curl_setopt($curl, CURLOPT_NOBODY, true);
            } else {
                if ($method == self::$OPTIONS) {
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "OPTIONS");
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
                } else {
                    if ($method == self::$PATCH) {
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
                    } else {
                        if ($method == self::$PUT) {
                            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
                        } else {
                            if ($method == self::$DELETE) {
                                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                                curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
                            } else {
                                if ($method != self::$GET) {
                                    throw new ApiException("Method " . $method . " is not recognized.");
                                }
                            }
                        }
                    }
                }
            }
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->config->getUserAgent());
        if ($this->config->getDebug()) {
            error_log("[DEBUG] HTTP Request body  ~BEGIN~\n" . print_r($postData, true) . "\n~END~\n", 3, $this->config->getDebugFile());
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_STDERR, fopen($this->config->getDebugFile(), "a"));
        } else {
            curl_setopt($curl, CURLOPT_VERBOSE, 0);
        }
        curl_setopt($curl, CURLOPT_HEADER, 1);
        $response = curl_exec($curl);
        $http_header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $http_header = $this->http_parse_headers(substr($response, 0, $http_header_size));
        $http_body = substr($response, $http_header_size);
        $response_info = curl_getinfo($curl);
        if ($this->config->getDebug()) {
            error_log("[DEBUG] HTTP Response body ~BEGIN~\n" . print_r($http_body, true) . "\n~END~\n", 3, $this->config->getDebugFile());
        }
        if ($response_info["http_code"] == 0) {
            $curl_error_message = curl_error($curl);
            if (!empty($curl_error_message)) {
                $error_message = "API call to " . $url . " failed: " . curl_error($curl);
            } else {
                $error_message = "API call to " . $url . " failed, but for an unknown reason. " . "This could happen if you are disconnected from the network.";
            }
            throw new ApiException($error_message, 0, NULL, NULL);
        }
        if (200 <= $response_info["http_code"] && $response_info["http_code"] <= 299) {
            if ($responseType == "\\SplFileObject" || $responseType == "ByteArray") {
                return [$http_body, $response_info["http_code"], $http_header];
            }
            $data = json_decode($http_body);
            if (0 < json_last_error()) {
                $data = $http_body;
            }
            return [$data, $response_info["http_code"], $http_header];
        }
        $data = json_decode($http_body);
        if (0 < json_last_error()) {
            $data = $http_body;
        }
        throw new ApiException("[" . $http_header[0] . "] " . $http_body, $response_info["http_code"], $http_header, $data);
    }
    public static function selectHeaderAccept($accept)
    {
        if (count($accept) === 0 || count($accept) === 1 && $accept[0] === "") {
            return NULL;
        }
        if (preg_grep("/application\\/json/i", $accept)) {
            return "application/json";
        }
        return implode(",", $accept);
    }
    public static function selectHeaderContentType($content_type)
    {
        if (count($content_type) === 0 || count($content_type) === 1 && $content_type[0] === "") {
            return "application/json";
        }
        if (preg_grep("/application\\/json/i", $content_type)) {
            return "application/json";
        }
        return implode(",", $content_type);
    }
    public static function getV1BatchTokenFromHeaders($http_headers)
    {
        if (is_array($http_headers) && isset($http_headers["Link"])) {
            $connect_link_regexp = "/^<([^>]+)>;rel='next'\$/";
            if (preg_match($connect_link_regexp, $http_headers["Link"], $match) === 1) {
                $link_uri = $match[1];
                if ($query = parse_url($link_uri, PHP_URL_QUERY)) {
                    parse_str($query, $query_params);
                    if (is_array($query_params) && isset($query_params["batch_token"])) {
                        return $query_params["batch_token"];
                    }
                }
            }
        }
    }
    protected function http_parse_headers($raw_headers)
    {
        $headers = [];
        $key = "";
        foreach (explode("\n", $raw_headers) as $i => $h) {
            $h = explode(":", $h, 2);
            if (isset($h[1])) {
                if (!isset($headers[$h[0]])) {
                    $headers[$h[0]] = trim($h[1]);
                } else {
                    if (is_array($headers[$h[0]])) {
                        $headers[$h[0]] = array_merge($headers[$h[0]], [trim($h[1])]);
                    } else {
                        $headers[$h[0]] = array_merge([$headers[$h[0]]], [trim($h[1])]);
                    }
                }
                $key = $h[0];
            } else {
                if (substr($h[0], 0, 1) == "\t") {
                    $headers[$key] .= "\r\n\t" . trim($h[0]);
                } else {
                    if (!$key) {
                        $headers[0] = trim($h[0]);
                    }
                }
                trim($h[0]);
            }
        }
        return $headers;
    }
}

?>