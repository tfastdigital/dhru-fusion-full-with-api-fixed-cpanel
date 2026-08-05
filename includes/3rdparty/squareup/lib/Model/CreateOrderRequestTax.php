<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateOrderRequestTax Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateOrderRequestTax implements \ArrayAccess
{
    /**
     * $catalog_object_id Only used for catalog taxes. The catalog object ID of an existing [CatalogTax](#type-catalogtax).  Do not provide a value for this field if you provide values in other fields for an ad hoc tax.
     * @var string
     */
    protected $catalog_object_id = NULL;
    /**
     * $name Only used for ad hoc taxes. The tax's name.  Do not provide a value for this field if you set `catalog_object_id`.
     * @var string
     */
    protected $name = NULL;
    /**
     * $type Only used for ad hoc taxes. Indicates the calculation method used to apply the line item tax.  Default: `ADDITIVE`; See [OrderLineItemTaxType](#type-orderlineitemtaxtype) for possible values. See [OrderLineItemTaxType](#type-orderlineitemtaxtype) for possible values
     * @var string
     */
    protected $type = NULL;
    /**
     * $percentage Only used for ad hoc taxes. The percentage of the tax, as a string representation of a decimal number.  A value of `7.25` corresponds to a percentage of 7.25%. This value range between 0.0 up to 100.0
     * @var string
     */
    protected $percentage = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["catalog_object_id" => "string", "name" => "string", "type" => "string", "percentage" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["catalog_object_id" => "catalog_object_id", "name" => "name", "type" => "type", "percentage" => "percentage"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["catalog_object_id" => "setCatalogObjectId", "name" => "setName", "type" => "setType", "percentage" => "setPercentage"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["catalog_object_id" => "getCatalogObjectId", "name" => "getName", "type" => "getType", "percentage" => "getPercentage"];
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