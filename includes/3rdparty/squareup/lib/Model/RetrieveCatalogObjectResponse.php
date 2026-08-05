<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * RetrieveCatalogObjectResponse Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class RetrieveCatalogObjectResponse implements \ArrayAccess
{
    /**
     * $errors The set of [Error](#type-error)s encountered.
     * @var \SquareConnect\Model\Error[]
     */
    protected $errors = NULL;
    /**
     * $object The [CatalogObject](#type-catalogobject)s returned.
     * @var \SquareConnect\Model\CatalogObject
     */
    protected $object = NULL;
    /**
     * $related_objects A list of [CatalogObject](#type-catalogobject)s referenced by the object in the `object` field.
     * @var \SquareConnect\Model\CatalogObject[]
     */
    protected $related_objects = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["errors" => "\\SquareConnect\\Model\\Error[]", "object" => "\\SquareConnect\\Model\\CatalogObject", "related_objects" => "\\SquareConnect\\Model\\CatalogObject[]"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["errors" => "errors", "object" => "object", "related_objects" => "related_objects"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["errors" => "setErrors", "object" => "setObject", "related_objects" => "setRelatedObjects"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["errors" => "getErrors", "object" => "getObject", "related_objects" => "getRelatedObjects"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["errors"])) {
                $this->errors = $data["errors"];
            } else {
                $this->errors = NULL;
            }
            if (isset($data["object"])) {
                $this->object = $data["object"];
            } else {
                $this->object = NULL;
            }
            if (isset($data["related_objects"])) {
                $this->related_objects = $data["related_objects"];
            } else {
                $this->related_objects = NULL;
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
    public function getObject()
    {
        return $this->object;
    }
    public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }
    public function getRelatedObjects()
    {
        return $this->related_objects;
    }
    public function setRelatedObjects($related_objects)
    {
        $this->related_objects = $related_objects;
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