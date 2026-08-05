<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * OrderRoundingAdjustment Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class OrderRoundingAdjustment implements \ArrayAccess
{
    /**
     * $uid Unique ID that identifies the rounding adjustment only within this order.  This field is read-only.
     * @var string
     */
    protected $uid = NULL;
    /**
     * $name The name of the rounding adjustment from the original sale Order.
     * @var string
     */
    protected $name = NULL;
    /**
     * $amount_money Actual rounding adjustment amount.
     * @var \SquareConnect\Model\Money
     */
    protected $amount_money = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["uid" => "string", "name" => "string", "amount_money" => "\\SquareConnect\\Model\\Money"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["uid" => "uid", "name" => "name", "amount_money" => "amount_money"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["uid" => "setUid", "name" => "setName", "amount_money" => "setAmountMoney"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["uid" => "getUid", "name" => "getName", "amount_money" => "getAmountMoney"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["uid"])) {
                $this->uid = $data["uid"];
            } else {
                $this->uid = NULL;
            }
            if (isset($data["name"])) {
                $this->name = $data["name"];
            } else {
                $this->name = NULL;
            }
            if (isset($data["amount_money"])) {
                $this->amount_money = $data["amount_money"];
            } else {
                $this->amount_money = NULL;
            }
        }
    }
    public function getUid()
    {
        return $this->uid;
    }
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
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