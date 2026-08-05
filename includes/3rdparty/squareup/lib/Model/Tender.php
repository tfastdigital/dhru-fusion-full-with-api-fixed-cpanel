<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * Tender Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class Tender implements \ArrayAccess
{
    /**
     * $id The tender's unique ID.
     * @var string
     */
    protected $id = NULL;
    /**
     * $location_id The ID of the transaction's associated location.
     * @var string
     */
    protected $location_id = NULL;
    /**
     * $transaction_id The ID of the tender's associated transaction.
     * @var string
     */
    protected $transaction_id = NULL;
    /**
     * $created_at The time when the tender was created, in RFC 3339 format.
     * @var string
     */
    protected $created_at = NULL;
    /**
     * $note An optional note associated with the tender at the time of payment.
     * @var string
     */
    protected $note = NULL;
    /**
     * $amount_money The amount of the tender.
     * @var \SquareConnect\Model\Money
     */
    protected $amount_money = NULL;
    /**
     * $tip_money The tip's amount of the tender.
     * @var \SquareConnect\Model\Money
     */
    protected $tip_money = NULL;
    /**
     * $processing_fee_money The amount of any Square processing fees applied to the tender.  This field is not immediately populated when a new transaction is created. It is usually available after about ten seconds.
     * @var \SquareConnect\Model\Money
     */
    protected $processing_fee_money = NULL;
    /**
     * $customer_id If the tender is associated with a customer or represents a customer's card on file, this is the ID of the associated customer.
     * @var string
     */
    protected $customer_id = NULL;
    /**
     * $type The type of tender, such as `CARD` or `CASH`. See [TenderType](#type-tendertype) for possible values
     * @var string
     */
    protected $type = NULL;
    /**
     * $card_details The details of the card tender.  This value is present only if the value of `type` is `CARD`.
     * @var \SquareConnect\Model\TenderCardDetails
     */
    protected $card_details = NULL;
    /**
     * $cash_details The details of the cash tender.  This value is present only if the value of `type` is `CASH`.
     * @var \SquareConnect\Model\TenderCashDetails
     */
    protected $cash_details = NULL;
    /**
     * $additional_recipients Additional recipients (other than the merchant) receiving a portion of this tender. For example, fees assessed on the purchase by a third party integration.
     * @var \SquareConnect\Model\AdditionalRecipient[]
     */
    protected $additional_recipients = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["id" => "string", "location_id" => "string", "transaction_id" => "string", "created_at" => "string", "note" => "string", "amount_money" => "\\SquareConnect\\Model\\Money", "tip_money" => "\\SquareConnect\\Model\\Money", "processing_fee_money" => "\\SquareConnect\\Model\\Money", "customer_id" => "string", "type" => "string", "card_details" => "\\SquareConnect\\Model\\TenderCardDetails", "cash_details" => "\\SquareConnect\\Model\\TenderCashDetails", "additional_recipients" => "\\SquareConnect\\Model\\AdditionalRecipient[]"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["id" => "id", "location_id" => "location_id", "transaction_id" => "transaction_id", "created_at" => "created_at", "note" => "note", "amount_money" => "amount_money", "tip_money" => "tip_money", "processing_fee_money" => "processing_fee_money", "customer_id" => "customer_id", "type" => "type", "card_details" => "card_details", "cash_details" => "cash_details", "additional_recipients" => "additional_recipients"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["id" => "setId", "location_id" => "setLocationId", "transaction_id" => "setTransactionId", "created_at" => "setCreatedAt", "note" => "setNote", "amount_money" => "setAmountMoney", "tip_money" => "setTipMoney", "processing_fee_money" => "setProcessingFeeMoney", "customer_id" => "setCustomerId", "type" => "setType", "card_details" => "setCardDetails", "cash_details" => "setCashDetails", "additional_recipients" => "setAdditionalRecipients"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["id" => "getId", "location_id" => "getLocationId", "transaction_id" => "getTransactionId", "created_at" => "getCreatedAt", "note" => "getNote", "amount_money" => "getAmountMoney", "tip_money" => "getTipMoney", "processing_fee_money" => "getProcessingFeeMoney", "customer_id" => "getCustomerId", "type" => "getType", "card_details" => "getCardDetails", "cash_details" => "getCashDetails", "additional_recipients" => "getAdditionalRecipients"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["id"])) {
                $this->id = $data["id"];
            } else {
                $this->id = NULL;
            }
            if (isset($data["location_id"])) {
                $this->location_id = $data["location_id"];
            } else {
                $this->location_id = NULL;
            }
            if (isset($data["transaction_id"])) {
                $this->transaction_id = $data["transaction_id"];
            } else {
                $this->transaction_id = NULL;
            }
            if (isset($data["created_at"])) {
                $this->created_at = $data["created_at"];
            } else {
                $this->created_at = NULL;
            }
            if (isset($data["note"])) {
                $this->note = $data["note"];
            } else {
                $this->note = NULL;
            }
            if (isset($data["amount_money"])) {
                $this->amount_money = $data["amount_money"];
            } else {
                $this->amount_money = NULL;
            }
            if (isset($data["tip_money"])) {
                $this->tip_money = $data["tip_money"];
            } else {
                $this->tip_money = NULL;
            }
            if (isset($data["processing_fee_money"])) {
                $this->processing_fee_money = $data["processing_fee_money"];
            } else {
                $this->processing_fee_money = NULL;
            }
            if (isset($data["customer_id"])) {
                $this->customer_id = $data["customer_id"];
            } else {
                $this->customer_id = NULL;
            }
            if (isset($data["type"])) {
                $this->type = $data["type"];
            } else {
                $this->type = NULL;
            }
            if (isset($data["card_details"])) {
                $this->card_details = $data["card_details"];
            } else {
                $this->card_details = NULL;
            }
            if (isset($data["cash_details"])) {
                $this->cash_details = $data["cash_details"];
            } else {
                $this->cash_details = NULL;
            }
            if (isset($data["additional_recipients"])) {
                $this->additional_recipients = $data["additional_recipients"];
            } else {
                $this->additional_recipients = NULL;
            }
        }
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getLocationId()
    {
        return $this->location_id;
    }
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }
    public function getTransactionId()
    {
        return $this->transaction_id;
    }
    public function setTransactionId($transaction_id)
    {
        $this->transaction_id = $transaction_id;
        return $this;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }
    public function getNote()
    {
        return $this->note;
    }
    public function setNote($note)
    {
        $this->note = $note;
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
    public function getTipMoney()
    {
        return $this->tip_money;
    }
    public function setTipMoney($tip_money)
    {
        $this->tip_money = $tip_money;
        return $this;
    }
    public function getProcessingFeeMoney()
    {
        return $this->processing_fee_money;
    }
    public function setProcessingFeeMoney($processing_fee_money)
    {
        $this->processing_fee_money = $processing_fee_money;
        return $this;
    }
    public function getCustomerId()
    {
        return $this->customer_id;
    }
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
        return $this;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    public function getCardDetails()
    {
        return $this->card_details;
    }
    public function setCardDetails($card_details)
    {
        $this->card_details = $card_details;
        return $this;
    }
    public function getCashDetails()
    {
        return $this->cash_details;
    }
    public function setCashDetails($cash_details)
    {
        $this->cash_details = $cash_details;
        return $this;
    }
    public function getAdditionalRecipients()
    {
        return $this->additional_recipients;
    }
    public function setAdditionalRecipients($additional_recipients)
    {
        $this->additional_recipients = $additional_recipients;
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