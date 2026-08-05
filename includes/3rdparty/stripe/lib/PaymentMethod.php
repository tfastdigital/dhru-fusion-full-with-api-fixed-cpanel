<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class PaymentMethod
 *
 * @property string $id
 * @property string $object
 * @property mixed $billing_details
 * @property mixed $card
 * @property mixed $card_present
 * @property int $created
 * @property string $customer
 * @property mixed $ideal
 * @property bool $livemode
 * @property StripeObject $metadata
 * @property mixed $sepa_debit
 * @property string $type
 *
 * @package Stripe
 */
class PaymentMethod extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "payment_method";
    public function attach($params = NULL, $opts = NULL)
    {
        $url = $this->instanceUrl() . "/attach";
        list($response, $opts) = $this->_request("post", $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    public function detach($params = NULL, $opts = NULL)
    {
        $url = $this->instanceUrl() . "/detach";
        list($response, $opts) = $this->_request("post", $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
}

?>