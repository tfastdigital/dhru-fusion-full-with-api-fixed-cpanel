<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * TenderCardDetails Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class TenderCardDetails implements \ArrayAccess
{
    /**
     * $status The credit card payment's current state (such as `AUTHORIZED` or `CAPTURED`). See [TenderCardDetailsStatus](#type-tendercarddetailsstatus) for possible values
     * @var string
     */
    protected $status = NULL;
    /**
     * $card The credit card's non-confidential details.
     * @var \SquareConnect\Model\Card
     */
    protected $card = NULL;
    /**
     * $entry_method The method used to enter the card's details for the transaction. See [TenderCardDetailsEntryMethod](#type-tendercarddetailsentrymethod) for possible values
     * @var string
     */
    protected $entry_method = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["status" => "string", "card" => "\\SquareConnect\\Model\\Card", "entry_method" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["status" => "status", "card" => "card", "entry_method" => "entry_method"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["status" => "setStatus", "card" => "setCard", "entry_method" => "setEntryMethod"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["status" => "getStatus", "card" => "getCard", "entry_method" => "getEntryMethod"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["status"])) {
                $this->status = $data["status"];
            } else {
                $this->status = NULL;
            }
            if (isset($data["card"])) {
                $this->card = $data["card"];
            } else {
                $this->card = NULL;
            }
            if (isset($data["entry_method"])) {
                $this->entry_method = $data["entry_method"];
            } else {
                $this->entry_method = NULL;
            }
        }
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    public function getCard()
    {
        return $this->card;
    }
    public function setCard($card)
    {
        $this->card = $card;
        return $this;
    }
    public function getEntryMethod()
    {
        return $this->entry_method;
    }
    public function setEntryMethod($entry_method)
    {
        $this->entry_method = $entry_method;
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