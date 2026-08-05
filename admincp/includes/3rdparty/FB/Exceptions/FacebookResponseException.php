<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\Exceptions;

/**
 * Class FacebookResponseException
 *
 * @package Facebook
 */
class FacebookResponseException extends FacebookSDKException
{
    /**
     * @var FacebookResponse The response that threw the exception.
     */
    protected $response = NULL;
    /**
     * @var array Decoded response.
     */
    protected $responseData = NULL;
    public function __construct(\Facebook\FacebookResponse $response, FacebookSDKException $previousException = NULL)
    {
        $this->response = $response;
        $this->responseData = $response->getDecodedBody();
        $errorMessage = $this->get("message", "Unknown error from Graph.");
        $errorCode = $this->get("code", -1);
        parent::__construct($errorMessage, $errorCode, $previousException);
    }
    public static function create(\Facebook\FacebookResponse $response)
    {
        $data = $response->getDecodedBody();
        if (!isset($data["error"]["code"]) && isset($data["code"])) {
            $data = ["error" => $data];
        }
        $code = isset($data["error"]["code"]) ? $data["error"]["code"] : NULL;
        $message = isset($data["error"]["message"]) ? $data["error"]["message"] : "Unknown error from Graph.";
        $previousException = NULL;
        if (isset($data["error"]["error_subcode"])) {
            switch ($data["error"]["error_subcode"]) {
                case 458:
                case 459:
                case 460:
                case 463:
                case 464:
                case 467:
                    return new static($response, new FacebookAuthenticationException($message, $code));
                    break;
            }
        }
        switch ($code) {
            case 100:
            case 102:
            case 190:
                return new static($response, new FacebookAuthenticationException($message, $code));
                break;
            case 1:
            case 2:
                return new static($response, new FacebookServerException($message, $code));
                break;
            case 4:
            case 17:
            case 341:
                return new static($response, new FacebookThrottleException($message, $code));
                break;
            case 506:
                return new static($response, new FacebookClientException($message, $code));
                break;
            default:
                if ($code == 10 || 200 <= $code && $code <= 299) {
                    return new static($response, new FacebookAuthorizationException($message, $code));
                }
                if (isset($data["error"]["type"]) && $data["error"]["type"] === "OAuthException") {
                    return new static($response, new FacebookAuthenticationException($message, $code));
                }
                return new static($response, new FacebookOtherException($message, $code));
        }
    }
    private function get($key, $default = NULL)
    {
        if (isset($this->responseData["error"][$key])) {
            return $this->responseData["error"][$key];
        }
        return $default;
    }
    public function getHttpStatusCode()
    {
        return $this->response->getHttpStatusCode();
    }
    public function getSubErrorCode()
    {
        return $this->get("error_subcode", -1);
    }
    public function getErrorType()
    {
        return $this->get("type", "");
    }
    public function getRawResponse()
    {
        return $this->response->getBody();
    }
    public function getResponseData()
    {
        return $this->responseData;
    }
    public function getResponse()
    {
        return $this->response;
    }
}

?>