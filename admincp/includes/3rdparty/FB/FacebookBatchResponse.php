<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook;

/**
 * Class FacebookBatchResponse
 *
 * @package Facebook
 */
class FacebookBatchResponse extends FacebookResponse implements \IteratorAggregate, \ArrayAccess
{
    /**
     * @var FacebookBatchRequest The original entity that made the batch request.
     */
    protected $batchRequest = NULL;
    /**
     * @var array An array of FacebookResponse entities.
     */
    protected $responses = [];
    public function __construct(FacebookBatchRequest $batchRequest, FacebookResponse $response)
    {
        $this->batchRequest = $batchRequest;
        $request = $response->getRequest();
        $body = $response->getBody();
        $httpStatusCode = $response->getHttpStatusCode();
        $headers = $response->getHeaders();
        parent::__construct($request, $body, $httpStatusCode, $headers);
        $responses = $response->getDecodedBody();
        $this->setResponses($responses);
    }
    public function getResponses()
    {
        return $this->responses;
    }
    public function setResponses($responses)
    {
        $this->responses = [];
        foreach ($responses as $key => $graphResponse) {
            $this->addResponse($key, $graphResponse);
        }
    }
    public function addResponse($key, $response)
    {
        $originalRequestName = isset($this->batchRequest[$key]["name"]) ? $this->batchRequest[$key]["name"] : $key;
        $originalRequest = isset($this->batchRequest[$key]["request"]) ? $this->batchRequest[$key]["request"] : NULL;
        $httpResponseBody = isset($response["body"]) ? $response["body"] : NULL;
        $httpResponseCode = isset($response["code"]) ? $response["code"] : NULL;
        $httpResponseHeaders = isset($response["headers"]) ? $response["headers"] : [];
        $this->responses[$originalRequestName] = new FacebookResponse($originalRequest, $httpResponseBody, $httpResponseCode, $httpResponseHeaders);
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->responses);
    }
    public function offsetSet($offset, $value)
    {
        $this->addResponse($offset, $value);
    }
    public function offsetExists($offset)
    {
        return isset($this->responses[$offset]);
    }
    public function offsetUnset($offset)
    {
        unset($this->responses[$offset]);
    }
    public function offsetGet($offset)
    {
        return isset($this->responses[$offset]) ? $this->responses[$offset] : NULL;
    }
}

?>