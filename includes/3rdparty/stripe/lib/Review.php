<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Review
 *
 * @property string $id
 * @property string $object
 * @property string $billing_zip
 * @property string $charge
 * @property string $closed_reason
 * @property int $created
 * @property string $ip_address
 * @property mixed $ip_address_location
 * @property bool $livemode
 * @property bool $open
 * @property string $opened_reason
 * @property string $payment_intent
 * @property string $reason
 * @property mixed $session
 *
 * @package Stripe
 */
class Review extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Retrieve;
    const OBJECT_NAME = "review";
    const REASON_APPROVED = "approved";
    const REASON_DISPUTED = "disputed";
    const REASON_MANUAL = "manual";
    const REASON_REFUNDED = "refunded";
    const REASON_REFUNDED_AS_FRAUD = "refunded_as_fraud";
    const REASON_RULE = "rule";
    public function approve($params = NULL, $options = NULL)
    {
        $url = $this->instanceUrl() . "/approve";
        list($response, $opts) = $this->_request("post", $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }
}

?>