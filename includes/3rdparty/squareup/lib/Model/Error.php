<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * Error Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class Error implements \ArrayAccess
{
    /**
     * $category The error's high-level category. See [ErrorCategory](#type-errorcategory) for possible values
     * @var string
     */
    protected $category = NULL;
    /**
     * $code The error's specific code. See [ErrorCode](#type-errorcode) for possible values
     * @var string
     */
    protected $code = NULL;
    /**
     * $detail A human-readable description of the error for debugging purposes.
     * @var string
     */
    protected $detail = NULL;
    /**
     * $field The name of the field provided in the original request that the error pertains to, if any.
     * @var string
     */
    protected $field = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["category" => "string", "code" => "string", "detail" => "string", "field" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["category" => "category", "code" => "code", "detail" => "detail", "field" => "field"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["category" => "setCategory", "code" => "setCode", "detail" => "setDetail", "field" => "setField"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["category" => "getCategory", "code" => "getCode", "detail" => "getDetail", "field" => "getField"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["category"])) {
                $this->category = $data["category"];
            } else {
                $this->category = NULL;
            }
            if (isset($data["code"])) {
                $this->code = $data["code"];
            } else {
                $this->code = NULL;
            }
            if (isset($data["detail"])) {
                $this->detail = $data["detail"];
            } else {
                $this->detail = NULL;
            }
            if (isset($data["field"])) {
                $this->field = $data["field"];
            } else {
                $this->field = NULL;
            }
        }
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }
    public function getCode()
    {
        return $this->code;
    }
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    public function getDetail()
    {
        return $this->detail;
    }
    public function setDetail($detail)
    {
        $this->detail = $detail;
        return $this;
    }
    public function getField()
    {
        return $this->field;
    }
    public function setField($field)
    {
        $this->field = $field;
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