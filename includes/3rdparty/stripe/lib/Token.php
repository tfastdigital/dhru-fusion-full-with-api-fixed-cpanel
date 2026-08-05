<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Token
 *
 * @property string $id
 * @property string $object
 * @property BankAccount $bank_account
 * @property Card $card
 * @property string $client_ip
 * @property int $created
 * @property bool $livemode
 * @property string $type
 * @property bool $used
 *
 * @package Stripe
 */
class Token extends ApiResource
{
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    const OBJECT_NAME = "token";
    const TYPE_ACCOUNT = "account";
    const TYPE_BANK_ACCOUNT = "bank_account";
    const TYPE_CARD = "card";
    const TYPE_PII = "pii";
}

?>