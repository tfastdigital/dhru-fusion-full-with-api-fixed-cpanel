<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * SourceApplication Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class SourceApplication implements \ArrayAccess
{
    /**
     * $product Read-only [Product](#type-product) type for the application. See [Product](#type-product) for possible values
     * @var string
     */
    protected $product = NULL;
    /**
     * $application_id Read-only Square ID assigned to the application. Only used for [Product](#type-product) type `EXTERNAL_API`.
     * @var string
     */
    protected $application_id = NULL;
    /**
     * $name Read-only display name assigned to the application (e.g. `\"Custom Application\"`, `\"Square POS 4.74 for Android\"`).
     * @var string
     */
    protected $name = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["product" => "string", "application_id" => "string", "name" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["product" => "product", "application_id" => "application_id", "name" => "name"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["product" => "setProduct", "application_id" => "setApplicationId", "name" => "setName"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["product" => "getProduct", "application_id" => "getApplicationId", "name" => "getName"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["product"])) {
                $this->product = $data["product"];
            } else {
                $this->product = NULL;
            }
            if (isset($data["application_id"])) {
                $this->application_id = $data["application_id"];
            } else {
                $this->application_id = NULL;
            }
            if (isset($data["name"])) {
                $this->name = $data["name"];
            } else {
                $this->name = NULL;
            }
        }
    }
    public function getProduct()
    {
        return $this->product;
    }
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }
    public function getApplicationId()
    {
        return $this->application_id;
    }
    public function setApplicationId($application_id)
    {
        $this->application_id = $application_id;
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