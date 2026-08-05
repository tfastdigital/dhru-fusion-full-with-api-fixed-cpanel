<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * TenderCashDetails Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class TenderCashDetails implements \ArrayAccess
{
    /**
     * $buyer_tendered_money The total amount of cash provided by the buyer, before change is given.
     * @var \SquareConnect\Model\Money
     */
    protected $buyer_tendered_money = NULL;
    /**
     * $change_back_money The amount of change returned to the buyer.
     * @var \SquareConnect\Model\Money
     */
    protected $change_back_money = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["buyer_tendered_money" => "\\SquareConnect\\Model\\Money", "change_back_money" => "\\SquareConnect\\Model\\Money"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["buyer_tendered_money" => "buyer_tendered_money", "change_back_money" => "change_back_money"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["buyer_tendered_money" => "setBuyerTenderedMoney", "change_back_money" => "setChangeBackMoney"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["buyer_tendered_money" => "getBuyerTenderedMoney", "change_back_money" => "getChangeBackMoney"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["buyer_tendered_money"])) {
                $this->buyer_tendered_money = $data["buyer_tendered_money"];
            } else {
                $this->buyer_tendered_money = NULL;
            }
            if (isset($data["change_back_money"])) {
                $this->change_back_money = $data["change_back_money"];
            } else {
                $this->change_back_money = NULL;
            }
        }
    }
    public function getBuyerTenderedMoney()
    {
        return $this->buyer_tendered_money;
    }
    public function setBuyerTenderedMoney($buyer_tendered_money)
    {
        $this->buyer_tendered_money = $buyer_tendered_money;
        return $this;
    }
    public function getChangeBackMoney()
    {
        return $this->change_back_money;
    }
    public function setChangeBackMoney($change_back_money)
    {
        $this->change_back_money = $change_back_money;
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