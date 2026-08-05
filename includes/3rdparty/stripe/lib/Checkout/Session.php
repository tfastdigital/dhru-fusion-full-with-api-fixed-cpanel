<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Checkout;

/**
 * Class Session
 *
 * @property string $id
 * @property string $object
 * @property string $cancel_url
 * @property string $client_reference_id
 * @property string $customer
 * @property string $customer_email
 * @property mixed $display_items
 * @property bool $livemode
 * @property string $payment_intent
 * @property string[] $payment_method_types
 * @property string $subscription
 * @property string $success_url
 *
 * @package Stripe
 */
class Session extends \Stripe\ApiResource
{
    use \Stripe\ApiOperations\Create;
    use \Stripe\ApiOperations\Retrieve;
    const OBJECT_NAME = "checkout.session";
}

?>