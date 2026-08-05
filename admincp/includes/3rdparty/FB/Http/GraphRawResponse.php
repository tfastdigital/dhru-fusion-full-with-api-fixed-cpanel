<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Http;

/**
 * Class GraphRawResponse
 *
 * @package Facebook
 */
class GraphRawResponse
{
    /**
     * @var array The response headers in the form of an associative array.
     */
    protected $headers = NULL;
    /**
     * @var string The raw response body.
     */
    protected $body = NULL;
    /**
     * @var int The HTTP status response code.
     */
    protected $httpResponseCode = NULL;
    public function __construct($headers, $body, $httpStatusCode = NULL)
    {
        if (is_numeric($httpStatusCode)) {
            $this->httpResponseCode = (int) $httpStatusCode;
        }
        if (is_array($headers)) {
            $this->headers = $headers;
        } else {
            $this->setHeadersFromString($headers);
        }
        $this->body = $body;
    }
    public function getHeaders()
    {
        return $this->headers;
    }
    public function getBody()
    {
        return $this->body;
    }
    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }
    public function setHttpResponseCodeFromHeader($rawResponseHeader)
    {
        preg_match("|HTTP/\\d\\.\\d\\s+(\\d+)\\s+.*|", $rawResponseHeader, $match);
        $this->httpResponseCode = (int) $match[1];
    }
    protected function setHeadersFromString($rawHeaders)
    {
        $rawHeaders = str_replace("\r\n", "\n", $rawHeaders);
        $headerCollection = explode("\n\n", trim($rawHeaders));
        $rawHeader = array_pop($headerCollection);
        $headerComponents = explode("\n", $rawHeader);
        foreach ($headerComponents as $line) {
            if (strpos($line, ": ") === false) {
                $this->setHttpResponseCodeFromHeader($line);
            } else {
                list($key, $value) = explode(": ", $line);
                $this->headers[$key] = $value;
            }
        }
    }
}

?>