<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateRefundRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateRefundRequest implements \ArrayAccess
{
    /**
     * $idempotency_key A value you specify that uniquely identifies this refund among refunds you've created for the tender.  If you're unsure whether a particular refund succeeded, you can reattempt it with the same idempotency key without worrying about duplicating the refund.  See [Idempotency](/basics/api101/idempotency) for more information.
     * @var string
     */
    protected $idempotency_key = NULL;
    /**
     * $tender_id The ID of the tender to refund.  A [`Transaction`](#type-transaction) has one or more `tenders` (i.e., methods of payment) associated with it, and you refund each tender separately with the Connect API.
     * @var string
     */
    protected $tender_id = NULL;
    /**
     * $reason A description of the reason for the refund.  Default value: `Refund via API`
     * @var string
     */
    protected $reason = NULL;
    /**
     * $amount_money The amount of money to refund.  Note that you specify the amount in the __smallest denomination of the applicable currency__. For example, US dollar amounts are specified in cents. See [Working with monetary amounts](#workingwithmonetaryamounts) for details.  This amount cannot exceed the amount that was originally charged to the tender that corresponds to `tender_id`.
     * @var \SquareConnect\Model\Money
     */
    protected $amount_money = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["idempotency_key" => "string", "tender_id" => "string", "reason" => "string", "amount_money" => "\\SquareConnect\\Model\\Money"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["idempotency_key" => "idempotency_key", "tender_id" => "tender_id", "reason" => "reason", "amount_money" => "amount_money"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["idempotency_key" => "setIdempotencyKey", "tender_id" => "setTenderId", "reason" => "setReason", "amount_money" => "setAmountMoney"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["idempotency_key" => "getIdempotencyKey", "tender_id" => "getTenderId", "reason" => "getReason", "amount_money" => "getAmountMoney"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["idempotency_key"])) {
                $this->idempotency_key = $data["idempotency_key"];
            } else {
                $this->idempotency_key = NULL;
            }
            if (isset($data["tender_id"])) {
                $this->tender_id = $data["tender_id"];
            } else {
                $this->tender_id = NULL;
            }
            if (isset($data["reason"])) {
                $this->reason = $data["reason"];
            } else {
                $this->reason = NULL;
            }
            if (isset($data["amount_money"])) {
                $this->amount_money = $data["amount_money"];
            } else {
                $this->amount_money = NULL;
            }
        }
    }
    public function getIdempotencyKey()
    {
        return $this->idempotency_key;
    }
    public function setIdempotencyKey($idempotency_key)
    {
        $this->idempotency_key = $idempotency_key;
        return $this;
    }
    public function getTenderId()
    {
        return $this->tender_id;
    }
    public function setTenderId($tender_id)
    {
        $this->tender_id = $tender_id;
        return $this;
    }
    public function getReason()
    {
        return $this->reason;
    }
    public function setReason($reason)
    {
        $this->reason = $reason;
        return $this;
    }
    public function getAmountMoney()
    {
        return $this->amount_money;
    }
    public function setAmountMoney($amount_money)
    {
        $this->amount_money = $amount_money;
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