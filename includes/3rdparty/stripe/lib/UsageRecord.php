<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class UsageRecord
 *
 * @package Stripe
 *
 * @property string $id
 * @property string $object
 * @property bool $livemode
 * @property int $quantity
 * @property string $subscription_item
 * @property int $timestamp
 */
class UsageRecord extends ApiResource
{
    const OBJECT_NAME = "usage_record";
    public static function create($params = NULL, $options = NULL)
    {
        self::_validateParams($params);
        if (!array_key_exists("subscription_item", $params)) {
            throw new Error\InvalidRequest("Missing subscription_item param in request", NULL);
        }
        $subscription_item = $params["subscription_item"];
        $url = "/v1/subscription_items/" . $subscription_item . "/usage_records";
        $request_params = $params;
        unset($request_params["subscription_item"]);
        list($response, $opts) = static::_staticRequest("post", $url, $request_params, $options);
        $obj = Util\Util::convertToStripeObject($response->json, $opts);
        $obj->setLastResponse($response);
        return $obj;
    }
}

?>