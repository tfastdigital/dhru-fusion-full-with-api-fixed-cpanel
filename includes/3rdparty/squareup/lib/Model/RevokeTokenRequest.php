<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * RevokeTokenRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class RevokeTokenRequest implements \ArrayAccess
{
    /**
     * $client_id Your application's ID, available from the [application dashboard](https://connect.squareup.com/apps).
     * @var string
     */
    protected $client_id = NULL;
    /**
     * $access_token The access token of the merchant whose token you want to revoke. Do not provide a value for merchant_id if you provide this parameter.
     * @var string
     */
    protected $access_token = NULL;
    /**
     * $merchant_id The ID of the merchant whose token you want to revoke. Do not provide a value for access_token if you provide this parameter.
     * @var string
     */
    protected $merchant_id = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["client_id" => "string", "access_token" => "string", "merchant_id" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["client_id" => "client_id", "access_token" => "access_token", "merchant_id" => "merchant_id"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["client_id" => "setClientId", "access_token" => "setAccessToken", "merchant_id" => "setMerchantId"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["client_id" => "getClientId", "access_token" => "getAccessToken", "merchant_id" => "getMerchantId"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["client_id"])) {
                $this->client_id = $data["client_id"];
            } else {
                $this->client_id = NULL;
            }
            if (isset($data["access_token"])) {
                $this->access_token = $data["access_token"];
            } else {
                $this->access_token = NULL;
            }
            if (isset($data["merchant_id"])) {
                $this->merchant_id = $data["merchant_id"];
            } else {
                $this->merchant_id = NULL;
            }
        }
    }
    public function getClientId()
    {
        return $this->client_id;
    }
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }
    public function getAccessToken()
    {
        return $this->access_token;
    }
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        return $this;
    }
    public function getMerchantId()
    {
        return $this->merchant_id;
    }
    public function setMerchantId($merchant_id)
    {
        $this->merchant_id = $merchant_id;
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