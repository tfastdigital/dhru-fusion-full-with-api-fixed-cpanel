<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class OrderReturn
 *
 * @property string $id
 * @property string $object
 * @property int $amount
 * @property int $created
 * @property string $currency
 * @property OrderItem[] $items
 * @property bool $livemode
 * @property string $order
 * @property string $refund
 *
 * @package Stripe
 */
class OrderReturn extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Retrieve;
    const OBJECT_NAME = "order_return";
}

?>