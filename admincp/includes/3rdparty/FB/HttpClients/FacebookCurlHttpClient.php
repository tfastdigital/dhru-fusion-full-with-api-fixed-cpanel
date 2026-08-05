<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\HttpClients;

/**
 * Class FacebookCurlHttpClient
 *
 * @package Facebook
 */
class FacebookCurlHttpClient implements FacebookHttpClientInterface
{
    /**
     * @var string The client error message
     */
    protected $curlErrorMessage = "";
    /**
     * @var int The curl client error code
     */
    protected $curlErrorCode = 0;
    /**
     * @var string|boolean The raw response from the server
     */
    protected $rawResponse = NULL;
    /**
     * @var FacebookCurl Procedural curl as object
     */
    protected $facebookCurl = NULL;
    const CURL_PROXY_QUIRK_VER = 466432;
    const CONNECTION_ESTABLISHED = "HTTP/1.0 200 Connection established\r\n\r\n";
    public function __construct(FacebookCurl $facebookCurl = NULL)
    {
        $this->facebookCurl = $facebookCurl ?: new FacebookCurl();
    }
    public function send($url, $method, $body, $headers, $timeOut)
    {
        $this->openConnection($url, $method, $body, $headers, $timeOut);
        $this->sendRequest();
        if ($curlErrorCode = $this->facebookCurl->errno()) {
            throw new \Facebook\Exceptions\FacebookSDKException($this->facebookCurl->error(), $curlErrorCode);
        }
        list($rawHeaders, $rawBody) = $this->extractResponseHeadersAndBody();
        $this->closeConnection();
        return new \Facebook\Http\GraphRawResponse($rawHeaders, $rawBody);
    }
    public function openConnection($url, $method, $body, $headers, $timeOut)
    {
        $options = [CURLOPT_CUSTOMREQUEST => $method, CURLOPT_HTTPHEADER => $this->compileRequestHeaders($headers), CURLOPT_URL => $url, CURLOPT_CONNECTTIMEOUT => 10, CURLOPT_TIMEOUT => $timeOut, CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => true, CURLOPT_SSL_VERIFYHOST => 2, CURLOPT_SSL_VERIFYPEER => true, CURLOPT_CAINFO => __DIR__ . "/certs/DigiCertHighAssuranceEVRootCA.pem"];
        if ($method !== "GET") {
            $options[CURLOPT_POSTFIELDS] = $body;
        }
        $this->facebookCurl->init();
        $this->facebookCurl->setoptArray($options);
    }
    public function closeConnection()
    {
        $this->facebookCurl->close();
    }
    public function sendRequest()
    {
        $this->rawResponse = $this->facebookCurl->exec();
    }
    public function compileRequestHeaders($headers)
    {
        $return = [];
        foreach ($headers as $key => $value) {
            $return[] = $key . ": " . $value;
        }
        return $return;
    }
    public function extractResponseHeadersAndBody()
    {
        $headerSize = $this->getHeaderSize();
        $rawHeaders = mb_substr($this->rawResponse, 0, $headerSize);
        $rawBody = mb_substr($this->rawResponse, $headerSize);
        return [trim($rawHeaders), trim($rawBody)];
    }
    private function getHeaderSize()
    {
        $headerSize = $this->facebookCurl->getinfo(CURLINFO_HEADER_SIZE);
        if ($this->needsCurlProxyFix()) {
            if (preg_match("/Content-Length: (\\d+)/", $this->rawResponse, $m)) {
                $headerSize = mb_strlen($this->rawResponse) - $m[1];
            } else {
                if (stripos($this->rawResponse, self::CONNECTION_ESTABLISHED) !== false) {
                    $headerSize += mb_strlen(self::CONNECTION_ESTABLISHED);
                }
            }
        }
        return $headerSize;
    }
    private function needsCurlProxyFix()
    {
        $ver = $this->facebookCurl->version();
        $version = $ver["version_number"];
        return $version < self::CURL_PROXY_QUIRK_VER;
    }
}

?>