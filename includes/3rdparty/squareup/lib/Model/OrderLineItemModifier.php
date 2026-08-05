<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * OrderLineItemModifier Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class OrderLineItemModifier implements \ArrayAccess
{
    /**
     * $uid Unique ID that identifies the modifier only within this order.  This field is read-only.
     * @var string
     */
    protected $uid = NULL;
    /**
     * $catalog_object_id The catalog object id referencing [CatalogModifier](#type-catalogmodifier).
     * @var string
     */
    protected $catalog_object_id = NULL;
    /**
     * $name The name of the item modifier.
     * @var string
     */
    protected $name = NULL;
    /**
     * $base_price_money The base price for the modifier.  `base_price_money` is required for ad hoc modifiers. If both `catalog_object_id` and `base_price_money` are set, `base_price_money` will override the predefined [CatalogModifier](#type-catalogmodifier) price.
     * @var \SquareConnect\Model\Money
     */
    protected $base_price_money = NULL;
    /**
     * $total_price_money The total price of the item modifier for its line item. This is the modifier's `base_price_money` multiplied by the line item's quantity.
     * @var \SquareConnect\Model\Money
     */
    protected $total_price_money = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["uid" => "string", "catalog_object_id" => "string", "name" => "string", "base_price_money" => "\\SquareConnect\\Model\\Money", "total_price_money" => "\\SquareConnect\\Model\\Money"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["uid" => "uid", "catalog_object_id" => "catalog_object_id", "name" => "name", "base_price_money" => "base_price_money", "total_price_money" => "total_price_money"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["uid" => "setUid", "catalog_object_id" => "setCatalogObjectId", "name" => "setName", "base_price_money" => "setBasePriceMoney", "total_price_money" => "setTotalPriceMoney"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["uid" => "getUid", "catalog_object_id" => "getCatalogObjectId", "name" => "getName", "base_price_money" => "getBasePriceMoney", "total_price_money" => "getTotalPriceMoney"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["uid"])) {
                $this->uid = $data["uid"];
            } else {
                $this->uid = NULL;
            }
            if (isset($data["catalog_object_id"])) {
                $this->catalog_object_id = $data["catalog_object_id"];
            } else {
                $this->catalog_object_id = NULL;
            }
            if (isset($data["name"])) {
                $this->name = $data["name"];
            } else {
                $this->name = NULL;
            }
            if (isset($data["base_price_money"])) {
                $this->base_price_money = $data["base_price_money"];
            } else {
                $this->base_price_money = NULL;
            }
            if (isset($data["total_price_money"])) {
                $this->total_price_money = $data["total_price_money"];
            } else {
                $this->total_price_money = NULL;
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
    public function getCatalogObjectId()
    {
        return $this->catalog_object_id;
    }
    public function setCatalogObjectId($catalog_object_id)
    {
        $this->catalog_object_id = $catalog_object_id;
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
    public function getBasePriceMoney()
    {
        return $this->base_price_money;
    }
    public function setBasePriceMoney($base_price_money)
    {
        $this->base_price_money = $base_price_money;
        return $this;
    }
    public function getTotalPriceMoney()
    {
        return $this->total_price_money;
    }
    public function setTotalPriceMoney($total_price_money)
    {
        $this->total_price_money = $total_price_money;
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