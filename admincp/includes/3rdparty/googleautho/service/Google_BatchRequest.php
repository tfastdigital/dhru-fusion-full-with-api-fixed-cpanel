<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * @author Chirag Shah <chirags@google.com>
 */
class Google_BatchRequest
{
    /** @var string Multipart Boundary. */
    private $boundary = NULL;
    /** @var array service requests to be executed. */
    private $requests = [];
    public function __construct($boundary = false)
    {
        $boundary = !$boundary ? mt_rand() : $boundary;
        $this->boundary = str_replace("\"", "", $boundary);
    }
    public function add(Google_HttpRequest $request, $key = false)
    {
        if (!$key) {
            $key = mt_rand();
        }
        $this->requests[$key] = $request;
    }
    public function execute()
    {
        $body = "";
        foreach ($this->requests as $key => $req) {
            $body .= "--" . $this->boundary . "\n";
            $body .= $req->toBatchString($key) . "\n";
        }
        $body = rtrim($body);
        $body .= "\n--" . $this->boundary . "--";
        global $apiConfig;
        $url = $apiConfig["basePath"] . "/batch";
        $httpRequest = new Google_HttpRequest($url, "POST");
        $httpRequest->setRequestHeaders(["Content-Type" => "multipart/mixed; boundary=" . $this->boundary]);
        $httpRequest->setPostBody($body);
        $response = Google_Client::$io->makeRequest($httpRequest);
        $response = $this->parseResponse($response);
        return $response;
    }
    public function parseResponse(Google_HttpRequest $response)
    {
        $contentType = $response->getResponseHeader("content-type");
        $contentType = explode(";", $contentType);
        $boundary = false;
        foreach ($contentType as $part) {
            $part = explode("=", $part, 2);
            if (isset($part[0]) && "boundary" == trim($part[0])) {
                $boundary = $part[1];
            }
        }
        $body = $response->getResponseBody();
        if ($body) {
            $body = str_replace("--" . $boundary . "--", "--" . $boundary, $body);
            $parts = explode("--" . $boundary, $body);
            $responses = [];
            foreach ($parts as $part) {
                $part = trim($part);
                if (!empty($part)) {
                    list($metaHeaders, $part) = explode("\r\n\r\n", $part, 2);
                    $metaHeaders = Google_CurlIO::parseResponseHeaders($metaHeaders);
                    $status = substr($part, 0, strpos($part, "\n"));
                    $status = explode(" ", $status);
                    $status = $status[1];
                    list($partHeaders, $partBody) = Google_CurlIO::parseHttpResponse($part, false);
                    $response = new Google_HttpRequest("");
                    $response->setResponseHttpCode($status);
                    $response->setResponseHeaders($partHeaders);
                    $response->setResponseBody($partBody);
                    $response = Google_REST::decodeHttpResponse($response);
                    $responses[$metaHeaders["content-id"]] = $response;
                }
            }
            return $responses;
        } else {
            return NULL;
        }
    }
}

?>