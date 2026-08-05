<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\HttpClients;

/**
 * Class FacebookStream
 *
 * Abstraction for the procedural stream elements so that the functions can be
 * mocked and the implementation can be tested.
 *
 * @package Facebook
 */
class FacebookStream
{
    /**
     * @var resource Context stream resource instance
     */
    protected $stream = NULL;
    /**
     * @var array Response headers from the stream wrapper
     */
    protected $responseHeaders = NULL;
    public function streamContextCreate($options)
    {
        $this->stream = stream_context_create($options);
    }
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }
    public function fileGetContents($url)
    {
        $rawResponse = file_get_contents($url, false, $this->stream);
        $this->responseHeaders = $http_response_header;
        return $rawResponse;
    }
}

?>