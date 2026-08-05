<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook;

/**
 * Class FacebookClient
 *
 * @package Facebook
 */
class FacebookClient
{
    /**
     * @var bool Toggle to use Graph beta url.
     */
    protected $enableBetaMode = false;
    /**
     * @var FacebookHttpClientInterface HTTP client handler.
     */
    protected $httpClientHandler = NULL;
    /**
     * @var int The number of calls that have been made to Graph.
     */
    public static $requestCount = 0;
    const BASE_GRAPH_URL = "https://graph.facebook.com";
    const BASE_GRAPH_VIDEO_URL = "https://graph-video.facebook.com";
    const BASE_GRAPH_URL_BETA = "https://graph.beta.facebook.com";
    const BASE_GRAPH_VIDEO_URL_BETA = "https://graph-video.beta.facebook.com";
    const DEFAULT_REQUEST_TIMEOUT = 60;
    const DEFAULT_FILE_UPLOAD_REQUEST_TIMEOUT = 3600;
    const DEFAULT_VIDEO_UPLOAD_REQUEST_TIMEOUT = 7200;
    public function __construct(HttpClients\FacebookHttpClientInterface $httpClientHandler = NULL, $enableBeta = false)
    {
        $this->httpClientHandler = $httpClientHandler ?: $this->detectHttpClientHandler();
        $this->enableBetaMode = $enableBeta;
    }
    public function setHttpClientHandler(HttpClients\FacebookHttpClientInterface $httpClientHandler)
    {
        $this->httpClientHandler = $httpClientHandler;
    }
    public function getHttpClientHandler()
    {
        return $this->httpClientHandler;
    }
    public function detectHttpClientHandler()
    {
        return function_exists("curl_init") ? new HttpClients\FacebookCurlHttpClient() : new HttpClients\FacebookStreamHttpClient();
    }
    public function enableBetaMode($betaMode = true)
    {
        $this->enableBetaMode = $betaMode;
    }
    public function getBaseGraphUrl($postToVideoUrl = false)
    {
        if ($postToVideoUrl) {
            return $this->enableBetaMode ? static::BASE_GRAPH_VIDEO_URL_BETA : static::BASE_GRAPH_VIDEO_URL;
        }
        return $this->enableBetaMode ? static::BASE_GRAPH_URL_BETA : static::BASE_GRAPH_URL;
    }
    public function prepareRequestMessage(FacebookRequest $request)
    {
        $postToVideoUrl = $request->containsVideoUploads();
        $url = $this->getBaseGraphUrl($postToVideoUrl) . $request->getUrl();
        if ($request->containsFileUploads()) {
            $requestBody = $request->getMultipartBody();
            $request->setHeaders(["Content-Type" => "multipart/form-data; boundary=" . $requestBody->getBoundary()]);
        } else {
            $requestBody = $request->getUrlEncodedBody();
            $request->setHeaders(["Content-Type" => "application/x-www-form-urlencoded"]);
        }
        return [$url, $request->getMethod(), $request->getHeaders(), $requestBody->getBody()];
    }
    public function sendRequest(FacebookRequest $request)
    {
        if (get_class($request) === "FacebookRequest") {
            $request->validateAccessToken();
        }
        list($url, $method, $headers, $body) = $this->prepareRequestMessage($request);
        $timeOut = static::DEFAULT_REQUEST_TIMEOUT;
        if ($request->containsFileUploads()) {
            $timeOut = static::DEFAULT_FILE_UPLOAD_REQUEST_TIMEOUT;
        } else {
            if ($request->containsVideoUploads()) {
                $timeOut = static::DEFAULT_VIDEO_UPLOAD_REQUEST_TIMEOUT;
            }
        }
        $rawResponse = $this->httpClientHandler->send($url, $method, $body, $headers, $timeOut);
        static::$requestCount++;
        $returnResponse = new FacebookResponse($request, $rawResponse->getBody(), $rawResponse->getHttpResponseCode(), $rawResponse->getHeaders());
        if ($returnResponse->isError()) {
            throw $returnResponse->getThrownException();
        }
        return $returnResponse;
    }
    public function sendBatchRequest(FacebookBatchRequest $request)
    {
        $request->prepareRequestsForBatch();
        $facebookResponse = $this->sendRequest($request);
        return new FacebookBatchResponse($request, $facebookResponse);
    }
}

?>