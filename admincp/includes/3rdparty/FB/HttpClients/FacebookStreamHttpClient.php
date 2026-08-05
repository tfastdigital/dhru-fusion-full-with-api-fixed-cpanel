<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\HttpClients;

class FacebookStreamHttpClient implements FacebookHttpClientInterface
{
    /**
     * @var FacebookStream Procedural stream wrapper as object.
     */
    protected $facebookStream = NULL;
    public function __construct(FacebookStream $facebookStream = NULL)
    {
        $this->facebookStream = $facebookStream ?: new FacebookStream();
    }
    public function send($url, $method, $body, $headers, $timeOut)
    {
        $options = ["http" => ["method" => $method, "header" => $this->compileHeader($headers), "content" => $body, "timeout" => $timeOut, "ignore_errors" => true], "ssl" => ["verify_peer" => true, "verify_peer_name" => true, "allow_self_signed" => true, "cafile" => __DIR__ . "/certs/DigiCertHighAssuranceEVRootCA.pem"]];
        $this->facebookStream->streamContextCreate($options);
        $rawBody = $this->facebookStream->fileGetContents($url);
        $rawHeaders = $this->facebookStream->getResponseHeaders();
        if ($rawBody === false || !$rawHeaders) {
            throw new \Facebook\Exceptions\FacebookSDKException("Stream returned an empty response", 660);
        }
        $rawHeaders = implode("\r\n", $rawHeaders);
        return new \Facebook\Http\GraphRawResponse($rawHeaders, $rawBody);
    }
    public function compileHeader($headers)
    {
        $header = [];
        foreach ($headers as $k => $v) {
            $header[] = $k . ": " . $v;
        }
        return implode("\r\n", $header);
    }
}

?>