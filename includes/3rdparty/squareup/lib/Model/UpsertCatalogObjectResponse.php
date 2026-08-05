<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * UpsertCatalogObjectResponse Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class UpsertCatalogObjectResponse implements \ArrayAccess
{
    /**
     * $errors The set of [Error](#type-error)s encountered.
     * @var \SquareConnect\Model\Error[]
     */
    protected $errors = NULL;
    /**
     * $catalog_object The created [CatalogObject](#type-catalogobject).
     * @var \SquareConnect\Model\CatalogObject
     */
    protected $catalog_object = NULL;
    /**
     * $id_mappings The mapping between client and server IDs for this Upsert.
     * @var \SquareConnect\Model\CatalogIdMapping[]
     */
    protected $id_mappings = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["errors" => "\\SquareConnect\\Model\\Error[]", "catalog_object" => "\\SquareConnect\\Model\\CatalogObject", "id_mappings" => "\\SquareConnect\\Model\\CatalogIdMapping[]"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["errors" => "errors", "catalog_object" => "catalog_object", "id_mappings" => "id_mappings"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["errors" => "setErrors", "catalog_object" => "setCatalogObject", "id_mappings" => "setIdMappings"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["errors" => "getErrors", "catalog_object" => "getCatalogObject", "id_mappings" => "getIdMappings"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["errors"])) {
                $this->errors = $data["errors"];
            } else {
                $this->errors = NULL;
            }
            if (isset($data["catalog_object"])) {
                $this->catalog_object = $data["catalog_object"];
            } else {
                $this->catalog_object = NULL;
            }
            if (isset($data["id_mappings"])) {
                $this->id_mappings = $data["id_mappings"];
            } else {
                $this->id_mappings = NULL;
            }
        }
    }
    public function getErrors()
    {
        return $this->errors;
    }
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }
    public function getCatalogObject()
    {
        return $this->catalog_object;
    }
    public function setCatalogObject($catalog_object)
    {
        $this->catalog_object = $catalog_object;
        return $this;
    }
    public function getIdMappings()
    {
        return $this->id_mappings;
    }
    public function setIdMappings($id_mappings)
    {
        $this->id_mappings = $id_mappings;
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