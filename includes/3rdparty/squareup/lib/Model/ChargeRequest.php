<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * ChargeRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class ChargeRequest implements \ArrayAccess
{
    /**
     * $idempotency_key A value you specify that uniquely identifies this transaction among transactions you've created.  If you're unsure whether a particular transaction succeeded, you can reattempt it with the same idempotency key without worrying about double-charging the buyer.  See [Idempotency](/basics/api101/idempotency) for more information.
     * @var string
     */
    protected $idempotency_key = NULL;
    /**
     * $amount_money The amount of money to charge.  Note that you specify the amount in the __smallest denomination of the applicable currency__. For example, US dollar amounts are specified in cents. See [Working with monetary amounts](#workingwithmonetaryamounts) for details.  The value of `currency` must match the currency associated with the business that is charging the card.
     * @var \SquareConnect\Model\Money
     */
    protected $amount_money = NULL;
    /**
     * $card_nonce A nonce generated from the `SqPaymentForm` that represents the card to charge.  The application that provides a nonce to this endpoint must be the _same application_ that generated the nonce with the `SqPaymentForm`. Otherwise, the nonce is invalid.  Do not provide a value for this field if you provide a value for `customer_card_id`.
     * @var string
     */
    protected $card_nonce = NULL;
    /**
     * $customer_card_id The ID of the customer card on file to charge. Do not provide a value for this field if you provide a value for `card_nonce`.  If you provide this value, you _must_ also provide a value for `customer_id`.
     * @var string
     */
    protected $customer_card_id = NULL;
    /**
     * $delay_capture If `true`, the request will only perform an Auth on the provided card. You can then later perform either a Capture (with the [CaptureTransaction](#endpoint-capturetransaction) endpoint) or a Void (with the [VoidTransaction](#endpoint-voidtransaction) endpoint).  Default value: `false`
     * @var bool
     */
    protected $delay_capture = NULL;
    /**
     * $reference_id An optional ID you can associate with the transaction for your own purposes (such as to associate the transaction with an entity ID in your own database).  This value cannot exceed 40 characters.
     * @var string
     */
    protected $reference_id = NULL;
    /**
     * $note An optional note to associate with the transaction.  This value cannot exceed 60 characters.
     * @var string
     */
    protected $note = NULL;
    /**
     * $customer_id The ID of the customer to associate this transaction with. This field is required if you provide a value for `customer_card_id`, and optional otherwise.
     * @var string
     */
    protected $customer_id = NULL;
    /**
     * $billing_address The buyer's billing address.
     * @var \SquareConnect\Model\Address
     */
    protected $billing_address = NULL;
    /**
     * $shipping_address The buyer's shipping address, if available.
     * @var \SquareConnect\Model\Address
     */
    protected $shipping_address = NULL;
    /**
     * $buyer_email_address The buyer's email address, if available.
     * @var string
     */
    protected $buyer_email_address = NULL;
    /**
     * $order_id The ID of the order to associate with this transaction.  If you provide this value, the `amount_money` value of your request must __exactly match__ the value of the order's `total_money` field.
     * @var string
     */
    protected $order_id = NULL;
    /**
     * $additional_recipients The basic primitive of multi-party transaction. The value is optional. The transaction facilitated by you can be split from here.  If you provide this value, the `amount_money` value in your additional_recipients must not be more than 90% of the `amount_money` value in the charge request. The `location_id` must be the valid location of the app owner merchant.  This field requires the `PAYMENTS_WRITE_ADDITIONAL_RECIPIENTS` OAuth permission.  This field is currently not supported in sandbox.
     * @var \SquareConnect\Model\AdditionalRecipient[]
     */
    protected $additional_recipients = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["idempotency_key" => "string", "amount_money" => "\\SquareConnect\\Model\\Money", "card_nonce" => "string", "customer_card_id" => "string", "delay_capture" => "bool", "reference_id" => "string", "note" => "string", "customer_id" => "string", "billing_address" => "\\SquareConnect\\Model\\Address", "shipping_address" => "\\SquareConnect\\Model\\Address", "buyer_email_address" => "string", "order_id" => "string", "additional_recipients" => "\\SquareConnect\\Model\\AdditionalRecipient[]"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["idempotency_key" => "idempotency_key", "amount_money" => "amount_money", "card_nonce" => "card_nonce", "customer_card_id" => "customer_card_id", "delay_capture" => "delay_capture", "reference_id" => "reference_id", "note" => "note", "customer_id" => "customer_id", "billing_address" => "billing_address", "shipping_address" => "shipping_address", "buyer_email_address" => "buyer_email_address", "order_id" => "order_id", "additional_recipients" => "additional_recipients"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["idempotency_key" => "setIdempotencyKey", "amount_money" => "setAmountMoney", "card_nonce" => "setCardNonce", "customer_card_id" => "setCustomerCardId", "delay_capture" => "setDelayCapture", "reference_id" => "setReferenceId", "note" => "setNote", "customer_id" => "setCustomerId", "billing_address" => "setBillingAddress", "shipping_address" => "setShippingAddress", "buyer_email_address" => "setBuyerEmailAddress", "order_id" => "setOrderId", "additional_recipients" => "setAdditionalRecipients"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["idempotency_key" => "getIdempotencyKey", "amount_money" => "getAmountMoney", "card_nonce" => "getCardNonce", "customer_card_id" => "getCustomerCardId", "delay_capture" => "getDelayCapture", "reference_id" => "getReferenceId", "note" => "getNote", "customer_id" => "getCustomerId", "billing_address" => "getBillingAddress", "shipping_address" => "getShippingAddress", "buyer_email_address" => "getBuyerEmailAddress", "order_id" => "getOrderId", "additional_recipients" => "getAdditionalRecipients"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["idempotency_key"])) {
                $this->idempotency_key = $data["idempotency_key"];
            } else {
                $this->idempotency_key = NULL;
            }
            if (isset($data["amount_money"])) {
                $this->amount_money = $data["amount_money"];
            } else {
                $this->amount_money = NULL;
            }
            if (isset($data["card_nonce"])) {
                $this->card_nonce = $data["card_nonce"];
            } else {
                $this->card_nonce = NULL;
            }
            if (isset($data["customer_card_id"])) {
                $this->customer_card_id = $data["customer_card_id"];
            } else {
                $this->customer_card_id = NULL;
            }
            if (isset($data["delay_capture"])) {
                $this->delay_capture = $data["delay_capture"];
            } else {
                $this->delay_capture = NULL;
            }
            if (isset($data["reference_id"])) {
                $this->reference_id = $data["reference_id"];
            } else {
                $this->reference_id = NULL;
            }
            if (isset($data["note"])) {
                $this->note = $data["note"];
            } else {
                $this->note = NULL;
            }
            if (isset($data["customer_id"])) {
                $this->customer_id = $data["customer_id"];
            } else {
                $this->customer_id = NULL;
            }
            if (isset($data["billing_address"])) {
                $this->billing_address = $data["billing_address"];
            } else {
                $this->billing_address = NULL;
            }
            if (isset($data["shipping_address"])) {
                $this->shipping_address = $data["shipping_address"];
            } else {
                $this->shipping_address = NULL;
            }
            if (isset($data["buyer_email_address"])) {
                $this->buyer_email_address = $data["buyer_email_address"];
            } else {
                $this->buyer_email_address = NULL;
            }
            if (isset($data["order_id"])) {
                $this->order_id = $data["order_id"];
            } else {
                $this->order_id = NULL;
            }
            if (isset($data["additional_recipients"])) {
                $this->additional_recipients = $data["additional_recipients"];
            } else {
                $this->additional_recipients = NULL;
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
    public function getAmountMoney()
    {
        return $this->amount_money;
    }
    public function setAmountMoney($amount_money)
    {
        $this->amount_money = $amount_money;
        return $this;
    }
    public function getCardNonce()
    {
        return $this->card_nonce;
    }
    public function setCardNonce($card_nonce)
    {
        $this->card_nonce = $card_nonce;
        return $this;
    }
    public function getCustomerCardId()
    {
        return $this->customer_card_id;
    }
    public function setCustomerCardId($customer_card_id)
    {
        $this->customer_card_id = $customer_card_id;
        return $this;
    }
    public function getDelayCapture()
    {
        return $this->delay_capture;
    }
    public function setDelayCapture($delay_capture)
    {
        $this->delay_capture = $delay_capture;
        return $this;
    }
    public function getReferenceId()
    {
        return $this->reference_id;
    }
    public function setReferenceId($reference_id)
    {
        $this->reference_id = $reference_id;
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
    public function getCustomerId()
    {
        return $this->customer_id;
    }
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
        return $this;
    }
    public function getBillingAddress()
    {
        return $this->billing_address;
    }
    public function setBillingAddress($billing_address)
    {
        $this->billing_address = $billing_address;
        return $this;
    }
    public function getShippingAddress()
    {
        return $this->shipping_address;
    }
    public function setShippingAddress($shipping_address)
    {
        $this->shipping_address = $shipping_address;
        return $this;
    }
    public function getBuyerEmailAddress()
    {
        return $this->buyer_email_address;
    }
    public function setBuyerEmailAddress($buyer_email_address)
    {
        $this->buyer_email_address = $buyer_email_address;
        return $this;
    }
    public function getOrderId()
    {
        return $this->order_id;
    }
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
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