<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * ChargeRequestAdditionalRecipient Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class ChargeRequestAdditionalRecipient implements \ArrayAccess
{
    /**
     * $location_id The location ID for a recipient (other than the merchant) receiving a portion of the tender.
     * @var string
     */
    protected $location_id = NULL;
    /**
     * $description The description of the additional recipient.
     * @var string
     */
    protected $description = NULL;
    /**
     * $amount_money The amount of money distributed to the recipient.
     * @var \SquareConnect\Model\Money
     */
    protected $amount_money = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["location_id" => "string", "description" => "string", "amount_money" => "\\SquareConnect\\Model\\Money"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["location_id" => "location_id", "description" => "description", "amount_money" => "amount_money"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["location_id" => "setLocationId", "description" => "setDescription", "amount_money" => "setAmountMoney"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["location_id" => "getLocationId", "description" => "getDescription", "amount_money" => "getAmountMoney"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["location_id"])) {
                $this->location_id = $data["location_id"];
            } else {
                $this->location_id = NULL;
            }
            if (isset($data["description"])) {
                $this->description = $data["description"];
            } else {
                $this->description = NULL;
            }
            if (isset($data["amount_money"])) {
                $this->amount_money = $data["amount_money"];
            } else {
                $this->amount_money = NULL;
            }
        }
    }
    public function getLocationId()
    {
        return $this->location_id;
    }
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    public function getAmountMoney()
    {
        return $this->amount_money;
    }
    public function setAmountMoney($amount_money)
    {
        $this->amount_money = $amount_money;
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