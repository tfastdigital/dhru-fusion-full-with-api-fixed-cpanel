<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect;

/**
 * ApiException Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://squareup.com/developers
 */
class ApiException extends \Exception
{
    /**
     * The HTTP body of the server response either as Json or string.
     * @var mixed
     */
    protected $responseBody = NULL;
    /**
     * The HTTP header of the server response.
     * @var string[]
     */
    protected $responseHeaders = NULL;
    /**
     * The deserialized response object
     * @var $responseObject;
     */
    protected $responseObject = NULL;
    public function __construct($message = "", $code = 0, $responseHeaders = NULL, $responseBody = NULL)
    {
        parent::__construct($message, $code);
        $this->responseHeaders = $responseHeaders;
        $this->responseBody = $responseBody;
    }
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }
    public function getResponseBody()
    {
        return $this->responseBody;
    }
    public function setResponseObject($obj)
    {
        $this->responseObject = $obj;
    }
    public function getResponseObject()
    {
        return $this->responseObject;
    }
}

?>