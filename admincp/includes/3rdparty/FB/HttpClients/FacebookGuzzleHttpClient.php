<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\HttpClients;

class FacebookGuzzleHttpClient implements FacebookHttpClientInterface
{
    /**
     * @var \GuzzleHttp\Client The Guzzle client.
     */
    protected $guzzleClient = NULL;
    public function __construct(\GuzzleHttp\Client $guzzleClient = NULL)
    {
        $this->guzzleClient = $guzzleClient ?: new \GuzzleHttp\Client();
    }
    public function send($url, $method, $body, $headers, $timeOut)
    {
        $options = ["headers" => $headers, "body" => $body, "timeout" => $timeOut, "connect_timeout" => 10, "verify" => __DIR__ . "/certs/DigiCertHighAssuranceEVRootCA.pem"];
        $request = $this->guzzleClient->createRequest($method, $url, $options);
        try {
            $rawResponse = $this->guzzleClient->send($request);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $rawResponse = $e->getResponse();
            if ($e->getPrevious() instanceof \GuzzleHttp\Ring\Exception\RingException || !$rawResponse instanceof \GuzzleHttp\Message\ResponseInterface) {
                throw new \Facebook\Exceptions\FacebookSDKException($e->getMessage(), $e->getCode());
            }
        }
        $rawHeaders = $this->getHeadersAsString($rawResponse);
        $rawBody = $rawResponse->getBody();
        $httpStatusCode = $rawResponse->getStatusCode();
        return new \Facebook\Http\GraphRawResponse($rawHeaders, $rawBody, $httpStatusCode);
    }
    public function getHeadersAsString(\GuzzleHttp\Message\ResponseInterface $response)
    {
        $headers = $response->getHeaders();
        $rawHeaders = [];
        foreach ($headers as $name => $values) {
            $rawHeaders[] = $name . ": " . implode(", ", $values);
        }
        return implode("\r\n", $rawHeaders);
    }
}

?>