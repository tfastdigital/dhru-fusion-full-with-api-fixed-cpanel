<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateMobileAuthorizationCodeResponse Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateMobileAuthorizationCodeResponse implements \ArrayAccess
{
    /**
     * $authorization_code Generated authorization code that connects a mobile application instance to a Square account.
     * @var string
     */
    protected $authorization_code = NULL;
    /**
     * $expires_at The timestamp when `authorization_code` expires in [RFC 3339](https://tools.ietf.org/html/rfc3339) format, e.g., \"2016-09-04T23:59:33.123Z\".
     * @var string
     */
    protected $expires_at = NULL;
    /**
     * $error An error object that provides details about how creation of authorization code failed.
     * @var \SquareConnect\Model\Error
     */
    protected $error = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["authorization_code" => "string", "expires_at" => "string", "error" => "\\SquareConnect\\Model\\Error"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["authorization_code" => "authorization_code", "expires_at" => "expires_at", "error" => "error"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["authorization_code" => "setAuthorizationCode", "expires_at" => "setExpiresAt", "error" => "setError"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["authorization_code" => "getAuthorizationCode", "expires_at" => "getExpiresAt", "error" => "getError"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["authorization_code"])) {
                $this->authorization_code = $data["authorization_code"];
            } else {
                $this->authorization_code = NULL;
            }
            if (isset($data["expires_at"])) {
                $this->expires_at = $data["expires_at"];
            } else {
                $this->expires_at = NULL;
            }
            if (isset($data["error"])) {
                $this->error = $data["error"];
            } else {
                $this->error = NULL;
            }
        }
    }
    public function getAuthorizationCode()
    {
        return $this->authorization_code;
    }
    public function setAuthorizationCode($authorization_code)
    {
        $this->authorization_code = $authorization_code;
        return $this;
    }
    public function getExpiresAt()
    {
        return $this->expires_at;
    }
    public function setExpiresAt($expires_at)
    {
        $this->expires_at = $expires_at;
        return $this;
    }
    public function getError()
    {
        return $this->error;
    }
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }
    public function __toString()
    {
        if (defined("JSON_PRETTY_PRINT")) {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }
        return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this));
    }
}

?>