<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class Recipient
 *
 * @package Stripe
 *
 * @property string $id
 * @property string $object
 * @property mixed $active_account
 * @property Collection $cards
 * @property int $created
 * @property string $default_card
 * @property string $description
 * @property string $email
 * @property bool $livemode
 * @property StripeObject $metadata
 * @property string $migrated_to
 * @property string $name
 * @property string $rolled_back_from
 * @property string $type
 */
class Recipient extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;
    const OBJECT_NAME = "recipient";
    public function transfers($params = NULL)
    {
        $params = $params ?: [];
        $params["recipient"] = $this->id;
        $transfers = Transfer::all($params, $this->_opts);
        return $transfers;
    }
}

?>