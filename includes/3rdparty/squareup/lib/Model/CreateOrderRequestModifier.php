<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateOrderRequestModifier Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateOrderRequestModifier implements \ArrayAccess
{
    /**
     * $catalog_object_id The catalog object ID of a [CatalogModifier](#type-catalogmodifier).
     * @var string
     */
    protected $catalog_object_id = NULL;
    /**
     * $name Only used for ad hoc modifiers. The name of the modifier. `name` cannot exceed 255 characters.  Do not provide a value for `name` if you provide a value for `catalog_object_id`.
     * @var string
     */
    protected $name = NULL;
    /**
     * $base_price_money The base price for the modifier.  `base_price_money` is required for ad hoc modifiers. If both `catalog_object_id` and `base_price_money` are set, `base_price_money` will override the predefined [CatalogModifier](#type-catalogmodifier) price.
     * @var \SquareConnect\Model\Money
     */
    protected $base_price_money = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["catalog_object_id" => "string", "name" => "string", "base_price_money" => "\\SquareConnect\\Model\\Money"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["catalog_object_id" => "catalog_object_id", "name" => "name", "base_price_money" => "base_price_money"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["catalog_object_id" => "setCatalogObjectId", "name" => "setName", "base_price_money" => "setBasePriceMoney"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["catalog_object_id" => "getCatalogObjectId", "name" => "getName", "base_price_money" => "getBasePriceMoney"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
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
        }
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