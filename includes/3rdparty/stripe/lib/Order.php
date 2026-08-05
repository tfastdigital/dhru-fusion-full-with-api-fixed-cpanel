<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Order
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property int $amount_returned
 * @property string $application
 * @property int $application_fee
 * @property string $charge
 * @property int $created
 * @property string $currency
 * @property string $customer
 * @property string $email
 * @property string $external_coupon_code
 * @property OrderItem[] $items
 * @property bool $livemode
 * @property StripeObject $metadata
 * @property Collection $returns
 * @property string $selected_shipping_method
 * @property mixed $shipping
 * @property mixed $shipping_methods
 * @property string $status
 * @property mixed $status_transitions
 * @property int $updated
 * @property string $upstream_id
 *
 * @package Stripe
 */
class Order extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "order";
    public function pay($params = NULL, $opts = NULL)
    {
        $url = $this->instanceUrl() . "/pay";
        list($response, $opts) = $this->_request("post", $url, $params, $opts);
        $this->refreshFrom($response, $opts);
        return $this;
    }
    public function returnOrder($params = NULL, $opts = NULL)
    {
        $url = $this->instanceUrl() . "/returns";
        list($response, $opts) = $this->_request("post", $url, $params, $opts);
        return Util\Util::convertToStripeObject($response, $opts);
    }
}

?>