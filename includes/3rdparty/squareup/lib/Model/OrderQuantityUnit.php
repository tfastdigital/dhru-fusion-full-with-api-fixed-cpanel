<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * OrderQuantityUnit Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class OrderQuantityUnit implements \ArrayAccess
{
    /**
     * $measurement_unit A [MeasurementUnit](#type-measurementunit) that represents the unit of measure for the quantity.
     * @var \SquareConnect\Model\MeasurementUnit
     */
    protected $measurement_unit = NULL;
    /**
     * $precision For non-integer quantities, represents the number of digits after the decimal point that are recorded for this quantity.  For example, a precision of 1 allows quantities like `\"1.0\"` and `\"1.1\"`, but not `\"1.01\"`.  Min: 0. Max: 5.  Orders Hub and older versions of Connect do not support non-integer quantities. See [Decimal quantities with Orders hub and older versions of Connect](/more-apis/orders/overview#decimal-quantities).
     * @var int
     */
    protected $precision = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["measurement_unit" => "\\SquareConnect\\Model\\MeasurementUnit", "precision" => "int"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["measurement_unit" => "measurement_unit", "precision" => "precision"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["measurement_unit" => "setMeasurementUnit", "precision" => "setPrecision"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["measurement_unit" => "getMeasurementUnit", "precision" => "getPrecision"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["measurement_unit"])) {
                $this->measurement_unit = $data["measurement_unit"];
            } else {
                $this->measurement_unit = NULL;
            }
            if (isset($data["precision"])) {
                $this->precision = $data["precision"];
            } else {
                $this->precision = NULL;
            }
        }
    }
    public function getMeasurementUnit()
    {
        return $this->measurement_unit;
    }
    public function setMeasurementUnit($measurement_unit)
    {
        $this->measurement_unit = $measurement_unit;
        return $this;
    }
    public function getPrecision()
    {
        return $this->precision;
    }
    public function setPrecision($precision)
    {
        $this->precision = $precision;
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