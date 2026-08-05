<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace SquareConnect\Model;

/**
 * CreateCheckoutRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateCheckoutRequest implements \ArrayAccess
{
    /**
     * $idempotency_key A unique string that identifies this checkout among others you've created. It can be any valid string but must be unique for every order sent to Square Checkout for a given location ID.  The idempotency key is used to avoid processing the same order more than once. If you're unsure whether a particular checkout was created successfully, you can reattempt it with the same idempotency key and all the same other parameters without worrying about creating duplicates.  We recommend using a random number/string generator native to the language you are working in to generate strings for your idempotency keys.  See [Idempotency](/basics/api101/idempotency) for more information.
     * @var string
     */
    protected $idempotency_key = NULL;
    /**
     * $order The order including line items to be checked out.
     * @var \SquareConnect\Model\CreateOrderRequest
     */
    protected $order = NULL;
    /**
     * $ask_for_shipping_address If `true`, Square Checkout will collect shipping information on your behalf and store that information with the transaction information in your Square Dashboard.  Default: `false`.
     * @var bool
     */
    protected $ask_for_shipping_address = NULL;
    /**
     * $merchant_support_email The email address to display on the Square Checkout confirmation page and confirmation email that the buyer can use to contact the merchant.  If this value is not set, the confirmation page and email will display the primary email address associated with the merchant's Square account.  Default: none; only exists if explicitly set.
     * @var string
     */
    protected $merchant_support_email = NULL;
    /**
     * $pre_populate_buyer_email If provided, the buyer's email is pre-populated on the checkout page as an editable text field.  Default: none; only exists if explicitly set.
     * @var string
     */
    protected $pre_populate_buyer_email = NULL;
    /**
     * $pre_populate_shipping_address If provided, the buyer's shipping info is pre-populated on the checkout page as editable text fields.  Default: none; only exists if explicitly set.
     * @var \SquareConnect\Model\Address
     */
    protected $pre_populate_shipping_address = NULL;
    /**
     * $redirect_url The URL to redirect to after checkout is completed with `checkoutId`, Square's `orderId`, `transactionId`, and `referenceId` appended as URL parameters. For example, if the provided redirect_url is `http://www.example.com/order-complete`, a successful transaction redirects the customer to:  `http://www.example.com/order-complete?checkoutId=xxxxxx&orderId=xxxxxx&referenceId=xxxxxx&transactionId=xxxxxx`  If you do not provide a redirect URL, Square Checkout will display an order confirmation page on your behalf; however Square strongly recommends that you provide a redirect URL so you can verify the transaction results and finalize the order through your existing/normal confirmation workflow.  Default: none; only exists if explicitly set.
     * @var string
     */
    protected $redirect_url = NULL;
    /**
     * $additional_recipients The basic primitive of multi-party transaction. The value is optional. The transaction facilitated by you can be split from here.  If you provide this value, the `amount_money` value in your additional_recipients must not be more than 90% of the `total_money` calculated by Square for your order. The `location_id` must be the valid location of the app owner merchant.  This field requires `PAYMENTS_WRITE_ADDITIONAL_RECIPIENTS` OAuth permission.  This field is currently not supported in sandbox.
     * @var \SquareConnect\Model\ChargeRequestAdditionalRecipient[]
     */
    protected $additional_recipients = NULL;
    /**
     * $note An optional note to associate with the checkout object.  This value cannot exceed 60 characters.
     * @var string
     */
    protected $note = NULL;
    /**
     * Array of property to type mappings. Used for (de)serialization 
     * @var string[]
     */
    public static $swaggerTypes = ["idempotency_key" => "string", "order" => "\\SquareConnect\\Model\\CreateOrderRequest", "ask_for_shipping_address" => "bool", "merchant_support_email" => "string", "pre_populate_buyer_email" => "string", "pre_populate_shipping_address" => "\\SquareConnect\\Model\\Address", "redirect_url" => "string", "additional_recipients" => "\\SquareConnect\\Model\\ChargeRequestAdditionalRecipient[]", "note" => "string"];
    /** 
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[] 
     */
    public static $attributeMap = ["idempotency_key" => "idempotency_key", "order" => "order", "ask_for_shipping_address" => "ask_for_shipping_address", "merchant_support_email" => "merchant_support_email", "pre_populate_buyer_email" => "pre_populate_buyer_email", "pre_populate_shipping_address" => "pre_populate_shipping_address", "redirect_url" => "redirect_url", "additional_recipients" => "additional_recipients", "note" => "note"];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    public static $setters = ["idempotency_key" => "setIdempotencyKey", "order" => "setOrder", "ask_for_shipping_address" => "setAskForShippingAddress", "merchant_support_email" => "setMerchantSupportEmail", "pre_populate_buyer_email" => "setPrePopulateBuyerEmail", "pre_populate_shipping_address" => "setPrePopulateShippingAddress", "redirect_url" => "setRedirectUrl", "additional_recipients" => "setAdditionalRecipients", "note" => "setNote"];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    public static $getters = ["idempotency_key" => "getIdempotencyKey", "order" => "getOrder", "ask_for_shipping_address" => "getAskForShippingAddress", "merchant_support_email" => "getMerchantSupportEmail", "pre_populate_buyer_email" => "getPrePopulateBuyerEmail", "pre_populate_shipping_address" => "getPrePopulateShippingAddress", "redirect_url" => "getRedirectUrl", "additional_recipients" => "getAdditionalRecipients", "note" => "getNote"];
    public function __construct($data = NULL)
    {
        if ($data != NULL) {
            if (isset($data["idempotency_key"])) {
                $this->idempotency_key = $data["idempotency_key"];
            } else {
                $this->idempotency_key = NULL;
            }
            if (isset($data["order"])) {
                $this->order = $data["order"];
            } else {
                $this->order = NULL;
            }
            if (isset($data["ask_for_shipping_address"])) {
                $this->ask_for_shipping_address = $data["ask_for_shipping_address"];
            } else {
                $this->ask_for_shipping_address = NULL;
            }
            if (isset($data["merchant_support_email"])) {
                $this->merchant_support_email = $data["merchant_support_email"];
            } else {
                $this->merchant_support_email = NULL;
            }
            if (isset($data["pre_populate_buyer_email"])) {
                $this->pre_populate_buyer_email = $data["pre_populate_buyer_email"];
            } else {
                $this->pre_populate_buyer_email = NULL;
            }
            if (isset($data["pre_populate_shipping_address"])) {
                $this->pre_populate_shipping_address = $data["pre_populate_shipping_address"];
            } else {
                $this->pre_populate_shipping_address = NULL;
            }
            if (isset($data["redirect_url"])) {
                $this->redirect_url = $data["redirect_url"];
            } else {
                $this->redirect_url = NULL;
            }
            if (isset($data["additional_recipients"])) {
                $this->additional_recipients = $data["additional_recipients"];
            } else {
                $this->additional_recipients = NULL;
            }
            if (isset($data["note"])) {
                $this->note = $data["note"];
            } else {
                $this->note = NULL;
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
    public function getOrder()
    {
        return $this->order;
    }
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }
    public function getAskForShippingAddress()
    {
        return $this->ask_for_shipping_address;
    }
    public function setAskForShippingAddress($ask_for_shipping_address)
    {
        $this->ask_for_shipping_address = $ask_for_shipping_address;
        return $this;
    }
    public function getMerchantSupportEmail()
    {
        return $this->merchant_support_email;
    }
    public function setMerchantSupportEmail($merchant_support_email)
    {
        $this->merchant_support_email = $merchant_support_email;
        return $this;
    }
    public function getPrePopulateBuyerEmail()
    {
        return $this->pre_populate_buyer_email;
    }
    public function setPrePopulateBuyerEmail($pre_populate_buyer_email)
    {
        $this->pre_populate_buyer_email = $pre_populate_buyer_email;
        return $this;
    }
    public function getPrePopulateShippingAddress()
    {
        return $this->pre_populate_shipping_address;
    }
    public function setPrePopulateShippingAddress($pre_populate_shipping_address)
    {
        $this->pre_populate_shipping_address = $pre_populate_shipping_address;
        return $this;
    }
    public function getRedirectUrl()
    {
        return $this->redirect_url;
    }
    public function setRedirectUrl($redirect_url)
    {
        $this->redirect_url = $redirect_url;
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
    public function getNote()
    {
        return $this->note;
    }
    public function setNote($note)
    {
        $this->note = $note;
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