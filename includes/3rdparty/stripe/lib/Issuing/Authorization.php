<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Issuing;

/**
 * Class Authorization
 *
 * @property string $id
 * @property string $object
 * @property bool $approved
 * @property string $authorization_method
 * @property int $authorized_amount
 * @property string $authorized_currency
 * @property \Stripe\Collection $balance_transactions
 * @property Card $card
 * @property Cardholder $cardholder
 * @property int $created
 * @property int $held_amount
 * @property string $held_currency
 * @property bool $is_held_amount_controllable
 * @property bool $livemode
 * @property mixed $merchant_data
 * @property \Stripe\StripeObject $metadata
 * @property int $pending_authorized_amount
 * @property int $pending_held_amount
 * @property mixed $request_history
 * @property string $status
 * @property \Stripe\Collection $transactions
 * @property mixed $verification_data
 *
 * @package Stripe\Issuing
 */
class Authorization extends \Stripe\ApiResource
{
    use \Stripe\ApiOperations\All;
    use \Stripe\ApiOperations\Retrieve;
    use \Stripe\ApiOperations\Update;
    const OBJECT_NAME = "issuing.authorization";
    public function approve($params = NULL, $options = NULL)
    {
        $url = $this->instanceUrl() . "/approve";
        list($response, $opts) = $this->_request("post", $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    public function decline($params = NULL, $options = NULL)
    {
        $url = $this->instanceUrl() . "/decline";
        list($response, $opts) = $this->_request("post", $url, $params, $options);
        $this->refreshFrom($response, $opts);
        return $this;
    }
}

?>