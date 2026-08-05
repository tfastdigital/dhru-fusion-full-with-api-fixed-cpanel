<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * RetrieveInventoryChangesRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class RetrieveInventoryChangesRequest implements \ArrayAccess
{
    /**
     * $location_ids The [Location](#type-location) IDs to look up as a comma-separated list. An empty list queries all locations.
     * @var string
     */
    protected $location_ids = NULL;
    /**
     * $cursor A pagination cursor returned by a previous call to this endpoint. Provide this to retrieve the next set of results for the original query.  See [Pagination](/basics/api101/pagination) for more information.
     * @var string
     */
    protected $cursor = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["location_ids" => "string", "cursor" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["location_ids" => "location_ids", "cursor" => "cursor"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["location_ids" => "setLocationIds", "cursor" => "setCursor"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["location_ids" => "getLocationIds", "cursor" => "getCursor"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["location_ids"])) {
                $this->location_ids = $data["location_ids"];
            } else {
                $this->location_ids = NULL;
            }
            if (isset($data["cursor"])) {
                $this->cursor = $data["cursor"];
            } else {
                $this->cursor = NULL;
            }
        }
    }
    public function getLocationIds()
    {
        return $this->location_ids;
    }
    public function setLocationIds($location_ids)
    {
        $this->location_ids = $location_ids;
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