<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * OrderLineItemDiscount Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class OrderLineItemDiscount implements \ArrayAccess
{
    /**
     * $uid Unique ID that identifies the discount only within this order.  This field is read-only.
     * @var string
     */
    protected $uid = NULL;
    /**
     * $catalog_object_id The catalog object id referencing [CatalogDiscount](#type-catalogdiscount).
     * @var string
     */
    protected $catalog_object_id = NULL;
    /**
     * $name The discount's name.
     * @var string
     */
    protected $name = NULL;
    /**
     * $type The type of the discount. If it is created by API, it would be either `FIXED_PERCENTAGE` or `FIXED_AMOUNT`.  VARIABLE_* is not supported in API because the order is created at the time of sale and either percentage or amount has to be specified. See [OrderLineItemDiscountType](#type-orderlineitemdiscounttype) for possible values
     * @var string
     */
    protected $type = NULL;
    /**
     * $percentage The percentage of the discount, as a string representation of a decimal number. A value of `7.25` corresponds to a percentage of 7.25%.  The percentage won't be set for an amount-based discount.
     * @var string
     */
    protected $percentage = NULL;
    /**
     * $amount_money The total monetary amount of the applicable discount. If it is at order level, it is the value of the order level discount. If it is at line item level, it is the value of the line item level discount.  The amount_money won't be set for a percentage-based discount.
     * @var \SquareConnect\Model\Money
     */
    protected $amount_money = NULL;
    /**
     * $applied_money The amount of discount actually applied to this line item.  Represents the amount of money applied to a line item as a discount When an amount-based discount is at order-level, this value is different from `amount_money` because the discount is distributed across the line items.
     * @var \SquareConnect\Model\Money
     */
    protected $applied_money = NULL;
    /**
     * $scope Indicates the level at which the discount applies. This field is set by the server. If set in a CreateOrder request, it will be ignored on write. See [OrderLineItemDiscountScope](#type-orderlineitemdiscountscope) for possible values
     * @var string
     */
    protected $scope = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["uid" => "string", "catalog_object_id" => "string", "name" => "string", "type" => "string", "percentage" => "string", "amount_money" => "\\SquareConnect\\Model\\Money", "applied_money" => "\\SquareConnect\\Model\\Money", "scope" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["uid" => "uid", "catalog_object_id" => "catalog_object_id", "name" => "name", "type" => "type", "percentage" => "percentage", "amount_money" => "amount_money", "applied_money" => "applied_money", "scope" => "scope"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["uid" => "setUid", "catalog_object_id" => "setCatalogObjectId", "name" => "setName", "type" => "setType", "percentage" => "setPercentage", "amount_money" => "setAmountMoney", "applied_money" => "setAppliedMoney", "scope" => "setScope"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["uid" => "getUid", "catalog_object_id" => "getCatalogObjectId", "name" => "getName", "type" => "getType", "percentage" => "getPercentage", "amount_money" => "getAmountMoney", "applied_money" => "getAppliedMoney", "scope" => "getScope"];
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
            if (isset($data["type"])) {
                $this->type = $data["type"];
            } else {
                $this->type = NULL;
            }
            if (isset($data["percentage"])) {
                $this->percentage = $data["percentage"];
            } else {
                $this->percentage = NULL;
            }
            if (isset($data["amount_money"])) {
                $this->amount_money = $data["amount_money"];
            } else {
                $this->amount_money = NULL;
            }
            if (isset($data["applied_money"])) {
                $this->applied_money = $data["applied_money"];
            } else {
                $this->applied_money = NULL;
            }
            if (isset($data["scope"])) {
                $this->scope = $data["scope"];
            } else {
                $this->scope = NULL;
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
    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    public function getPercentage()
    {
        return $this->percentage;
    }
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;
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
    public function getAppliedMoney()
    {
        return $this->applied_money;
    }
    public function setAppliedMoney($applied_money)
    {
        $this->applied_money = $applied_money;
        return $this;
    }
    public function getScope()
    {
        return $this->scope;
    }
    public function setScope($scope)
    {
        $this->scope = $scope;
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