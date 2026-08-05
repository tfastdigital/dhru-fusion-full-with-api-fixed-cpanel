<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * OrderFulfillment Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class OrderFulfillment implements \ArrayAccess
{
    /**
     * $type The type of the fulfillment. See [OrderFulfillmentType](#type-orderfulfillmenttype) for possible values
     * @var string
     */
    protected $type = NULL;
    /**
     * $state The state of the fulfillment. See [OrderFulfillmentState](#type-orderfulfillmentstate) for possible values
     * @var string
     */
    protected $state = NULL;
    /**
     * $pickup_details Contains pickup-specific details. Required when fulfillment type is `PICKUP`.
     * @var \SquareConnect\Model\OrderFulfillmentPickupDetails
     */
    protected $pickup_details = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["type" => "string", "state" => "string", "pickup_details" => "\\SquareConnect\\Model\\OrderFulfillmentPickupDetails"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["type" => "type", "state" => "state", "pickup_details" => "pickup_details"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["type" => "setType", "state" => "setState", "pickup_details" => "setPickupDetails"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["type" => "getType", "state" => "getState", "pickup_details" => "getPickupDetails"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["type"])) {
                $this->type = $data["type"];
            } else {
                $this->type = NULL;
            }
            if (isset($data["state"])) {
                $this->state = $data["state"];
            } else {
                $this->state = NULL;
            }
            if (isset($data["pickup_details"])) {
                $this->pickup_details = $data["pickup_details"];
            } else {
                $this->pickup_details = NULL;
            }
        }
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    public function getState()
    {
        return $this->state;
    }
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    public function getPickupDetails()
    {
        return $this->pickup_details;
    }
    public function setPickupDetails($pickup_details)
    {
        $this->pickup_details = $pickup_details;
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