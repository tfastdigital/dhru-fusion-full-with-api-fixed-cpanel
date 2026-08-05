<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateRefundResponse Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateRefundResponse implements \ArrayAccess
{
    /**
     * $errors Any errors that occurred during the request.
     * @var \SquareConnect\Model\Error[]
     */
    protected $errors = NULL;
    /**
     * $refund The created refund.
     * @var \SquareConnect\Model\Refund
     */
    protected $refund = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["errors" => "\\SquareConnect\\Model\\Error[]", "refund" => "\\SquareConnect\\Model\\Refund"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["errors" => "errors", "refund" => "refund"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["errors" => "setErrors", "refund" => "setRefund"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["errors" => "getErrors", "refund" => "getRefund"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["errors"])) {
                $this->errors = $data["errors"];
            } else {
                $this->errors = NULL;
            }
            if (isset($data["refund"])) {
                $this->refund = $data["refund"];
            } else {
                $this->refund = NULL;
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
    public function getRefund()
    {
        return $this->refund;
    }
    public function setRefund($refund)
    {
        $this->refund = $refund;
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