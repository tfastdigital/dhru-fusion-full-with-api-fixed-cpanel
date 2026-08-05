<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class EphemeralKey
 *
 * @property string $id
 * @property string $object
 * @property int $created
 * @property int $expires
 * @property bool $livemode
 * @property string $secret
 * @property array $associated_objects
 *
 * @package Stripe
 */
class EphemeralKey extends ApiResource
{
    use ApiOperations\Create;
    use ApiOperations\Delete;
    const OBJECT_NAME = "ephemeral_key";
    public static function create($params = NULL, $opts = NULL)
    {
        if (!$opts["stripe_version"]) {
            throw new \InvalidArgumentException("stripe_version must be specified to create an ephemeral key");
        }
        return self::_create($params, $opts);
    }
}

?>