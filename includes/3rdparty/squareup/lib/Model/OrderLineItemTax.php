<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * OrderLineItemTax Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class OrderLineItemTax implements \ArrayAccess
{
    /**
     * $uid Unique ID that identifies the tax only within this order.  This field is read-only.
     * @var string
     */
    protected $uid = NULL;
    /**
     * $catalog_object_id The catalog object id referencing [CatalogTax](#type-catalogtax).
     * @var string
     */
    protected $catalog_object_id = NULL;
    /**
     * $name The tax's name.
     * @var string
     */
    protected $name = NULL;
    /**
     * $type Indicates the calculation method used to apply the tax. See [OrderLineItemTaxType](#type-orderlineitemtaxtype) for possible values
     * @var string
     */
    protected $type = NULL;
    /**
     * $percentage The percentage of the tax, as a string representation of a decimal number.  A value of `7.25` corresponds to a percentage of 7.25%.
     * @var string
     */
    protected $percentage = NULL;
    /**
     * $applied_money The amount of the money applied by the tax in an order.
     * @var \SquareConnect\Model\Money
     */
    protected $applied_money = NULL;
    /**
     * $scope Indicates the level at which the tax applies. This field is set by the server. If set in a CreateOrder request, it will be ignored on write. See [OrderLineItemTaxScope](#type-orderlineitemtaxscope) for possible values
     * @var string
     */
    protected $scope = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["uid" => "string", "catalog_object_id" => "string", "name" => "string", "type" => "string", "percentage" => "string", "applied_money" => "\\SquareConnect\\Model\\Money", "scope" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["uid" => "uid", "catalog_object_id" => "catalog_object_id", "name" => "name", "type" => "type", "percentage" => "percentage", "applied_money" => "applied_money", "scope" => "scope"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["uid" => "setUid", "catalog_object_id" => "setCatalogObjectId", "name" => "setName", "type" => "setType", "percentage" => "setPercentage", "applied_money" => "setAppliedMoney", "scope" => "setScope"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["uid" => "getUid", "catalog_object_id" => "getCatalogObjectId", "name" => "getName", "type" => "getType", "percentage" => "getPercentage", "applied_money" => "getAppliedMoney", "scope" => "getScope"];
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