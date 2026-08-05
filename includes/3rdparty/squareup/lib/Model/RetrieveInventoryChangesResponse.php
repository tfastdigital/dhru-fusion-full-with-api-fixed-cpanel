<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * RetrieveInventoryChangesResponse Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class RetrieveInventoryChangesResponse implements \ArrayAccess
{
    /**
     * $errors Any errors that occurred during the request.
     * @var \SquareConnect\Model\Error[]
     */
    protected $errors = NULL;
    /**
     * $changes The set of inventory changes for the requested object and locations.
     * @var \SquareConnect\Model\InventoryChange[]
     */
    protected $changes = NULL;
    /**
     * $cursor The pagination cursor to be used in a subsequent request. If unset, this is the final response.  See [Pagination](/basics/api101/pagination) for more information.
     * @var string
     */
    protected $cursor = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["errors" => "\\SquareConnect\\Model\\Error[]", "changes" => "\\SquareConnect\\Model\\InventoryChange[]", "cursor" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["errors" => "errors", "changes" => "changes", "cursor" => "cursor"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["errors" => "setErrors", "changes" => "setChanges", "cursor" => "setCursor"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["errors" => "getErrors", "changes" => "getChanges", "cursor" => "getCursor"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["errors"])) {
                $this->errors = $data["errors"];
            } else {
                $this->errors = NULL;
            }
            if (isset($data["changes"])) {
                $this->changes = $data["changes"];
            } else {
                $this->changes = NULL;
            }
            if (isset($data["cursor"])) {
                $this->cursor = $data["cursor"];
            } else {
                $this->cursor = NULL;
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
    public function getChanges()
    {
        return $this->changes;
    }
    public function setChanges($changes)
    {
        $this->changes = $changes;
        return $this;
    }
    public function getCursor()
    {
        return $this->cursor;
    }
    public function setCursor($cursor)
    {
        $this->cursor = $cursor;
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